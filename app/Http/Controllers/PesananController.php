<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pesanan;
use DataTables;
class PesananController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth:admin');
	}

    public function index() // menampilkan halaman pesanan
    {
    	return view('pesanan.index');
    }

    public function riwayat() // menampilkan halaman riwayat pesanan
    {
    	return view('pesanan.riwayat');
    }

    public function konfirmasi($id) // konfirmasi pesanan
    {
    	$data = Pesanan::findOrFail($id);
    	$data->status = '1';
    	$data->save();

    	return $arrayName = array(
    		'status' => 'success',
    		'pesan' => 'Berhasil! Konfirmasi Pesanan Selesai. '
    	);
    }

    public function table() // api table pesanan untuk datatable
    {
    	$data = Pesanan::with('user')
    	->where('status', '0')
    	->orderBy('created_at', 'desc')
    	->get();

    	return Datatables::of($data)
    	->addColumn('action', function ($data) {
    		return "
            <button class='btn btn-warning btn-xs'
            title='konfirmasi pesanan'
            id='konfirmasi_id' 
            onclick='konfirmasi()'
            data-id='".$data->id."'
            href='konfirmasi-pesanan/".$data->id."'
            >
            <i class='fa fa-check'></i>
            </button>";
    	})
    	->addIndexColumn() 
    	->make(true);
    }

    public function tableRiwayat() // api table riwayat pesanan untuk datatable
    {
    	$data = Pesanan::with('user')
    	->where('status', '1')
    	->orderBy('created_at', 'desc')
    	->get();

    	return Datatables::of($data)
    	->addIndexColumn() 
    	->make(true);
    }
}
