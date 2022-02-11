<?php


use App\Http\Controllers\Assignments\IndexController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', [App\Http\Controllers\FullCalenderController::class, 'index'])
    ->name('allEvent');

Route::get('/', [App\Http\Controllers\FullCalenderController::class, 'indexall'])
    ->name('events');

Route::post('/store', [App\Http\Controllers\FullCalenderController::class, 'store'])
    ->name('eventStore');

Route::get('/messageWatch', [App\Http\Controllers\FullCalenderController::class,'countEvents'])->name('messageWatch');


Route::get('/deleteEvent/{id}', [App\Http\Controllers\FullCalenderController::class, 'delete']);

Route::get('/indexStatus', [App\Http\Controllers\FullCalenderController::class, 'indexStatus'])
    ->name('statusEvent');


// Documents module

Route::prefix('assignments')->group(function () {
    Route::get('index', [IndexController::class, 'index'])
        ->name('document.index');
});




