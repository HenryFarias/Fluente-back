<?php

use Illuminate\Http\Request;

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

Route::resource('pais', 'PaisesController');
Route::resource('user', 'UsersController');
Route::resource('evento', 'EventosController');
Route::post('login', 'AuthController@login');
Route::get('professores', 'UsersController@getAll');