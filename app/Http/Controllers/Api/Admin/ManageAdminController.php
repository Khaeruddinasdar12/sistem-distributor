<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use Illuminate\Support\Facades\Validator;

class ManageAdminController extends Controller
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

	public function listAdmin(Request $request) // menampilkan list admin
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

		$data = Admin::get();

		return response()->json([
			'status'    => true,
			'message'   => 'List admin',
			'data'		=> $data,
		]);
	}

	public function detailAdmin(Request $request) // menampilkan detail admin
	{
		$validator = Validator::make($request->all(), [
			'admin_id'	=> 'required|numeric',
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

		$data = Admin::find($request->admin_id);
		if($data == '') {
			return response()->json([
				'status'    => false,
				'message'   => 'Id admin tidak ditemukan'
			]);
		}

		return response()->json([
			'status'    => true,
			'message'   => 'Detail admin',
			'nama'		=> $data->name,
			'email'		=> $data->email,
		]);
	}

	public function tambahAdmin(Request $request) //menambah data admin
	{
		$validator = Validator::make($request->all(), [
			'admin_id'	=> 'required|numeric',
			'nama' 		=> 'required|string',
			'email' 	=> 'required|string|email|unique:users',
			'password' 	=> 'required|string|min:8|confirmed',
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

		$data = new Admin;
		$data->name 	= $request->nama;
		$data->email 	= $request->email;
		$data->password = bcrypt($request->password);
		$data->save();

		return response()->json([
			'status' => true,
			'messsage' => 'Berhasil menambah data admin'
		]);

	}

	public function editAdmin(Request $request) //mengubah data admin
	{
		$validator = Validator::make($request->all(), [
			'admin_id'	=> 'required|numeric',
			'nama' 		=> 'required|string',
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


		$data = Admin::find($request->admin_id);
		if($data == '') {
			return response()->json([
				'status' => false,
				'messsage' => 'Id admin tidak ditemukan'
			]);
		}	

		$data->name 	= $request->nama;
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
			'messsage' => 'berhasil mengubah data admin'
		]);

	}
}
