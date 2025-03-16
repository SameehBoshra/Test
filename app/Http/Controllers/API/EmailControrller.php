<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\emailMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use function Laravel\Prompts\alert;

class EmailControrller extends Controller
{
    public function sendEmail()
    {

        $user = Auth::user();

        if ($user) {
            try {
                Mail::to($user->email)->send(new emailMailer($user));
                return view('auth.verify');
            } catch (\Exception $e) {
                return alert('SomeThig Is Wrong');
            }
        } else {
            return alert('SomeThig Is Wrong');
        }
}
}
