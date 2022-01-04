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
Route::get('/surats/{surat}/editKerj','SuratController@editKerj') -> name ('surats.editKerj');
Route::post('storeKep','SuratController@storeKep') -> name ('surats.storeKep');
Route::post('storeKerj','SuratController@storeKerj') -> name ('surats.storeKerj');

//Route::get('laporan-pdf','SuratController@generatePDF');
Route::get('search','SuratController@search') -> name ('surats.search');
Route::get('opsi','SuratController@opsi') -> name ('surats.opsi');
Route::post('hapus','SuratController@hapus') -> name ('surats.hapus');
Route::post('generateNO','SuratController@generateNO') -> name ('surats.generateNO');
Route::post('updateOpsi','SuratController@updateOpsi') -> name('surats.updateOpsi');
Route::resource('surats','SuratController');