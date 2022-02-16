<?php


use App\Http\Controllers\Assignments\DepartmentController;
use App\Http\Controllers\Assignments\IndexController;
use App\Http\Controllers\Assignments\UserController;
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
    Route::get('index/{perPage?}', [IndexController::class, 'index'])->where('perPage','[0-9]+')
        ->name('assignments.index');
    Route::get('create', [IndexController::class, 'create'])
        ->name('create-assignment-modal');

    Route::post('index', [IndexController::class, 'store'])
        ->name('add-assignment');

    Route::post('user/create', [UserController::class, 'store'])
        ->name('add-user');
    Route::post('department/create', [DepartmentController::class, 'store'])
        ->name('add-department');

    // filters and sort

    Route::get('search', [IndexController::class, 'search'])
        ->name('search-assignment');
    Route::get('index/sort/status/{id}', [IndexController::class,'sortByStatus'])
        ->name('sort-by-status');
    Route::get('index/sort/department/{id}', [IndexController::class,'sortByDepartment'])
        ->name('sort-by-department');


});




