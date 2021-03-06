<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;

class LoginPeternakController extends Controller
{
    public function login(Request $request)
	{
		$credentials = $request->only('email', 'password');

		if(!Auth::attempt($credentials)) {
			return response()->json([
				'status'    => false,
				'message'   => 'Kesalahan email atau password',
			]);
		}    

		$user = Auth::user();
		if($user->role != 'peternak') {
			return response()->json([
				'status'    => false,
				'message'   => 'Anda BUKAN Peternak',
			]);
		}

		return response()->json([
			'status'    => true,
			'message'   => 'Berhasil login peternak',
			'id'		=> $user->id,
			'nama'		=> $user->name,
			'email'		=> $user->email,
			'nohp'		=> $user->nohp,
			'noktp'		=> $user->noktp,
			'alanat'	=> $user->alamat
		]); 
	}

	public function profile(Request $request) //profile pengecer 
	{
		$data = User::find($request->user_id);

		if($data == '') {
			return response()->json([
				'status'    => false,
				'message'   => 'Id Tidak ditemukan'
			]);
		}

		return response()->json([
			'status'    => true,
			'message'   => 'Profile user',
			'id'		=> $data->id,
			'nama'		=> $data->name,
			'email'		=> $data->email,
			'nohp'		=> $data->nohp,
			'noktp'		=> $data->noktp,
			'alanat'	=> $data->alamat
		]); 
	}
}
