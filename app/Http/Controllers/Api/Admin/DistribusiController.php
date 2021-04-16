<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Admin;
use App\User;
use App\Pakan;
use App\Obat;
use Carbon\Carbon;
use App\Distribusi;
use App\LaporanHarian;
class DistribusiController extends Controller
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

	public function laporan(Request $request) //list laporan harian berdasarkan distribusi id
	{
		$validator = Validator::make($request->all(), [
			'admin_id'		=> 'required|numeric',
			'distribusi_id' => 'required|numeric',
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

		$data = LaporanHarian::where('distribusi_id', $request->distribusi_id)
		->orderBy('created_at', 'desc')
		->get();

		return response()->json([
			'status' => true,
			'messsage' => 'laporan harian berdasarkan distribusi id',
			'data' => $data
		]);

	}

	public function unConfirmed(Request $request) // list distribusi belum terkonfirmasi
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

		$data =DB::table('distribusis')
		->select('distribusis.id', 'distribusis.no_distribusi', 'users.name as nama_peternak', 'users.alamat', 'obats.nama as nama_obat', 'distribusis.jumlah_obat', 'pakans.nama as nama_pakan', 'distribusis.jumlah_pakan', 'distribusis.jumlah_ayam')
		->join('users', 'distribusis.user_id','users.id')
		->join('obats', 'distribusis.obat_id','obats.id')
		->join('pakans', 'distribusis.pakan_id','pakans.id')
		->where('distribusis.status', '0') //belum terkofirmasi
		->where('distribusis.open', '0') //sedang berlangsung
		->orderBy('distribusis.created_at', 'desc')
		->get();

		return response()->json([
			'status' => true,
			'messsage' => 'list distribusi belum terkonfirmasi',
			'data' => $data
		]);
	}

	public function sedangDistribusi(Request $request) // list distribusi belum terkonfirmasi
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

		$data =DB::table('distribusis')
		->select('distribusis.id', 'distribusis.no_distribusi', 'users.name as nama_peternak', 'users.alamat', 'obats.nama as nama_obat', 'distribusis.jumlah_obat', 'pakans.nama as nama_pakan', 'distribusis.jumlah_pakan', 'distribusis.jumlah_ayam')
		->join('users', 'distribusis.user_id','users.id')
		->join('obats', 'distribusis.obat_id','obats.id')
		->join('pakans', 'distribusis.pakan_id','pakans.id')
		->where('distribusis.status', '1') //terkofirmasi
		->where('distribusis.open', '0') //sedang berlangsung
		->orderBy('distribusis.created_at', 'desc')
		->get();

		return response()->json([
			'status' => true,
			'messsage' => 'list distribusi sedang berlangsung',
			'data' => $data
		]);
	}

	public function riwayatDistribusi(Request $request) // list riwayat distribusi
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

		$data =DB::table('distribusis')
		->select('distribusis.id', 'distribusis.no_distribusi', 'users.name as nama_peternak', 'users.alamat', 'obats.nama as nama_obat', 'distribusis.jumlah_obat', 'pakans.nama as nama_pakan', 'distribusis.jumlah_pakan', 'distribusis.jumlah_ayam')
		->join('users', 'distribusis.user_id','users.id')
		->join('obats', 'distribusis.obat_id','obats.id')
		->join('pakans', 'distribusis.pakan_id','pakans.id')
		->where('distribusis.status', '1') //terkofirmasi
		->where('distribusis.open', '1') //riwayat (tutup)
		->orderBy('distribusis.created_at', 'desc')
		->get();

		return response()->json([
			'status' => true,
			'messsage' => 'list riwayat distribusi',
			'data' => $data
		]);
	}


	public function store(Request $request) // tambah data distribusi
	{
		$validator = Validator::make($request->all(), [
			'admin_id'		=> 'required|numeric',
			'peternak_id' 	=> 'required|numeric',
			'pakan_id' 		=> 'required|numeric',
			'obat_id' 		=> 'required|numeric',
			'jumlah_obat' 	=> 'required|numeric|min:1',
			'jumlah_pakan' 	=> 'required|numeric|min:1',
			'jumlah_ayam' 	=> 'required|numeric|min:1',
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
		$inv = 'INV-'.$time->format('Y').$time->format('m').$time->format('d').$time->format('H').$time->format('i').$time->format('s').$request->peternak_id;

		$cekPeternak = User::find($request->peternak_id); //cek peternak
		if($cekPeternak == '') {
			return response()->json([
				'status'    => false,
				'message'   => 'Id Peternak Tidak ditemukan'
			]);
		}
		if($cekPeternak->role != 'peternak' ) {
			return response()->json([
				'status'    => false,
				'message'   => 'User ini BUKAN peternak, user ini pengecer'
			]);
		}

    	$cekPakan = Pakan::find($request->pakan_id); //cek stok pakan
    	if($cekPakan == '') {
    		return response()->json([
    			'status'    => false,
    			'message'   => 'Id Pakan Tidak ditemukan'
    		]);
    	}
    	if($cekPakan->stok < $request->jumlah_pakan) {
    		return response()->json([
    			'status'    => false,
    			'message'   => 'Stok Pakan Tidak Cukup, tersisa '.$cekPakan->stok
    		]);
    	}

    	$cekObat = Obat::find($request->obat_id); //cek stok obat
    	if($cekObat == '') {
    		return response()->json([
    			'status'    => false,
    			'message'   => 'Id Obat Tidak ditemukan'
    		]);
    	}
    	if($cekObat->stok < $request->jumlah_obat) {
    		return response()->json([
    			'status'    => false,
    			'message'   => 'Stok Obat Tidak Cukup, tersisa '.$cekObat->stok
    		]);
    	}

    	$data = new Distribusi;
    	$data->no_distribusi = $inv;
    	$data->user_id = $request->peternak_id;
    	$data->obat_id = $request->obat_id;
    	$data->pakan_id = $request->pakan_id;
    	$data->status = '0'; // 0 = belum dikonfirmasi peternak
    	$data->open = '0'; // distribusi masih berlangsung
    	$data->jumlah_obat = $request->jumlah_obat;
    	$data->jumlah_pakan = $request->jumlah_pakan;
    	$data->jumlah_ayam = $request->jumlah_ayam;
    	$data->admin_id = $request->admin_id;
    	$data->save();

        //update pakan & obat
    	if($data) {
    		$cekObat->stok = $cekObat->stok - $request->jumlah_obat;
    		$cekObat->save();
    		$cekPakan->stok = $cekPakan->stok - $request->jumlah_pakan;
    		$cekPakan->save();
    	}

    	return response()->json([
    		'status'    => true,
    		'message'   => 'Berhasil menambah data distribusi'
    	]);
    }

	public function listPeternak() // menampilkan list peternak
	{
		$data = User::select('id', 'name')
		->where('role', 'peternak')
		->get();

		return response()->json([
			'status'    => true,
			'message'   => 'List peternak',
			'data'		=> $data,
		]);
	}

	public function detailPeternak(Request $request) //detail peternak
	{
		$validator = Validator::make($request->all(), [
			'peternak_id'	=> 'required|numeric',
		]);

		if($validator->fails()) {
			$message = $validator->messages()->first();
			return response()->json([
				'status' => false,
				'messsage' => $message
			]);
		}

		$data = User::find($request->peternak_id);

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

		return response()->json([
			'status'    => true,
			'message'   => 'detail peternak',
			'id'		=> $data->id,
			'nama'		=> $data->name,
			'email'		=> $data->email,
			'nohp'		=> $data->nohp,
			'noktp'		=> $data->noktp,
			'alamat'	=> $data->alamat
		]); 
	}

	public function detailObat(Request $request) //detail obat
	{
		$validator = Validator::make($request->all(), [
			'obat_id'	=> 'required|numeric',
		]);

		if($validator->fails()) {
			$message = $validator->messages()->first();
			return response()->json([
				'status' => false,
				'messsage' => $message
			]);
		}

		$data = Obat::find($request->obat_id);

		if($data == '') {
			return response()->json([
				'status'    => false,
				'message'   => 'Id Tidak ditemukan'
			]);
		}

		return response()->json([
			'status'    => true,
			'message'   => 'detail obat',
			'id'		=> $data->id,
			'nama'		=> $data->nama,
			'stok'		=> $data->stok,
		]); 
	}

	public function detailPakan(Request $request) // detail pakan
	{
		$validator = Validator::make($request->all(), [
			'pakan_id'	=> 'required|numeric',
		]);

		if($validator->fails()) {
			$message = $validator->messages()->first();
			return response()->json([
				'status' => false,
				'messsage' => $message
			]);
		}

		$data = Pakan::find($request->pakan_id);

		if($data == '') {
			return response()->json([
				'status'    => false,
				'message'   => 'Id Tidak ditemukan'
			]);
		}

		return response()->json([
			'status'    => true,
			'message'   => 'detail pakan',
			'id'		=> $data->id,
			'nama'		=> $data->nama,
			'stok'		=> $data->stok,
		]); 
	}
}
