<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Distribusi;
use App\User;

class DistribusiController extends Controller
{	
    public function index($id) // list distribusi belum diterima
    {	
    	$data = User::find($id);

    	if($data == '') {
    		return response()->json([
    			'status'    => false,
    			'message'   => 'Id Tidak ditemukan'
    		]);
    	}

    	if($data->role != 'peternak' ) {
    		return response()->json([
    			'status'    => false,
    			'message'   => 'User ini BUKAN peternak, user ini pengecer'
    		]);
    	}

    	$data = Distribusi::where('user_id', $id)
    			->where('status', '0') // belum terkonfirmasi
    			->where('open', '0') //masih berlangsung
    			->orderBy('created_at', 'desc')
    			->get();

    	return response()->json([
   			'status'    => true,
   			'message'   => 'data distribusi belum terkonfirmasi',
    		'data'		=> $data
    	]); 
    }

    public function sedang($id) // list distribusi terkonfirmasi
    {	
    	$data = User::find($id);

    	if($data == '') {
    		return response()->json([
    			'status'    => false,
    			'message'   => 'Id Tidak ditemukan'
    		]);
    	}

    	if($data->role != 'peternak' ) {
    		return response()->json([
    			'status'    => false,
    			'message'   => 'User ini BUKAN peternak, user ini pengecer'
    		]);
    	}

    	$data = Distribusi::where('user_id', $id)
    			->where('status', '1') // terkonfirmasi
    			->where('open', '0') //masih berlangsung
    			->orderBy('created_at', 'desc')
    			->get();

    	return response()->json([
   			'status'    => true,
   			'message'   => 'data distribusi terkonfirmasi',
    		'data'		=> $data
    	]); 
    }

    public function riwayat($id) // list riwayat distribusi
    {	
    	$data = User::find($id);

    	if($data == '') {
    		return response()->json([
    			'status'    => false,
    			'message'   => 'Id Tidak ditemukan'
    		]);
    	}

    	if($data->role != 'peternak' ) {
    		return response()->json([
    			'status'    => false,
    			'message'   => 'User ini BUKAN peternak, user ini pengecer'
    		]);
    	}

    	$data = Distribusi::where('user_id', $id)
    			->where('status', '1') // terkonfirmasi
    			->where('open', '1') // telah ditutup (riwayat)
    			->orderBy('created_at', 'desc')
    			->get();

    	return response()->json([
   			'status'    => true,
   			'message'   => 'data riwayat distribusi',
    		'data'		=> $data
    	]); 
    }

    public function konfirmasi($user_id, $distribusi_d) // konfirmasi distribusi
    {	
    	$data = User::find($user_id);

    	if($data == '') {
    		return response()->json([
    			'status'    => false,
    			'message'   => 'Id Tidak ditemukan'
    		]);
    	}

    	if($data->role != 'peternak' ) {
    		return response()->json([
    			'status'    => false,
    			'message'   => 'User ini BUKAN peternak, user ini pengecer'
    		]);
    	}

    	$data = Distribusi::find($distribusi_d);
    	if ($data == '') {
    		return response()->json([
    			'status'    => false,
    			'message'   => 'Id Distribusi Tidak ditemukan'
    		]);
    	}

    	$data->status = '1'; // data distribusi menjadi terkonfirmasi
    	$data->save();

    	return response()->json([
   			'status'    => true,
   			'message'   => 'Berhasil mengkonfirmasi distribusi'
    	]); 
    }

    public function tutup($user_id, $distribusi_d) // menutup distribusi
    {	
    	$data = User::find($user_id);

    	if($data == '') {
    		return response()->json([
    			'status'    => false,
    			'message'   => 'Id Tidak ditemukan'
    		]);
    	}

    	if($data->role != 'peternak' ) {
    		return response()->json([
    			'status'    => false,
    			'message'   => 'User ini BUKAN peternak, user ini pengecer'
    		]);
    	}

    	$data = Distribusi::find($distribusi_d);
    	if ($data == '') {
    		return response()->json([
    			'status'    => false,
    			'message'   => 'Id Distribusi Tidak ditemukan'
    		]);
    	}

    	$data->open = '1'; // distribusi selesai (ditutup)
    	$data->save();

    	return response()->json([
   			'status'    => true,
   			'message'   => 'Distribusi telah selesai'
    	]); 
    }
}
