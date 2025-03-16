<?php
namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequestFormApi;

class createUserValidation  extends BaseRequestFormApi{

    public function rules(): array
    {

        return [
            'name'=>'required|min:5|max:100',
            'email'=>'required|min:6|max:100|unique:users,email',
            'password'=>'required|min:6|max:50|confirmed',
        ];
    }

    public function authorize(): bool{
        return true;
    }

}