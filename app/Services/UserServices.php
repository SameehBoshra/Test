<?php

namespace App\Services;

use App\Events\ChatSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class UserServices{

    public function getUser($user_id)
    {
        return User::where('id',$user_id)->first();
    }

    public function createUser(array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return User::create($data);

    }

    public function sendMessage($user_id ,$message)
    {

            $data['sender'] = Auth::id();
            $data['receiver'] = $user_id;
            $data['message'] = $message;

            Message::create($data);

            // Push data to Pusher
            $receiver = $this->getUser($user_id);

             \broadcast(new ChatSent($receiver, $message));
    }
}
