<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;

class LoginPengecerController extends Controller
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
		if($user->role != 'pengecer') {
			return response()->json([
				'status'    => false,
				'message'   => 'Anda BUKAN Pengecer',
			]);
		}

		return response()->json([
			'status'    => true,
			'message'   => 'Berhasil login pengecer',
			'id'		=> $user->id,
			'nama'		=> $user->name,
			'email'		=> $user->email,
			'nohp'		=> $user->nohp,
			'noktp'		=> $user->noktp,
			'alanat'	=> $user->alamat
		]); 
	}

	public function profile($id) //profile pengecer 
	{
		$data = User::find($id);

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
