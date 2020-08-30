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


Route::middleware('auth:sanctum')->get('me', function (Request $request) {
    return auth()->user();
});


Route::post('register', 'RegisterController@register')->name('register');
Route::get('login', 'LoginController@login')->name('login');

Route::middleware('auth:sanctum')->group(function () {

    Route::post('logout', 'LoginController@logout')->name('logout');

    Route::apiResource('boards', 'BoardController');

    Route::get('boards/{board}/tasks', 'TaskController@list');

    Route::apiResource('tasks', 'TaskController')->except('index');

    Route::post('tasks/{task}/attach_label/{label}/', 'TaskController@attachLabel');
    Route::post('tasks/{task}/attach_image/', 'TaskController@attachImage');


    Route::apiResource('labels', 'LabelController');
    Route::apiResource('statuses', 'StatusController');

    Route::post('log',function (){
        return \App\Models\Log::all();
    });
});




