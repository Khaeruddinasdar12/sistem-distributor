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
Route::post('/admin/login', 'Api\Admin\LoginAdminController@login'); //login admin
Route::post('/admin/profile', 'Api\Admin\LoginAdminController@profile'); //profile admin

	//TAB PESANAN
Route::post('/admin/pesanan','Api\Admin\PesananController@index'); //list pesanan
Route::post('/admin/riwayat-pesanan','Api\Admin\PesananController@riwayat'); //list riwayat pesanan

Route::post('/admin/konfirmasi-pesanan','Api\Admin\PesananController@konfirmasi'); //konfirmasi pesanan
	//END TAB PESANAN


	//TAB LAPORAN HARIAN
	Route::post('/admin/laporan-harian','Api\Admin\LaporanHarianController@index'); //laporan harian
	//END TAB LAPORAN HARIAN


	//LAPORAN PANEN
	Route::post('/admin/laporan-panen','Api\Admin\LaporanPanenController@index'); //laporan harian
	//END LAPORAN PANEN


	//DISTRIBUSI
	Route::post('/admin/tambah-distribusi','Api\Admin\DistribusiController@store'); //tambah distribusi

	Route::get('/admin/list-peternak','Api\Admin\DistribusiController@listPeternak'); //list peternak

	Route::post('/admin/detail-peternak','Api\Admin\DistribusiController@detailPeternak'); //detail peternak
	Route::post('/admin/detail-pakan','Api\Admin\DistribusiController@detailPakan'); //detail pakan
	Route::post('/admin/detail-obat','Api\Admin\DistribusiController@detailObat'); //detail obat
	
	Route::post('/admin/distribusi-belum-terkonfirmasi','Api\Admin\DistribusiController@unConfirmed'); //list distribusi belum terkonfirmasi
	Route::post('/admin/distribusi-sedang-berlangsung','Api\Admin\DistribusiController@sedangDistribusi'); //list distribusi belum terkonfirmasi
	Route::post('/admin/riwayat-distribusi','Api\Admin\DistribusiController@riwayatDistribusi'); //list riwayat distribusi

	Route::post('/admin/laporan-harian-distribusi','Api\Admin\DistribusiController@laporan'); //laporan harian berdasarkan distribusi
	
	//END DISTRIBUSI
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