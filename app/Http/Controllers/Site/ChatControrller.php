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
      //  $users = User::latest()->where('id', '<>', auth()->id())->get();
        $receiver=$user_services->getUser($user_id);

       return view('Chat.chat', compact('receiver'));

    }

    public function sendMessages($user_id ,Request $request ,UserServices $user_services)
    {
        $userReceiver=$user_services->sendMessage($user_id,$request->message);
        return response()->json('Message Sent ');

    }
}
