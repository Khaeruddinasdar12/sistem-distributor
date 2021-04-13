<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Obat;
use App\Pakan;
use App\Distribusi;
use Auth;
use Carbon\Carbon;
use DataTables;

class DistribusiController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:admin');
	}

    public function tambah() //menampilkan hal tambah distribusi
    {
    	$peternak = User::select('id', 'name')->where('role', 'peternak')->get();
    	$obat = Obat::select('id', 'nama')->get();
    	$pakan = Pakan::select('id', 'nama')->get();
    	return view('distribusi.tambah', [
    		'peternak' 	=> $peternak,
    		'obat' 		=> $obat,
    		'pakan' 	=> $pakan,
    	]);
    }

    public function delete($id) //membatalkan (menghapus) distribusi belum terkonfirmasi
    {	
    	// $id = $request->id;
    	$data = Distribusi::findOrFail($id);
    	$data->delete();

    	return $arrayName = array(
    		'status' => 'success',
    		'pesan' => 'Berhasil Membatalkan Distribusi. '
    	);
    }

    public function sedang() //menampilkan hal sedang distribusi (sedang distribusi)
    {
    	return view('distribusi.sedang');
    }
    public function tableSedang() // api table sedang distribusi (sedang berlangsung)
    {
        $data = Distribusi::select('id', 'no_distribusi', 'user_id', 'pakan_id', 'obat_id', 'jumlah_ayam', 'jumlah_obat', 'jumlah_pakan')
        ->where('status', '1') //terkonfirmasi peternak
        ->where('open', '0') //masih berlangsung
        ->with('user:id,name,alamat,nohp')
        ->with('pakan:id,nama')
        ->with('obat:id,nama')
        ->orderBy('created_at', 'desc')
        ->get();

        return Datatables::of($data)
        ->addColumn('action', function ($data) {
    		return "
    		<a href ='/admin/laporan-harian/".$data->no_distribusi."' class='btn btn-warning btn-xs'
    		title='lihat laporan harian'
    		>
    		<i class='fa fa-eye'></i>
    		</a>";
    	})
        ->addIndexColumn() 
        ->make(true);
    }

    public function riwayat() //menampilkan hal riwayat distribusi
    {
    	return view('distribusi.riwayat');
    }
    public function tableRiwayat() // api table riwayat distribusi
    {
        $data = Distribusi::select('id', 'no_distribusi', 'user_id', 'pakan_id', 'obat_id', 'jumlah_ayam', 'jumlah_obat', 'jumlah_pakan')
        ->where('status', '1') //terkonfirmasi peternak
        ->where('open', '1') //close-tutup 
        ->with('user:id,name,alamat,nohp')
        ->with('pakan:id,nama')
        ->with('obat:id,nama')
        ->orderBy('created_at', 'desc')
        ->get();

        return Datatables::of($data)
        ->addColumn('action', function ($data) {
    		return "
    		<a href ='/admin/laporan-harian/".$data->no_distribusi."' class='btn btn-warning btn-xs'
    		title='lihat laporan harian'
    		>
    		<i class='fa fa-eye'></i>
    		</a>";
    	})
        ->addIndexColumn() 
        ->make(true);
    }

    public function tableUnconfirmed() // api table distribusi belum terkonfirmasi
    {
        $data = Distribusi::select('id', 'no_distribusi', 'user_id', 'pakan_id', 'obat_id', 'jumlah_ayam', 'jumlah_obat', 'jumlah_pakan')
        ->where('status', '0')
        ->where('open', '0')
        ->with('user:id,name,alamat,nohp')
        ->with('pakan:id,nama')
        ->with('obat:id,nama')
        ->orderBy('created_at', 'desc')
        ->get();

        return Datatables::of($data)
        ->addColumn('action', function ($data) {
    		return "
    		<button class='btn btn-danger btn-xs'
    		title='hapus obat'
    		id='del_id' 
    		onclick='hapus_data()'
    		href='cancel-distribusi/".$data->id."'
    		>
    		<i class='fa fa-trash'></i>
    		</button>";
    	})
        ->addIndexColumn() 
        ->make(true);
    }

    public function store(Request $request)
    {
    	$validasi = $this->validate($request, [
    		'id_peternak' 	=> 'required|numeric',
    		'id_pakan' 		=> 'required|numeric',
    		'id_obat' 		=> 'required|numeric',
    		'jumlah_obat' 	=> 'required|numeric|min:1',
    		'jumlah_pakan' 	=> 'required|numeric|min:1',
    		'jumlah_ayam' 	=> 'required|numeric|min:1',
    	]);

    	$time = Carbon::now();
    	$inv = 'INV-'.$time->format('Y').$time->format('m').$time->format('d').$time->format('H').$time->format('i').$time->format('s').$request->id_peternak;
    	
    	$cekPakan = Pakan::findOrFail($request->id_pakan); //cek stok pakan
    	if($cekPakan->stok < $request->jumlah_pakan) {
    		return $arrayName = array(
    			'status' => 'error',
    			'pesan' => 'Stok Pakan Tidak Cukup',
    		);
    	}

    	$cekObat = Obat::findOrFail($request->id_obat); //cek stok obat
    	if($cekObat->stok < $request->jumlah_obat) {
    		return $arrayName = array(
    			'status' => 'error',
    			'pesan' => 'Stok Obat Tidak Cukup',
    		);
    	}

    	$data = new Distribusi;
    	$data->no_distribusi = $inv;
    	$data->user_id = $request->id_peternak;
    	$data->obat_id = $request->id_obat;
    	$data->pakan_id = $request->id_pakan;
    	$data->status = '0'; // 0 = belum dikonfirmasi peternak
    	$data->open = '0'; // distribusi masih berlangsung
    	$data->jumlah_obat = $request->jumlah_obat;
    	$data->jumlah_pakan = $request->jumlah_pakan;
    	$data->jumlah_ayam = $request->jumlah_ayam;
    	$data->admin_id = Auth::guard('admin')->user()->id;
    	$data->save();

        //update pakan & obat
    	if($data) {
    		$cekObat->stok = $cekObat->stok - $request->jumlah_obat;
    		$cekObat->save();
    		$cekPakan->stok = $cekPakan->stok - $request->jumlah_pakan;
    		$cekPakan->save();
    	}


    	return $arrayName = array(
    		'status' => 'success',
    		'pesan' => 'Berhasil Menambah Data Distribusi.'
    	);
    }

    public function ket_peternak($id) //keterangan peternak
    {
    	$data = User::findOrFail($id);
    	return $data;
    }

    public function ket_pakan($id) //keterangan pakan
    {
    	$data = Pakan::findOrFail($id);
    	return $data;
    }

    public function ket_obat($id) //keterangan pakan
    {
    	$data = Obat::findOrFail($id);
    	return $data;
    }
}
