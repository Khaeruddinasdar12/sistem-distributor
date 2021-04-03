<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use App\User;
use Illuminate\Support\Facades\Validator;

class ManagePengecerController extends Controller
{
    private $admin;
	private $error;

	public function login($id)
	{
		$this->admin = Admin::find($id);
		if($this->admin == '') {
			$this->error = [
				'status'    => false,
				'message'   => 'Id Admin Tidak ditemukan'
			]; 
			return false;
		} 
		return true;
	}

	public function listPengecer(Request $request) // menampilkan list pengecer
	{
		$validator = Validator::make($request->all(), [
			'admin_id'	=> 'required|numeric',
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

		$data = User::where('role', 'pengecer')
		->get();

		return response()->json([
			'status'    => true,
			'message'   => 'List pengecer',
			'data'		=> $data,
		]);
	}

	public function detailPengecer(Request $request) // menampilkan list pengecer
	{
		$validator = Validator::make($request->all(), [
			'admin_id'		=> 'required|numeric',
			'pengecer_id'	=> 'required|numeric',
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

		$data = User::find($request->pengecer_id);
		if($data == '') {
			return response()->json([
				'status'    => false,
				'message'   => 'Id pengecer tidak ditemukan'
			]);
		}

		if($data->role != 'pengecer' ) {
			return response()->json([
				'status'    => false,
				'message'   => 'User ini BUKAN pengecer, user ini peternak'
			]);
		}

		return response()->json([
			'status'    => true,
			'message'   => 'Detail pengecer',
			'nama'		=> $data->name,
			'email'		=> $data->email,
			'noktp'		=> $data->noktp,
			'nohp'		=> $data->nohp,
			'alamat'	=> $data->alamat,
		]);
	}

	public function tambahPengecer(Request $request) //menambah data pengecer
	{
		$validator = Validator::make($request->all(), [
			'admin_id'	=> 'required|numeric',
			'nama' 		=> 'required|string',
			'email' 	=> 'required|string|email|unique:users',
			'password' 	=> 'required|string|min:8|confirmed',
			'noktp' 	=> 'required|string',
			'nohp' 		=> 'required|string',
			'alamat' 	=> 'required|string',
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

		$data = new User;
		$data->role 	= 'pengecer';
		$data->name 	= $request->nama;
		$data->email 	= $request->email;
		$data->password = bcrypt($request->password);
		$data->noktp 	= $request->noktp;
		$data->nohp 	= $request->nohp;
		$data->alamat 	= $request->alamat;
		$data->save();

		return response()->json([
			'status' => true,
			'messsage' => 'Berhasil menambah data pengecer'
		]);

	}

	public function editPengecer(Request $request) //mengubah data pengecer
	{
		$validator = Validator::make($request->all(), [
			'admin_id'	=> 'required|numeric',
			'pengecer_id' => 'required|numeric',
			'nama' 		=> 'required|string',
			'noktp' 	=> 'required|string',
			'nohp' 		=> 'required|string',
			'alamat' 	=> 'required|string',
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


		$data = User::find($request->pengecer_id);
		if($data == '') {
			return response()->json([
				'status' => false,
				'messsage' => 'Id pengecer tidak ditemukan'
			]);
		}

		if($data->role != 'pengecer' ) {
			return response()->json([
				'status'    => false,
				'message'   => 'User ini BUKAN pengecer, user ini peternak'
			]);
		}	

		$data->name 	= $request->nama;		
		$data->noktp 	= $request->noktp;
		$data->nohp 	= $request->nohp;
		$data->alamat 	= $request->alamat;
		if(!empty($request->password)) {
			if($request->password != $request->password_confirmation) {
				return response()->json([
					'status' => false,
					'messsage' => 'password confirmation tidak sama'
				]);
			}
			$data->password = bcrypt($request->password);
		}
		$data->save();

		return response()->json([
			'status' => true,
			'messsage' => 'berhasil mengubah data pengecer'
		]);

	}
}
