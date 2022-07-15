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

Route::get('/messageWatch', [App\Http\Controllers\FullCalenderController::class,'countEvents'])
    ->name('messageWatch');

Route::get('/togleWatch', [App\Http\Controllers\FullCalenderController::class,'countTogle'])
    ->name('togleWatch');


Route::get('/deleteEvent/{id}', [App\Http\Controllers\FullCalenderController::class, 'delete']);
// Route::get('/deleteWatch/{created_at}', [App\Http\Controllers\FullCalenderController::class, 'deleteWatch']);

Route::get('/indexStatus', [App\Http\Controllers\FullCalenderController::class, 'indexStatus'])
    ->name('statusEvent');


// ---------------------------------------------------  Assignments ---------------------------------------------------

Route::group(['prefix' => 'assignments', 'as' => 'assignments.'], function () {
    Route::get('/index/{perPage?}', [IndexController::class, 'index'])->where('perPage','[0-9]+')
        ->name('index');
    Route::get('/create', [IndexController::class, 'create'])->name('create-modal');
    Route::post('/index', [IndexController::class, 'store'])->name('add');
    Route::get('/edit/{assignment}', [IndexController::class, 'edit'])->name('edit-modal');
    Route::put('/update/{id}', [IndexController::class, 'update'])->name('update');
    Route::delete('/delete/{assignment}', [IndexController::class, 'destroy']);
    Route::post('/done/{assignment}', [IndexController::class, 'done'])->name('done');
    Route::post('/expire/{assignment}', [IndexController::class, 'expired'])->name('expire');

    Route::post('/user/create', [UserController::class, 'store'])->name('user.add');
    Route::post('/department/create', [DepartmentController::class, 'store'])->name('department.add');

//    Route::get('/index/sort/status/{status}', [IndexController::class,'sortByStatus'])
//        ->name('sort-by-status');
//    Route::get('/index/sort/department/{id}', [IndexController::class,'sortByDepartment'])
//        ->name('sort-by-department');


    Route::get('/export', [IndexController::class, 'export'])
        ->name('export');
});




