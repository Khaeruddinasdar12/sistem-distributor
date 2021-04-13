<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use App\Distribusi;
use App\User;
use App\Pesanan;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
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

		$data = Admin::find($request->admin_id);

        $jmlDistribusiAktif = Distribusi::where('status', '1')
                        ->where('open', '0')
                        ->count();
        $jmlPeternak = User::where('role', 'peternak')->count();
        $jmlPengecer = User::where('role', 'pengecer')->count();
        $jmlPesanan = Pesanan::where('status', '0')->count();

        return response()->json([
            'status'    => true,
            'message'   => 'Page Dashboard',
            'jmlDistribusiAktif' => $jmlDistribusiAktif,
            'jmlPeternak' => $jmlPeternak,
            'jmlPengecer' => $jmlPengecer,
            'jmlPesanan' => $jmlPesanan,
        ]);
    }
}
