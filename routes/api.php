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

// API ADMIN
Route::post('/admin/login', 'Api\LoginAdminController@login'); //login admin
Route::post('/admin/profile', 'Api\LoginAdminController@profile'); //profile admin
// END API ADMIN


// LIST OBAT & PAKAN
Route::get('/list-obat', 'Api\ObatPakanController@obat'); //list obat
Route::get('/list-pakan', 'Api\ObatPakanController@pakan'); //list obat
// END LIST OBAT & PAKAN


// PENGECER
Route::post('/pengecer/login', 'Api\LoginPengecerController@login'); //login pengecer
Route::post('/pengecer/profile', 'Api\LoginPengecerController@profile'); //profile pengecer


Route::post('/pengecer/tambah-pesanan', 'Api\PesananController@store'); //tambah pesanan
Route::post('/pengecer/pesanan', 'Api\PesananController@list'); //list pesanan (belum konfirmasi)
Route::post('/pengecer/riwayat-pesanan', 'Api\PesananController@listRiwayat'); //list riwayat pesanan (terkonfirmasi konfirmasi)
// END PENGECER



// PETERNAK
Route::post('/peternak/login', 'Api\LoginPeternakController@login'); //login peternak
Route::post('/peternak/profile', 'Api\LoginPeternakController@profile'); //profile peternak

// END PETERNAK


//DISTRIBUSI
Route::post('belum-distribusi', 'Api\DistribusiController@index'); //distribusi belum terkonfirmasi
Route::post('sedang-distribusi', 'Api\DistribusiController@sedang'); //distribusi terkonfirmasi
Route::post('riwayat-distribusi', 'Api\DistribusiController@riwayat'); //riwayat distribusi 

Route::post('konfirmasi-distribusi', 'Api\DistribusiController@konfirmasi'); //mengkonfirmasi distribusi
Route::post('tutup-distribusi', 'Api\DistribusiController@tutup'); //mengkonfirmasi distribusi

// DISTRIBUSI

//LAPORAN HARIAN
Route::post('laporan-harian', 'Api\LaporanHarianController@store'); //input laporan harian 
// END LAPORANH HARIAN

//LAPORAN PANEN
Route::post('laporan-panen', 'Api\LaporanPanenController@store'); //input laporan panen 
// END LAPORANH PANEN