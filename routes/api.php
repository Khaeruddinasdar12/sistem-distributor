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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// LIST OBAT & PAKAN
Route::get('/list-obat', 'Api\ObatPakanController@obat'); //list obat
Route::get('/list-pakan', 'Api\ObatPakanController@pakan'); //list obat
// END LIST OBAT & PAKAN


// PENGECER
Route::post('/pengecer/login', 'Api\LoginPengecerController@login'); //login pengecer
Route::get('/pengecer/profile/{id}', 'Api\LoginPengecerController@profile'); //profile pengecer


Route::post('/pengecer/tambah-pesanan', 'Api\PesananController@store'); //tambah pesanan
Route::post('/pengecer/pesanan', 'Api\PesananController@list'); //list pesanan (belum konfirmasi)
Route::post('/pengecer/riwayat-pesanan', 'Api\PesananController@listRiwayat'); //list riwayat pesanan (terkonfirmasi konfirmasi)
// END PENGECER



// PETERNAK
Route::post('/peternak/login', 'Api\LoginPeternakController@login'); //login peternak
Route::get('/peternak/profile/{id}', 'Api\LoginPeternakController@profile'); //profile peternak

// END PETERNAK


//DISTRIBUSI
Route::get('belum-distribusi/{id}', 'Api\DistribusiController@index'); //distribusi belum terkonfirmasi
Route::get('sedang-distribusi/{id}', 'Api\DistribusiController@sedang'); //distribusi terkonfirmasi
Route::get('riwayat-distribusi/{id}', 'Api\DistribusiController@riwayat'); //riwayat distribusi 

Route::post('konfirmasi-distribusi/{user_id}/{distribusi_id}', 'Api\DistribusiController@konfirmasi'); //mengkonfirmasi distribusi
Route::post('tutup-distribusi/{user_id}/{distribusi_id}', 'Api\DistribusiController@tutup'); //mengkonfirmasi distribusi

// DISTRIBUSI