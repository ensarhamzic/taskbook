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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/list/add', 'taskListController@store');
Route::post('/list/show', 'taskListController@show');
Route::post('/list/delete', 'taskListController@delete');

Route::post('/task/add', 'taskController@store');
Route::post('/task/delete', 'taskController@delete');
