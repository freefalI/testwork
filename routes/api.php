<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return Auth::user();
});


Route::post('/register', 'RegisterController@register')->name('register');
Route::get('/login', 'LoginController@login')->name('login');

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', 'LoginController@logout')->name('logout');

    Route::apiResource('board', 'BoardController');
    Route::apiResource('task', 'TaskController')->except('index');
    Route::get('board/{board}/tasks', 'BoardController@taskList');
    Route::apiResource('label', 'LabelController');
    Route::post('task/{task}/attach_label/{label}/', 'TaskController@attachLabel');
    Route::apiResource('status', 'StatusController');
    Route::post('task/{task}/attach_image/', 'TaskController@attachImage');

});


