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
Route::get('/getRoleList', 'RoleController@roleList');
Route::get('/','ProccessPayment@payerForm')->name('form');
Route::post('/send-person' , 'PersonController@store');
Route::post('/send' , 'ProccessPayment@store')->name('payment');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/getDepartaments' , 'DepartamentController@listDepartaments');