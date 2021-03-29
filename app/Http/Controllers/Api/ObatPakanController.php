<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Obat;
use App\Pakan;

class ObatPakanController extends Controller
{
    public function obat()
    {
    	$data = Obat::get();

    	return response()->json([
			'status'    => true,
			'message'   => 'List obat',
			'data'		=> $data,
		]); 
    }

    public function pakan()
    {
    	$data = Pakan::get();

    	return response()->json([
			'status'    => true,
			'message'   => 'List pakan',
			'data'		=> $data,
		]); 
    }
}
