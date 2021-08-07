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
Route::get('/surats/createKep','SuratController@createKep') -> name ('surats.createKep');
Route::get('/surats/{surat}/editKep','SuratController@editKep') -> name ('surats.editKep');
Route::post('/surats/{surat}/updateKep','SuratController@updateKep') -> name ('surats.updateKep');
Route::get('/surats/createKerj','SuratController@createKerj') -> name ('surats.createKerj');
Route::post('storeKep','SuratController@storeKep') -> name ('surats.storeKep');

//Route::get('laporan-pdf','SuratController@generatePDF');
Route::get('search','SuratController@search') -> name ('surats.search');
Route::post('hapus','SuratController@hapus') -> name ('surats.hapus');
Route::post('generateNO','SuratController@generateNO') -> name ('surats.generateNO');
Route::resource('surats','SuratController');