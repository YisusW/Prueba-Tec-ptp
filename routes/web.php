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


Route::view('/bankForm/{id_person?}','banckList');
Route::get('/getBankList', 'ProccessPayment@getBankList');
Route::get('/getTypePersonList', 'TypePersonController@getTypePersonList');
Route::get('/getDepartaments', 'DepartamentController@listDepartaments');
Route::get('/getCitiesByState/{stae}/', 'CityController@getListCityByState');
Route::get('/','ProccessPayment@bayerForm')->name('bayer');
Route::get('/payerForm/{bayer_id?}','PersonController@formPayer');
Route::post('/bayer', 'PersonController@store');
Route::post('/payer', 'PersonController@store');
Route::post('/send', 'ProccessPayment@store')->name('payment');
Route::get('/home', 'HomeController@index')->name('home');
