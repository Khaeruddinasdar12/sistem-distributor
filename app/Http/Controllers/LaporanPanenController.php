<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LaporanPanen;
use Yajra\DataTables\DataTables;

class LaporanPanenController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth:admin');
	}

	public function index()
	{
		return view('laporan-panen.index');
	}

	public function table() // api table laporan panen untuk datatable
    {
        $data = LaporanPanen::with('user:id,name,nohp,email')
        ->orderBy('created_at', 'desc')
        ->get();

        return Datatables::of($data)
        ->addIndexColumn() 
        ->make(true);
    }
}
