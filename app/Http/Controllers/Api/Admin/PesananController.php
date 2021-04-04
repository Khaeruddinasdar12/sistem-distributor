<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use App\Pesanan;
use Illuminate\Support\Facades\Validator;
use DB;

class PesananController extends Controller
{
	private $admin;
	private $error;

	public function login($id)
	{
		$this->admin = Admin::find($id);
		if($this->admin == '') {
			$this->error = [
				'status'    => false,
				'message'   => 'Id Tidak ditemukan'
			]; 
			return false;
		} 
		return true;
	}

	public function index(Request $request) // list pesanan pengecer
	{	
		$validator = Validator::make($request->all(), [
			'admin_id'		=> 'required|numeric',
		]);

		if($validator->fails()) {
			$message = $validator->messages()->first();
			return response()->json([
				'status' => false,
				'messsage' => $message
			]);
		}
		
		if($this->login($request->admin_id) == false) {
			return $this->error;
		} 

		$data = DB::table('pesanans')->select('pesanans.id', 'users.name as nama_pengecer', 'pesanans.jumlah_ayam', 'pesanans.nohp', 'users.alamat', 'pesanans.created_at as waktu_pesan')
		->where('pesanans.status', '0') // belum terkonfirmasi
		->join('users', 'pesanans.user_id', 'users.id')
		->orderBy('pesanans.created_at', 'desc')
		->get();

		return response()->json([
			'status'    => true,
			'message'   => 'List pesanan (admin)',
			'data'		=> $data,
		]);
	}

	public function riwayat(Request $request) // list riwayat pesanan pengecer
	{	
		$validator = Validator::make($request->all(), [
			'admin_id'		=> 'required|numeric',
		]);

		if($validator->fails()) {
			$message = $validator->messages()->first();
			return response()->json([
				'status' => false,
				'messsage' => $message
			]);
		}
		
		if($this->login($request->admin_id) == false) {
			return $this->error;
		} 

		$data = DB::table('pesanans')->select('pesanans.id', 'users.name as nama_pengecer', 'pesanans.jumlah_ayam', 'pesanans.nohp', 'users.alamat', 'pesanans.created_at as waktu_pesan')
		->where('pesanans.status', '1') // terkonfirmasi
		->join('users', 'pesanans.user_id', 'users.id')
		->orderBy('pesanans.created_at', 'desc')
		->get();

		return response()->json([
			'status'    => true,
			'message'   => 'List riwayat pesanan (admin)',
			'data'		=> $data,
		]);
	}

	public function konfirmasi(Request $request) //konfirmasi pesanan
	{
		$validator = Validator::make($request->all(), [
			'admin_id'		=> 'required|numeric',
			'pesanan_id'	=> 'required|numeric',
		]);

		if($validator->fails()) {
			$message = $validator->messages()->first();
			return response()->json([
				'status' => false,
				'messsage' => $message
			]);
		}

		if($this->login($request->admin_id) == false) {
			return $this->error;
		} 

		$data = Pesanan::find($request->pesanan_id);
		if($data == '') {
			return response()->json([
				'status'    => false,
				'message'   => 'Id Pesanan tidak ditemukan'
			]);
		}

		$data->status = '1';
		$data->save();

		return response()->json([
			'status'    => true,
			'message'   => 'Berhasil konfirmasi pesanan'
		]);
	}
}
