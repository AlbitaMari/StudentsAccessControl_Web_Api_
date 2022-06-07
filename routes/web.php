<?php

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
Auth::routes();

Route::get('/', function () {
    return view('inicio');
});
Route::group(['middleware' => 'admin'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/exit','UserController@exit')->name('exit.control');
    Route::post('/searchcode','UserController@search')->name('search');
    Route::get('/pickup','UserController@pickup')->name('pickup');
    Route::get('/searchauthorized','UserController@search_authorized')->name('searchauthorized');
    Route::post('/pickuplog','UserController@pickuplog')->name('pickuplog');
    Route::get('/rise','UserController@rise')->name('rise');
    Route::get('/loggs','UserController@loggs')->name('loggs');
    Route::get('/crudal','UserController@crudal')->name('crudal');
    Route::get('/edit/{id}','UserController@edit')->name('edit');
    Route::post('/edit/{id}','UserController@update')->name('update');
    Route::get('/delete/{id}','UserController@delete')->name('delete');
    Route::get('/create','UserController@add')->name('add');
    Route::post('/create','UserController@create')->name('create');
    Route::get('/searcher','UserController@searcher')->name('searcher');
    Route::post('/pdf','UserController@generatePdf')->name('pdf');
    Route::get('/sendemail','UserController@enviarEmail')->name('sendemail');

    Route::get('importExport', 'MaatwebsiteController@importExport');

    Route::get('downloadExcel/{type}', 'MaatwebsiteController@downloadExcel');

    Route::post('importExcel', 'MaatwebsiteController@importExcel')->name('importExcel');
    Route::post('importExcelAutorizados', 'MaatwebsiteController@importExcelAutorizados')->name('importExcelAutorizados');
    Route::post('importExcelAutorizaciones', 'MaatwebsiteController@importExcelAutorizaciones')->name('importExcelAutorizaciones');
});