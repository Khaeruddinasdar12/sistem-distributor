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

	// DASHBOARD
	Route::post('/admin/dashboard','Api\Admin\DashboardController@index'); //dashboard	
	// END DASHBOARD


	//TAB PESANAN
	Route::post('/admin/pesanan','Api\Admin\PesananController@index'); //list pesanan
	Route::post('/admin/riwayat-pesanan','Api\Admin\PesananController@riwayat'); //list riwayat pesanan

	Route::post('/admin/konfirmasi-pesanan','Api\Admin\PesananController@konfirmasi'); //konfirmasi pesanan
	//END TAB PESANAN


	//TAB LAPORAN HARIAN
	Route::post('/admin/laporan-harian','Api\Admin\LaporanHarianController@index'); //laporan harian
	// Route::post('/admin/laporan-harian-distribusi','Api\Admin\LaporanHarianController@detailDistribusi'); //detail distribusi
	
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
	
	Route::post('/admin/delete-distribusi-belum-terkonfirmasi','Api\Admin\DistribusiController@deleteUnConfirmed'); //DELETE distribusi belum terkonfirmasi
	Route::post('/admin/distribusi-belum-terkonfirmasi','Api\Admin\DistribusiController@unConfirmed'); //list distribusi belum terkonfirmasi
	Route::post('/admin/distribusi-sedang-berlangsung','Api\Admin\DistribusiController@sedangDistribusi'); //list distribusi belum terkonfirmasi
	Route::post('/admin/riwayat-distribusi','Api\Admin\DistribusiController@riwayatDistribusi'); //list riwayat distribusi

	Route::post('/admin/laporan-harian-distribusi','Api\Admin\DistribusiController@laporan'); //laporan harian berdasarkan distribusi
	//END DISTRIBUSI


	//PRODUCT
	Route::post('/admin/edit-obat','Api\Admin\ProductController@editObat'); //edit data obat
	Route::post('/admin/detail-obat','Api\Admin\ProductController@detailObat'); //detail data obat
	Route::post('/admin/delete-obat','Api\Admin\ProductController@deleteObat'); //hapus data obat
	Route::post('/admin/edit-pakan','Api\Admin\ProductController@editPakan'); //edit data pakan
	Route::post('/admin/detail-pakan','Api\Admin\ProductController@detailPakan'); //detail data obat
	Route::post('/admin/delete-pakan','Api\Admin\ProductController@deletePakan'); //hapus data pakan
	//END PRODUCT


	//MANAGE PETERNAK
	Route::post('/admin/list-peternak-manage','Api\Admin\ManagePeternakController@listPeternak'); //list pengecer
	Route::post('/admin/detail-peternak-manage','Api\Admin\ManagePeternakController@detailPeternak'); //detail pengecer
	Route::post('/admin/tambah-peternak','Api\Admin\ManagePeternakController@tambahPeternak'); //tambah data peternak
	Route::post('/admin/edit-peternak','Api\Admin\ManagePeternakController@editPeternak'); //edit data peternak
	Route::post('/admin/delete-peternak','Api\Admin\ManagePeternakController@deletePeternak'); //edit data peternak
	//END MANAGE PETERNAK


	//MANAGE PENGECER
	Route::post('/admin/list-pengecer','Api\Admin\ManagePengecerController@listPengecer'); //list pengecer
	Route::post('/admin/detail-pengecer','Api\Admin\ManagePengecerController@detailPengecer'); //detail pengecer
	Route::post('/admin/tambah-pengecer','Api\Admin\ManagePengecerController@tambahPengecer'); //tambah data pengecer
	Route::post('/admin/edit-pengecer','Api\Admin\ManagePengecerController@editPengecer'); //edit data pengecer
	Route::post('/admin/delete-pengecer','Api\Admin\ManagePengecerController@deletePengecer'); //edit data pengecer
	//END MANAGE PENGECER


	//MANAGE ADMIN
	Route::post('/admin/list-admin','Api\Admin\ManageAdminController@listAdmin'); //list admin
	Route::post('/admin/detail-admin','Api\Admin\ManageAdminController@detailAdmin'); //detail admin
	Route::post('/admin/tambah-admin','Api\Admin\ManageAdminController@tambahAdmin'); //tambah data admin
	Route::post('/admin/edit-admin','Api\Admin\ManageAdminController@editAdmin'); //edit data admin
	//END MANAGE ADMIN
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
Route::post('list-laporan-harian', 'Api\LaporanHarianController@list'); //list laporan harian per id distribusi & id peternak
// END LAPORANH HARIAN

//LAPORAN PANEN
Route::post('laporan-panen', 'Api\LaporanPanenController@store'); //input laporan panen 
Route::post('list-panen', 'Api\LaporanPanenController@list'); //list panen per users (id)
// END LAPORANH PANEN