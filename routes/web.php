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

Route::get('/', 'CriptografarController@index');

Route::post('/criptografar', 'CriptografarController@criptografar')->name('criptografar');
Route::post('/descriptografar', 'DescriptografarController@descriptografar')->name('descriptografar');

Route::get('/criptografar/{texto}', 'CriptografarController@criptografar');
Route::get('/descriptografar/{texto}', 'DescriptografarController@descriptografar');