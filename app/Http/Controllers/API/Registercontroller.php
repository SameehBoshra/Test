<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\createUserValidation;
use App\Http\Requests\User\loginUserValidation;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class Registercontroller extends BaseController
{
    public  $user_services;
    public function __construct(UserServices $user_services)
    {
         $this->user_services=$user_services;
    }

    public function register(createUserValidation $create_user_validation)
     {
        if(!empty($create_user_validation->getErrors()))
        {
            return response()->json($create_user_validation->getErrors(),406);
        }

        $user = $this->user_services->createUser($create_user_validation->request()->all());
        $message['user'] = $user;
        $message['token'] = $user->createToken('myApp')->plainTextToken;
        return $this->sendResponse($message);
    }

    public function login(loginUserValidation $login_user_validation)
    {
        if(!empty($login_user_validation->getErrors()))
        {
            return response()->json($login_user_validation->getErrors(),406);
        }

        $request=$login_user_validation->request();

        if(Auth::attempt(['email'=>$request->email , 'password'=>$request->password]))
        {
            $user=Auth::user();
            $message['token'] = $user->createToken('myApp')->plainTextToken;
           $message['name']=$user->name;
            return $this->sendResponse($message);

        }
        else
        {
            return $this->sendResponse('Unauthorized' ,401);
        }




    }
}
