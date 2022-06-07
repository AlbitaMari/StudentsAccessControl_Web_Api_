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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'API\RegisterController@login');


Route::middleware('auth:api')->group( function () {
    Route::get('users', 'API\RegisterController@users');
    Route::get('logs', 'API\LogsController@index');
    Route::get('qr', 'API\QrController@qr');
    Route::get('array', 'API\QrController@array');
    Route::post('scannedCode', 'API\QrController@scannedCode');
});
