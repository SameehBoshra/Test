<?php
namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequestFormApi;

class loginUserValidation  extends BaseRequestFormApi{

    public function rules(): array
    {

        return [
            'email'=>'required|min:6|max:100',
            'password'=>'required|min:6|max:50',
        ];
    }

    public function authorize(): bool{
        return true;
    }

}