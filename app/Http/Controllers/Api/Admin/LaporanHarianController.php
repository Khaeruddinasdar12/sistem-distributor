<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Admin;

class LaporanHarianController extends Controller
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

	public function index(Request $request)
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

		$time = Carbon::now();
		$wkt = $time->format('Y-m-d');
		// return $request->waktu;
		if (!empty($request->waktu)) {
			$data = DB::table('laporan_harians')
			->select('distribusis.no_distribusi', 'users.name as nama_peternak', 'laporan_harians.jumlah_ayam', 'laporan_harians.umur_ayam', 'laporan_harians.total_kematian', 'laporan_harians.bw', 'laporan_harians.fcr', 'laporan_harians.total_pakan_terpakai as pakan_terpakai', 'laporan_harians.stok_pakan')
			->join('distribusis', 'laporan_harians.distribusi_id', 'distribusis.id')
			->join('users', 'distribusis.user_id', 'users.id')
			->whereDate('laporan_harians.created_at', $request->waktu)
			->orderBy('laporan_harians.created_at', 'desc')
			->get();
			$wkt = $request->waktu;
		} else {
			$data = DB::table('laporan_harians')
			->select('distribusis.id', 'distribusis.no_distribusi', 'users.name as nama_peternak', 'laporan_harians.jumlah_ayam', 'laporan_harians.umur_ayam', 'laporan_harians.total_kematian', 'laporan_harians.bw', 'laporan_harians.fcr', 'laporan_harians.total_pakan_terpakai as pakan_terpakai', 'laporan_harians.stok_pakan')
			->join('distribusis', 'laporan_harians.distribusi_id', 'distribusis.id')
			->join('users', 'distribusis.user_id', 'users.id')
			->whereDate('laporan_harians.created_at', $wkt)
			->orderBy('laporan_harians.created_at', 'desc')
			->get();
		}

		return response()->json([
			'status'    => true,
			'message'   => 'Laporan Harian '.$wkt,
			'data'		=> $data,
		]);
	}

	public function detailDistribusi(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'admin_id'		=> 'required|numeric',
			'no_distribusi'	=> 'required|numeric',
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

		$data = Distribusi::where('no_distribusi', $id)
				->with('laporan')
				->with('user:id,name')
				->with('pakan:id,nama')
				->with('obat:id,nama')
				->first();

		return response()->json([
				'status' => true,
				'messsage' => 'laporan harian per distribusi', 
				$data
			]);

	}
}
