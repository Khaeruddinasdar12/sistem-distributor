<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Pesanan;
use Illuminate\Support\Facades\Validator;

class PesananController extends Controller
{
	public function list($id) // list pesanan pengecer
	{
		$data = User::find($id);

		if($data == '') {
			return response()->json([
				'status'    => false,
				'message'   => 'Id Tidak ditemukan'
			]);
		}

		if($data->role != 'pengecer' ) {
			return response()->json([
				'status'    => false,
				'message'   => 'User ini BUKAN pengecer, user ini peternak'
			]);
		}

		$data = Pesanan::where('status', '0')->where('user_id', $id)->get();

		return response()->json([
			'status'    => true,
			'message'   => 'Berhasil menambah pesanan',
			'data'		=> $data,
		]);
	}

	public function listRiwayat($id) // list riwayat pesanan pengecer
	{
		$data = User::find($id);

		if($data == '') {
			return response()->json([
				'status'    => false,
				'message'   => 'Id Tidak ditemukan'
			]);
		}

		if($data->role != 'pengecer' ) {
			return response()->json([
				'status'    => false,
				'message'   => 'User ini BUKAN pengecer, user ini peternak'
			]);
		}

		$data = Pesanan::where('status', '1')->where('user_id', $id)->get();

		return response()->json([
			'status'    => true,
			'message'   => 'Berhasil menambah pesanan',
			'data'		=> $data,
		]);
	}

    public function store(Request $request, $id) //menambah pesanan pengecer
    {
    	$validator = Validator::make($request->all(), [
    		'jumlah_ayam' 	=> 'required|numeric',
    		'nohp' 			=> 'required|numeric',
    	]);

    	if($validator->fails()) {
    		$message = $validator->messages()->first();
    		return response()->json([
    			'status' => false,
    			'messsage' => $message
    		]);
    	}

    	$data = User::find($id);

    	if($data == '') {
    		return response()->json([
    			'status'    => false,
    			'message'   => 'Id Tidak ditemukan'
    		]);
    	}

    	if($data->role != 'pengecer' ) {
    		return response()->json([
    			'status'    => false,
    			'message'   => 'User ini BUKAN pengecer, user ini peternak'
    		]);
    	}
    	$data = new Pesanan;
    	$data->user_id = $id;
    	$data->jumlah_ayam = $request->jumlah_ayam;
    	$data->nohp = $request->nohp;
    	$data->status = '0';
    	$data->save();


    	return response()->json([
    		'status'    => true,
    		'message'   => 'Berhasil menambah pesanan'
    	]);    	

    }
}
