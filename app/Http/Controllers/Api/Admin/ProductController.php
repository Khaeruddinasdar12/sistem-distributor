<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use App\Obat;
use App\Pakan;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
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

	public function detailObat(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'admin_id'	=> 'required|numeric',
			'obat_id'	=> 'required|numeric',
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

		$data = Obat::find($request->obat_id);
		return response()->json([
			'status' => true,
			'messsage' => 'detail obat',
			'id'	=> $data->id,
			'nama'	=> $data->nama,
			'stok'	=> $data->stok,
			'harga'	=> $data->harga,
		]);
	}

	public function editObat(Request $request) //edit data obat
	{
		$validator = Validator::make($request->all(), [
			'admin_id'	=> 'required|numeric',
			'obat_id'	=> 'required|numeric',
			'nama' 		=> 'required|string',
			'stok' 		=> 'required|numeric',
			'harga' 	=> 'required|numeric',
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

		$data = Obat::find($request->obat_id);
		if($data == '') { 
			return response()->json([
				'status'    => false,
				'message'   => 'Id Obat Tidak ditemukan'
			]);
		}

		$data->nama = $request->nama;
		$data->stok = $request->stok;
		$data->harga = $request->harga;
		$data->save();

		return response()->json([
			'status'    => true,
			'message'   => 'Berhasil mengubah data obat'
		]);
	}

	public function deleteObat(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'admin_id'	=> 'required|numeric',
			'obat_id'	=> 'required|numeric',
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

		$data = Obat::find($request->obat_id);
		if($data == '') { 
			return response()->json([
				'status'    => false,
				'message'   => 'Id Obat Tidak ditemukan'
			]);
		}

		$data->delete();
		return response()->json([
			'status'    => true,
			'message'   => 'Berhasil menghapus data obat'
		]);
	}

	public function detailPakan(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'admin_id'	=> 'required|numeric',
			'pakan_id'	=> 'required|numeric',
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

		$data = Pakan::find($request->pakan_id);
		return response()->json([
			'status' => true,
			'messsage' => 'detail pakan',
			'id'	=> $data->id,
			'nama'	=> $data->nama,
			'stok'	=> $data->stok,
			'harga'	=> $data->harga,
		]);
	}

	public function editPakan(Request $request) //edit data obat
	{
		$validator = Validator::make($request->all(), [
			'admin_id'	=> 'required|numeric',
			'pakan_id'	=> 'required|numeric',
			'nama' 		=> 'required|string',
			'stok' 		=> 'required|numeric',
			'harga' 	=> 'required|numeric',
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

		$data = Pakan::find($request->pakan_id);
		if($data == '') { 
			return response()->json([
				'status'    => false,
				'message'   => 'Id Pakan Tidak ditemukan'
			]);
		}

		$data->nama = $request->nama;
		$data->stok = $request->stok;
		$data->harga = $request->harga;
		$data->save();

		return response()->json([
			'status'    => true,
			'message'   => 'Berhasil mengubah data pakan'
		]);
	}

	public function deletePakan(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'admin_id'	=> 'required|numeric',
			'pakan_id'	=> 'required|numeric',
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

		$data = Pakan::find($request->pakan_id);
		if($data == '') { 
			return response()->json([
				'status'    => false,
				'message'   => 'Id Pakan Tidak ditemukan'
			]);
		}

		$data->delete();
		return response()->json([
			'status'    => true,
			'message'   => 'Berhasil menghapus data Pakan'
		]);
	}
}
