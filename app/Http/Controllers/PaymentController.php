<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plans;
use App\Models\OfferCodes;
use App\Models\Orders;
use Razorpay\Api\Api;
use Illuminate\Support\Str;

class PaymentController extends Controller
{

    // List all orders
    public function orders()
    {
        $user_id = auth()->user()->id;
        $orders = Orders::where('user_id', $user_id)->get();
        return view('pages.credit_orders')->with(compact('orders'));
    }

    // List all plan for purchase page
    public function purchase()
    {
        $plans = Plans::all();
        return view('pages.credit_purchase')->with(compact('plans'));
    }

    // Add discount on plan
    public function discount(Request $request)
    {
        $id = $request->pid;
        $code = $request->code;
        $final_price = $price = "";
        $offer_code = OfferCodes::where('code',$code)->first();
        if(!empty($offer_code)){
            $expire = strtotime($offer_code->expire);
            $today = strtotime("today midnight");
            if($today <= $expire){
                $plan = Plans::select('price')->where('id',$id)->first();
                if(!empty($plan)){
                    $price = $plan->price;
                    if($offer_code->less_type == 'percent'){
                        $total_less = ($offer_code->less / 100) * $price; 
                        $final_price = $price - $total_less;
                    } elseif($offer_code->less_type == 'money'){
                        $final_price = $price - $offer_code->less;
                    }
                    $status = "success";
                    $message = "Woohoo! code ($code) applied successfully.";
                }else{
                    $status = "error";
                    $message = "Plan not found.";
                }
            }else{
                $status = "error";
                $message = "Offer code ($code) has been expired.";
            }
        }else{
            $status = "error";
            $message = "Offer code ($code) not available.";
        }
        echo json_encode(['status' => $status, 'message' => $message, 'price' => $price, 'final_price' => $final_price]);
        die; 
    }

    // Show checkout page
    public function checkout($id)
    {
        if(!empty($id)){
            $plan = Plans::where('id',$id)->first();
            if(!empty($plan)){
                return view('pages.checkout')->with(compact('plan'));
            } else {
                return view('pages.error');
            }
        }
    }

    // Show checkout page
    public function createOrder(Request $request)
    {
        $id = $request->pid;
        $code = $request->code;
        $payment_type = $request->ptype;
        $price = 0;
        if(!empty($id)){
            $plan = Plans::select('credits','price')->where('id',$id)->first();
            $credits = $plan->credits;
            $price = $plan->price;
            $final_price = $price;
        }
        if(!empty($code) && ($price > 0)){
            $offer_code = OfferCodes::where('code',$code)->first();
            if(!empty($offer_code)){
                $expire = strtotime($offer_code->expire);
                $today = strtotime("today midnight");
                if($today <= $expire){                    
                    if($offer_code->less_type == 'percent'){
                        $total_less = ($offer_code->less / 100) * $price; 
                        $final_price = $price - $total_less;
                    } elseif($offer_code->less_type == 'money'){
                        $final_price = $price - $offer_code->less;
                    }                
                }
            }
        }

        // order recode created
        $user_id = auth()->user()->id;
        $order_id = Str::random(8)."_".$user_id;
        $last_order = Orders::create([
            'user_id' => $user_id,
            'order_id' => $order_id,
            'price' => $price,
            'credits' => $credits,
            'discount_price' => $final_price,
            'payment_gateway' => $payment_type,
            'transaction_id' => 'N/A',
        ]);

        if(!empty($last_order->id)){
            $status = $transaction_id =  ""; 
            // Create payment on razorpay
            if($payment_type == 'razorpay'){
                $result = $this->razorpayCreate($final_price, $order_id);                
                if(!empty($result->id)){
                    $transaction_id = $result->id;
                    $status = $result->status;
                }             
            }

            // Create payment on paypal
            if($payment_type == 'paypal'){
                // pending paypal
            }

            if(!empty($transaction_id) && !empty($status)){
                $last_order->transaction_id = $transaction_id;
                $last_order->status = $status;
                $last_order->save();
            }

            echo json_encode(['status' => 'success', 'type' => $payment_type, 'transaction_id' => $transaction_id]);
            die;

        }
    }


    protected function razorpayCreate($price, $order_id)
    {
        $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
        $amount = $price * 100;
        $currency = env('CURRENCY');
        $orderData = [
            'receipt' => $order_id,
            'amount' => $amount,
            'currency' => $currency,
        ];
        $last_order = $api->order->create($orderData);
        return $last_order;
    }

    public function addPlan(Request $request)
    {
        if(auth()->user()->access == 'admin'){ 
            try{
                $request->validate([
                    'credits' => 'required',
                    'price' => 'required',
                    'per_verification' => 'required',
                ]);

                $result = Plans::create([
                    'credits' => str_replace( ',', '', $request->credits),
                    'per_verification' => $request->per_verification,
                    'price' => $request->price,
                ]);

                if(!empty($result->id)){
                    return redirect()->back()->with('success', 'Plan added successfully.');
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }    
        } else {
            return view('pages.error');
        }    
    }

    public function editPlan(Request $request)
    {
        if(auth()->user()->access == 'admin'){
            try{
                $request->validate([
                    'credits' => 'required',
                    'price' => 'required',
                    'per_verification' => 'required',
                ]);

                $plan = Plans::find($request->pid);
                $plan->credits = $request->credits;
                $plan->per_verification = $request->per_verification;
                $plan->price = $request->price;
                if($plan->save()){
                    return redirect()->back()->with('success', 'Plan updated successfully.');
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            } 
        } else {
            return view('pages.error');
        }       
    }

    public function deletePlan($id)
    {
        if(auth()->user()->access == 'admin'){
            try{
                $plan = Plans::find($id);
                if($plan->delete()){
                    return redirect()->back()->with('success', 'Plan deleted successfully.');
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }  
        } else {
            return view('pages.error');
        }      
    }
}
