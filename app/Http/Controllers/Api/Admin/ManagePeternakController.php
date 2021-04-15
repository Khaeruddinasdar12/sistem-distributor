<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use App\User;
use Illuminate\Support\Facades\Validator;

class ManagePeternakController extends Controller
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

	public function listPeternak(Request $request) // menampilkan list peternak
	{
		$validator = Validator::make($request->all(), [
			'admin_id'	=> 'required|numeric',
		]);

		if($validator->fails()) {
			$message = $validator->messages()->first();
			return response()->json([
				'status' => false,
				'message' => $message
			]);
		}
		
		if($this->login($request->admin_id) == false) {
			return $this->error;
		}

		$data = User::where('role', 'peternak')
		->get();

		return response()->json([
			'status'    => true,
			'message'   => 'List peternak',
			'data'		=> $data,
		]);
	}

	public function detailPeternak(Request $request) // menampilkan detail peternak
	{
		$validator = Validator::make($request->all(), [
			'admin_id'		=> 'required|numeric',
			'peternak_id'	=> 'required|numeric',
		]);

		if($validator->fails()) {
			$message = $validator->messages()->first();
			return response()->json([
				'status' => false,
				'message' => $message
			]);
		}
		
		if($this->login($request->admin_id) == false) {
			return $this->error;
		}

		$data = User::find($request->peternak_id);
		if($data == '') {
			return response()->json([
				'status'    => false,
				'message'   => 'Id peternak tidak ditemukan'
			]);
		}

		if($data->role != 'peternak' ) {
			return response()->json([
				'status'    => false,
				'message'   => 'User ini BUKAN peternak, user ini pengecer'
			]);
		}

		return response()->json([
			'status'    => true,
			'message'   => 'Detail peternak',
			'nama'		=> $data->name,
			'email'		=> $data->email,
			'noktp'		=> $data->noktp,
			'nohp'		=> $data->nohp,
			'alamat'	=> $data->alamat,
		]);
	}

	public function tambahPeternak(Request $request) //menambah data peternak
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
				'message' => $message
			]);
		}
		
		if($this->login($request->admin_id) == false) {
			return $this->error;
		}

		$data = new User;
		$data->role 	= 'peternak';
		$data->name 	= $request->nama;
		$data->email 	= $request->email;
		$data->password = bcrypt($request->password);
		$data->noktp 	= $request->noktp;
		$data->nohp 	= $request->nohp;
		$data->alamat 	= $request->alamat;
		$data->save();

		return response()->json([
			'status' => true,
			'messsage' => 'berhasil menambah data peternak'
		]);

	}

	public function editPeternak(Request $request) //mengubah data peternak
	{
		$validator = Validator::make($request->all(), [
			'admin_id'	=> 'required|numeric',
			'peternak_id' => 'required|numeric',
			'nama' 		=> 'required|string',
			'noktp' 	=> 'required|string',
			'nohp' 		=> 'required|string',
			'alamat' 	=> 'required|string',
		]);

		if($validator->fails()) {
			$message = $validator->messages()->first();
			return response()->json([
				'status' => false,
				'message' => $message
			]);
		}
		
		if($this->login($request->admin_id) == false) {
			return $this->error;
		}


		$data = User::find($request->peternak_id);
		if($data == '') {
			return response()->json([
				'status' => false,
				'message' => 'Id peternak tidak ditemukan'
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
					'message' => 'password confirmation tidak sama'
				]);
			}
			$data->password = bcrypt($request->password);
		}
		$data->save();

		return response()->json([
			'status' => true,
			'message' => 'berhasil mengubah data peternak'
		]);

	}
}
