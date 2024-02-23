<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tickets;
use App\Models\Chats;

class ChatController extends Controller
{
    public function support()
    {
        $user_id = auth()->user()->id;
        $user_access = auth()->user()->access;
        if($user_access == 'admin'){
            $tickets = Tickets::join('users', 'users.id', '=', 'tickets.user_id')->select('tickets.*', 'users.name', 'users.surname')->get();
        } else {
            $tickets = Tickets::where('user_id', $user_id)->get();
        }        
        return view('pages.support')->with(compact('tickets'));
    }

    public function supportAdd(Request $request)
    {
        try{
            $request->validate([
                'priority' => 'required',
                'subject' => 'required|string',
                'message' => 'required|string',
            ]);

            $user_id = auth()->user()->id;
            $result = Tickets::create([
                'user_id' => $user_id,
                'priority' => $request->priority,
                'subject' => $request->subject,
            ]);

            if(!empty($result->id)){
                Chats::create([
                    'ticket_id' => $result->id,
                    'user_id' => $user_id,
                    'message' => $request->message,
                ]);
                return redirect()->back()->with('success', 'Ticket added successfully.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }        
    }

    public function getChat(Request $request)
    {
        $user_id = auth()->user()->id;
        $chats = Chats::join('users', 'users.id', '=', 'chats.user_id')->select('chats.user_id', 'chats.message', 'chats.created_at', 'users.image')->where('ticket_id', $request->ticket_id)->get();
        $message = '';
        
        foreach($chats as $chat){
            if($user_id != $chat->user_id){
                $message .= '<div class="message">                                
                    <img class="message-user-img" src="'.asset('assets/'.($chat->image ? $chat->image  : 'back/img/profile-img.jpg')).'" alt="">
                    <div class="message-inner">
                    <div class="message-body">
                        <div class="message-content">
                        <div class="message-text">
                            <p class="mb-0">'.$chat->message.'</p>
                        </div>                                       
                        </div>
                        
                    </div>

                    <div class="message-footer">
                        <span class="fs-11 text-secondary">'.date('d M-Y h:i A', strtotime($chat->created_at)).'</span>
                    </div>
                    </div>
                </div>';
            }
            
            if($user_id == $chat->user_id){
                $message .= '<div class="message message-out">
                    <img class="message-user-img" src="'.asset('assets/'.($chat->image ? $chat->image  : 'back/img/profile-img.jpg')).'" alt="">
                    <div class="message-inner">
                        <div class="message-body">
                            <div class="message-content">
                                <div class="message-text">
                                    <p class="mb-0">'.$chat->message.'</p>
                                </div>
                            </div>
                        </div>

                        <div class="message-footer">
                            <span class="fs-11 text-secondary">'.date('d M-Y h:i A', strtotime($chat->created_at)).'</span>
                        </div>
                    </div>
                </div>';
            }
        }

        echo json_encode(['status' => 'success', 'message' => $message]);
        die; 
        // return compact('chats');
    }

    public function addChat(Request $request)
    {
        $ticket = Tickets::select('id','status')->where('id', $request->ticket_id)->first();
        if($ticket->status != 'closed'){
            $user_id = auth()->user()->id;
            $result = Chats::create([
                'ticket_id' => $request->ticket_id,
                'user_id' => $user_id,
                'message' => $request->message,
            ]);
            if(!empty($result->id)){
                if(auth()->user()->access == 'admin'){
                    if($ticket->status == 'new'){
                        $ticket->status = 'open';
                        $ticket->save();
                    }
                }
                $message = $this->getChat($request);
                $status = 'success';
            } else{
                $status = 'error';
            }
        }
        echo json_encode(['status' => $status, 'message' => $message]);
        die;                
    }

    public function closeTicket(Request $request)
    {
        $ticket = Tickets::select('id','status')->where('id', $request->ticket_id)->first();
        $ticket->status = 'closed';
        if($ticket->save()){
            $status = 'success';
        } else{
            $status = 'error';
        }
        echo json_encode(['status' => $status]);
        die;        
    }

}
