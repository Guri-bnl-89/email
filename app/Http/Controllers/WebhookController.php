<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;
use App\Models\Orders;

class WebhookController extends Controller
{
    protected $razorpay;

    public function __construct()
    {
        $this->razorpay = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
    }

    // Handle Razorpay Webhook
    public function webhookRazorpay(Request $request)
    {
        $payload = json_decode($request->getContent(), true);

        $data = $payload['payload']['payment']['entity'];
        $transId = $data['order_id'];
        $this->OutputDebug("RAZORPAY STARTED - ID:". $transId);

        // Verify webhook signature
        $webhookSignature = $request->header('X-Razorpay-Signature');
        $isValidSignature = $this->razorpay->utility->verifyWebhookSignature($request->getContent(), $webhookSignature, env('RAZORPAY_WEBHOOK_SECRET'));

        if (!$isValidSignature) {
            // Invalid signature, log or handle error
            $this->OutputDebug("Error: Invalid webhook signature - ID:". $transId);
            return;
        }

        // Process webhook payload based on event type
        $eventType = $payload['event'];
        switch($eventType){
            case 'payment.captured':
                $order = Orders::select('id')->where('transaction_id',$transId)->first();
                $order->status = "completed";
                $order->save();
                break;

            case 'payment.failed':
                $order = Orders::select('id')->where('transaction_id',$transId)->first();
                $order->status = "failed";
                $order->save();
                break;
        }

        // End the webhook
        $this->OutputDebug("RAZORPAY COMPLETED - ID:". $transId);
        return;
    }

    function OutputDebug($message)
    {
      Log::channel('razorpaylog')->info($message);
      return true;
    }


}
