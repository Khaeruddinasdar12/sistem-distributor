<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Admin;

class LaporanPanenController extends Controller
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

        $data = DB::table('laporan_panens')
        ->select('users.name as nama_peternak', 'laporan_panens.no_polisi', 'laporan_panens.umur_panen', 'laporan_panens.jumlah_panen', 'laporan_panens.created_at as waktu')
        ->join('users', 'laporan_panens.user_id', 'users.id')
        ->orderBy('laporan_panens.created_at', 'desc')
        ->get();


        return response()->json([
			'status'    => true,
			'message'   => 'Laporan Panen',
			'data'		=> $data,
		]);
	}
}
