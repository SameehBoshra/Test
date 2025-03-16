<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class SendSmsControrller extends Controller
{
    public function sendSms()
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilio_number = env('TWILIO_PHONE_NUMBER'); // يجب أن يكون رقم Twilio المسجل

        $receiver_number = "+201065826215"; // ضع رقم الهاتف الذي تريد الإرسال إليه

        if ($twilio_number == $receiver_number) {
            return "❌ خطأ: لا يمكنك إرسال رسالة إلى نفس رقم Twilio!";
        }

        $client = new Client($sid, $token);

        $client->messages->create(
            $receiver_number,
            [
                'from' => $twilio_number,
                'body' => 'Hello! This is a test message from Laravel using Twilio.'
            ]
        );

        return "✅ الرسالة تم إرسالها بنجاح!";

    }
}
