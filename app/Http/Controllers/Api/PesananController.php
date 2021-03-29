<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Pesanan;
use Illuminate\Support\Facades\Validator;

class PesananController extends Controller
{
	public function list(Request $request) // list pesanan pengecer
	{	
		$validator = Validator::make($request->all(), [
    		'user_id'		=> 'required|numeric',
    	]);

    	if($validator->fails()) {
    		$message = $validator->messages()->first();
    		return response()->json([
    			'status' => false,
    			'messsage' => $message
    		]);
    	}

		$data = User::find($request->user_id);

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

		$data = Pesanan::where('status', '0')->where('user_id', $request->user_id)->get();

		return response()->json([
			'status'    => true,
			'message'   => 'List pesanan',
			'data'		=> $data,
		]);
	}

	public function listRiwayat(Request $request) // list riwayat pesanan pengecer
	{
		$validator = Validator::make($request->all(), [
    		'user_id'		=> 'required|numeric',
    	]);

    	if($validator->fails()) {
    		$message = $validator->messages()->first();
    		return response()->json([
    			'status' => false,
    			'messsage' => $message
    		]);
    	}

    	$data = User::find($request->user_id);

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

		$data = Pesanan::where('status', '1')->where('user_id', $request->user_id)->get();

		return response()->json([
			'status'    => true,
			'message'   => 'List Riwayat Pesanan',
			'data'		=> $data,
		]);
	}

    public function store(Request $request) //menambah pesanan pengecer
    {
    	$validator = Validator::make($request->all(), [
    		'user_id'		=> 'required|numeric',
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

    	$data = User::find($request->user_id);

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
    	$data->user_id = $request->user_id;
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
