<?php

use App\Http\Controllers\FullCalenderController;
use App\Http\Controllers\MessagesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/messages', [MessagesController::class,"store"])->name('addMessage');
Route::get('/messages', [MessagesController::class,"index"]);

Route::post('/checkMessage',[MessagesController::class,"messageCheck"]);

Route::put('/checkEvent/{id}',[FullCalenderController::class,"eventCheck"]);

Route::post('/deliteMessage', [MessagesController::class,"messageOnDelete"]);
