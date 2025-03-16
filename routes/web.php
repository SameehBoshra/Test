<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Registercontroller;
use App\Http\Controllers\API\VerificationController;
use App\Http\Controllers\Site\ChatControrller;
use App\Http\Controllers\Site\SendSmsControrller;
use App\Http\Controllers\API\EmailControrller;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* Route::controller(Registercontroller::class)->group(function()
{
Route::post('login','login');
Route::post('register','register');
}); */
Auth::routes(['verify'=>true]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['verified']);


Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['verified']);

// chat
Route::get('/chatForm/{user_id}' , [ChatControrller::class ,'chatForm'])->middleware('auth');
Route::post('/chat/{user_id}' , [ChatControrller::class ,'sendMessages'])->middleware('auth');

// send sms by TWILIO

Route::get('send/sms' , [SendSmsControrller::class ,'sendSms']);
//send email
Route::get('send',[EmailControrller::class , 'sendEmail'])->name('send.email')->middleware('auth:sanctum');
