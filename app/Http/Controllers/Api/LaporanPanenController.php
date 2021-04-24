<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\LaporanPanen;
use Carbon\Carbon;
use App\User;
use App\Distribusi;
use Illuminate\Support\Facades\Validator;

class LaporanPanenController extends Controller
{
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'user_id'       => 'required|numeric',
			'no_polisi'   => 'required|string',
			'umur_panen'   => 'required|numeric',
			'jumlah_panen'   => 'required|numeric',
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

		if($data->role != 'peternak' ) {
			return response()->json([
				'status'    => false,
				'message'   => 'User ini BUKAN peternak, user ini pengecer'
			]);
		}

		$data = new LaporanPanen;
		$data->user_id	= $request->user_id;
		$data->no_polisi = $request->no_polisi;
		$data->umur_panen  = $request->umur_panen;
		$data->jumlah_panen = $request->jumlah_panen;
		$data->save();

		return response()->json([
			'status'    => true,
			'message'   => 'Berhasil menginput laporan panen',
		]);
	}

	public function list(Request $request) //list panen per user
	{
		$validator = Validator::make($request->all(), [
			'user_id'     => 'required|numeric',
		]);

		if($validator->fails()) {
			$message = $validator->messages()->first();
			return response()->json([
				'status' => false,
				'message' => $message
			]);
		}

		$data = User::find($request->user_id);

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

		$dt = LaporanPanen::where('user_id', $data->id)->get();
		return response()->json([
			'status'    => true,
			'message'   => 'list laporan panen',
			'data'		=> $dt,
		]);
	}
}
