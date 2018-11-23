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


Route::view('/bankForm/{id_person?}','bankList');
Route::get('/getBankList', 'BankController@getBankList');
Route::get('/getTypePersonList', 'TypePersonController@getTypePersonList');
Route::get('/getDepartaments', 'DepartamentController@listDepartaments');
Route::get('/getCitiesByState/{stae}/', 'CityController@getListCityByState');
Route::get('/','ProccessPayment@bayerForm');
Route::get('/payerForm/{bayer_id?}','PersonController@formPayer');
Route::get('/bankForm/{id_comprador?}/{id_pagador?}','BankController@index');
Route::post('/bayer', 'PersonController@store');
Route::post('/payer', 'PersonController@store');
Route::post('/initTransaction', 'BankController@store');
Route::get('/getTypeClientList', 'TypeClientController@listTypeListActive');

Route::post('/getTransactionstatus', 'BankController@statusTransaction');
