<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    // success response method
    public function sendResponse($response, $status="Success",$code=200)
    {
        return response()->json(['data'=> $response , 'status'=>$status ] ,$code);
    }

    // return error response
    public function getErrors($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
