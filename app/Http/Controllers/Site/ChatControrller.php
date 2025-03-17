<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\UserServices;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
class ChatControrller extends Controller
{
    public function chatForm($user_id ,UserServices $user_services)
    {
        $users=User::where('id', '<>', auth()->id())->select( 'id' , 'name')->get();
        $receiver = $user_services->getUser($user_id);
        $user_id = auth()->id();

        // Fetch chat history between authenticated user and receiver
        $messages = Message::where(function ($query) use ($user_id, $receiver) {
            $query->where('sender', $user_id)->where('receiver', $receiver->id);
        })->orWhere(function ($query) use ($user_id, $receiver) {
            $query->where('sender', $receiver->id)->where('receiver', $user_id);
        })->orderBy('created_at', 'ASC')->get();

        return view('Chat.chat', compact('receiver', 'messages' ,'users'));
    }

    public function sendMessages($user_id ,Request $request ,UserServices $user_services)
    {
        $userReceiver=$user_services->sendMessage($user_id,$request->message);
        return response()->json('Message Sent ');

    }
}
