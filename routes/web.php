<?php

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
    return redirect('/todo');
});

//Route::resource('share', \App\Http\Controllers\SharedTodoController::class);

Route::resource('/todo', \App\Http\Controllers\TodoController::class);

Route::post('share', [\App\Http\Controllers\TodoController::class, 'share']);
//Route::post('done', [\App\Http\Controllers\TodoController::class, 'done']);

Auth::routes();



//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
