<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Distribusi;
use App\User;
use Illuminate\Support\Facades\Validator;
use DB;
class DistribusiController extends Controller
{	
    public function index(Request $request) // list distribusi belum diterima
    {	
        $validator = Validator::make($request->all(), [
            'user_id'       => 'required|numeric',
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

        $data = DB::table('distribusis')->select('distribusis.id', 'distribusis.user_id', 'distribusis.no_distribusi', 'obats.nama as nama_obat', 'distribusis.jumlah_obat', 'pakans.nama as nama_pakan', 'distribusis.jumlah_pakan', 'distribusis.jumlah_ayam', 'distribusis.created_at')
                ->join('obats', 'distribusis.obat_id', 'obats.id')
                ->join('pakans', 'distribusis.pakan_id', 'pakans.id')
                ->where('distribusis.status', '0') //belum terkonfirmasi
                ->where('distribusis.open', '0') // masih berlangsung
                ->where('distribusis.user_id', $data->id) 
                ->orderBy('distribusis.created_at', 'desc')
                ->get();
    	return response()->json([
   			'status'    => true,
   			'message'   => 'data distribusi belum terkonfirmasi',
    		'data'		=> $data
    	]); 
    }

    public function sedang(Request $request) // list distribusi terkonfirmasi
    {	
        $validator = Validator::make($request->all(), [
            'user_id'       => 'required|numeric',
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

        $data = DB::table('distribusis')->select('distribusis.id', 'distribusis.user_id', 'distribusis.no_distribusi', 'obats.nama as nama_obat', 'distribusis.jumlah_obat', 'pakans.nama as nama_pakan', 'distribusis.jumlah_pakan', 'distribusis.jumlah_ayam', 'distribusis.created_at')
                ->join('obats', 'distribusis.obat_id', 'obats.id')
                ->join('pakans', 'distribusis.pakan_id', 'pakans.id')
                ->where('distribusis.status', '1') // terkonfirmasi
                ->where('distribusis.open', '0') // masih berlangsung
                ->where('distribusis.user_id', $data->id) 
                ->orderBy('distribusis.created_at', 'desc')
                ->get();

    	return response()->json([
   			'status'    => true,
   			'message'   => 'data distribusi terkonfirmasi',
    		'data'		=> $data
    	]); 
    }

    public function riwayat(Request $request) // list riwayat distribusi
    {	
        $validator = Validator::make($request->all(), [
            'user_id'       => 'required|numeric',
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

        $data = DB::table('distribusis')->select('distribusis.id', 'distribusis.user_id', 'distribusis.no_distribusi', 'obats.nama as nama_obat', 'distribusis.jumlah_obat', 'pakans.nama as nama_pakan', 'distribusis.jumlah_pakan', 'distribusis.jumlah_ayam', 'distribusis.created_at')
                ->join('obats', 'distribusis.obat_id', 'obats.id')
                ->join('pakans', 'distribusis.pakan_id', 'pakans.id')
                ->where('distribusis.status', '1') // terkonfirmasi
                ->where('distribusis.open', '1') // telah ditutup (riwayat)
                ->where('distribusis.user_id', $data->id) 
                ->orderBy('distribusis.created_at', 'desc')
                ->get();

    	return response()->json([
   			'status'    => true,
   			'message'   => 'data riwayat distribusi',
    		'data'		=> $data
    	]); 
    }

    public function konfirmasi(Request $request) // konfirmasi distribusi
    {	
        $validator = Validator::make($request->all(), [
            'user_id'       => 'required|numeric',
            'distribusi_id' => 'required|numeric',
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

    	$data = Distribusi::find($request->distribusi_id);
    	if ($data == '') {
    		return response()->json([
    			'status'    => false,
    			'message'   => 'Id Distribusi Tidak ditemukan'
    		]);
    	}

    	$data->status = '1'; // data distribusi menjadi terkonfirmasi
    	$data->save();

    	return response()->json([
   			'status'    => true,
   			'message'   => 'Berhasil mengkonfirmasi distribusi'
    	]); 
    }

    public function tutup(Request $request) // menutup distribusi
    {	
        $validator = Validator::make($request->all(), [
            'user_id'       => 'required|numeric',
            'distribusi_id' => 'required|numeric',
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

    	$data = Distribusi::find($request->distribusi_id);
    	if ($data == '') {
    		return response()->json([
    			'status'    => false,
    			'message'   => 'Id Distribusi Tidak ditemukan'
    		]);
    	}

    	$data->open = '1'; // distribusi selesai (ditutup)
    	$data->save();

    	return response()->json([
   			'status'    => true,
   			'message'   => 'Distribusi telah selesai'
    	]); 
    }
}
