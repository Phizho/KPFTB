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
Route::get('/testing', function (){
    return view('testing');
});
Route::get('/tespdf', function (){
    return view('tespdf');
});

//Route::get('laporan-pdf','SuratController@generatePDF');
Route::get('search','SuratController@search') -> name ('surats.search');;
Route::post('hapus','SuratController@hapus') -> name ('surats.hapus');;
Route::resource('surats','SuratController');