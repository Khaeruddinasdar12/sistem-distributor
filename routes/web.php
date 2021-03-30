<?php

use Illuminate\Support\Facades\Route;

Auth::routes([
	'register' => false,
	'login' => false,
]);

Route::get('/', function () {
	return view('welcome');
});

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')->group(function() {
	Route::get('/', 'DashboardController@index')->name('admin.dashboard');

	Route::get('/login','Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
	Route::post('logout/', 'Auth\AdminLoginController@logout')->name('admin.logout');
	
	// LAPORAN HARIAN
	Route::get('/table-laporan-panen','LaporanPanenController@table')->name('table.laporanpanen'); // api laporan panen

	Route::get('/laporan-panen','LaporanPanenController@index')->name('laporan.panen');
	// END LAPORAN HARIAN


	// LAPORAN HARIAN
	Route::get('/table-laporan-harian','LaporanHarianController@table')->name('table.laporanharian'); // api laporan harian

	Route::get('/laporan-harian/{id}','LaporanHarianController@laporan')->name('laporan.harian.distribusi');
	Route::get('/laporan-harian','LaporanHarianController@index')->name('laporan.harian');
	// END LAPORAN HARIAN


	// PESANAN
	Route::get('/table-pesanan','PesananController@table')->name('table.pesanan'); // api pesanan
	Route::get('/table-riwayat-pesanan','PesananController@tableRiwayat')->name('table.riwayatpesanan'); // api riwayat pesanan

	Route::put('/konfirmasi-pesanan/{id}','PesananController@konfirmasi')->name('konfirmasi.pesanan');

	Route::get('/pesanan','PesananController@index')->name('pesanan');
	Route::get('/riwayat-pesanan','PesananController@riwayat')->name('riwayat.pesanan');
	// END PESANAN


	// DISTRIBUSI
	Route::get('/table-unconfirmed','DistribusiController@tableUnconfirmed')->name('table.distribusi.unconfirmed'); //table api distribusi belum terkonfirmasi
	Route::delete('/cancel-distribusi/{id}','DistribusiController@delete')->name('cancel.distribusi.unconfirmed'); //membatalkan distribusi belum terkonfirmasi

	Route::get('/table-sedang-distribusi','DistribusiController@tableSedang')->name('table.distribusi.sedang'); //table api sedang distribusi
	Route::get('/table-riwayat-distribusi','DistribusiController@tableRiwayat')->name('table.distribusi.riwayat'); //table api riwayat distribusi

	Route::get('/tambah-distribusi','DistribusiController@tambah')->name('distribusi.tambah'); //halaman tambah distribusi
	Route::post('/tambah-distribusi','DistribusiController@store')->name('distribusi.tambah.store');
	Route::get('/sedang-distribusi','DistribusiController@sedang')->name('distribusi.sedang'); //halaman sedang distribusi (sedang berlangsung)
	Route::get('/riwayat-distribusi','DistribusiController@riwayat')->name('distribusi.riwayat'); //halaman sedang distribusi (sedang berlangsung)

	Route::get('/keterangan-peternak/{id}','DistribusiController@ket_peternak'); // keterangan pakan
	Route::get('/keterangan-pakan/{id}','DistribusiController@ket_pakan'); // keterangan pakan
	Route::get('/keterangan-obat/{id}','DistribusiController@ket_obat'); // keterangan pakan
	// END DISTRIBUSI
	
	// PAKAN
	Route::get('/table-pakan','PakanController@table')->name('table.pakan'); // api pakan
	

	Route::get('/manage-pakan','PakanController@index')->name('manage.pakan');
	Route::post('/manage-pakan','PakanController@store')->name('manage.pakan.store');
	Route::put('/manage-pakan','PakanController@update')->name('manage.pakan.update');
	Route::delete('/manage-pakan/{id}','PakanController@delete')->name('manage.pakan.delete');
	// END PAKAN

	// OBAT
	Route::get('/table-obat','ObatController@table')->name('table.obat'); // api obat

	Route::get('/manage-obat','ObatController@index')->name('manage.obat');
	Route::post('/manage-obat','ObatController@store')->name('manage.obat.store');
	Route::put('/manage-obat','ObatController@update')->name('manage.obat.update');
	Route::delete('/manage-obat/{id}','ObatController@delete')->name('manage.obat.delete');
	// END OBAT

	// MANAGE PETERNAK
	Route::get('/table-peternak','ManagePeternak@table')->name('table.peternak'); // api peternak

	Route::get('/manage-peternak','ManagePeternak@index')->name('manage.peternak');
	Route::post('/manage-peternak','ManagePeternak@store')->name('manage.peternak.store');
	Route::put('/manage-peternak','ManagePeternak@update')->name('manage.peternak.update');
	// END MANAGE PETERNAK


	// MANAGE PENGECER
	Route::get('/table-pengecer','ManagePengecer@table')->name('table.pengecer'); // api pengecer

	Route::get('/manage-pengecer','ManagePengecer@index')->name('manage.pengecer');
	Route::post('/manage-pengecer','ManagePengecer@store')->name('manage.pengecer.store');
	Route::put('/manage-pengecer','ManagePengecer@update')->name('manage.pengecer.update');
	// END MANAGE PENGECER


	// MANAGE ADMIN
	Route::get('/table-admin','ManageAdmin@table')->name('table.admin'); //api admin

	Route::get('/manage-admin','ManageAdmin@index')->name('manage.admin');
	Route::post('/manage-admin','ManageAdmin@store')->name('manage.admin.store');

	Route::get('/profile','ManageAdmin@profile')->name('profile.admin');
	Route::put('/profile','ManageAdmin@update')->name('profile.admin.update');

	// END MANAGE ADMIN
});

