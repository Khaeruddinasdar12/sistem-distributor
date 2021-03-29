<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Distribusi;
use App\User;
use Illuminate\Support\Facades\Validator;

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

    	$data = Distribusi::where('user_id', $request->id)
    			->where('status', '0') // belum terkonfirmasi
    			->where('open', '0') //masih berlangsung
    			->orderBy('created_at', 'desc')
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

    	$data = Distribusi::where('user_id', $request->user_id)
    			->where('status', '1') // terkonfirmasi
    			->where('open', '0') //masih berlangsung
    			->orderBy('created_at', 'desc')
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

    	$data = Distribusi::where('user_id', $request->user_id)
    			->where('status', '1') // terkonfirmasi
    			->where('open', '1') // telah ditutup (riwayat)
    			->orderBy('created_at', 'desc')
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
