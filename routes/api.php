<?php

use App\Http\Controllers\API\EmailControrller;
use App\Http\Controllers\API\Registercontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(Registercontroller::class)->group(function()
{
Route::post('login','login');
Route::post('register','register');
});

Route::get('send',[EmailControrller::class , 'sendEmail'])->name('send.email')->middleware('auth:sanctum');

