<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Admin;
use Hash;
class LoginAdminController extends Controller
{
	public function login(Request $request)
	{
		$credentials = $request->only('email', 'password');

		if(!Auth::guard('admin')->attempt($credentials)) {
			return response()->json([
				'status'    => false,
				'message'   => 'Kesalahan email atau password',
			]);
		} 

		$user = Auth::guard('admin')->user();

		return response()->json([
			'status'    => true,
			'message'   => 'Berhasil login admin',
			'id'		=> $user->id,
			'nama'		=> $user->name,
			'email'		=> $user->email,
		]); 
	}

	public function profile(Request $request) //profile admin 
	{
		$data = Admin::find($request->user_id);

		if($data == '') {
			return response()->json([
				'status'    => false,
				'message'   => 'Id Tidak ditemukan'
			]);
		}

		return response()->json([
			'status'    => true,
			'message'   => 'Profile admin',
			'id'		=> $data->id,
			'nama'		=> $data->name,
			'email'		=> $data->email,
		]); 
	}
}
