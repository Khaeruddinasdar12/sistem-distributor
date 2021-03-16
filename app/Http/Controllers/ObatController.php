<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Obat;
use DataTables;

class ObatController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth:admin');
	}

    public function index() // menampilkan halaman obat
    {
    	return view('obat.index');
    }

    public function store(Request $request) // tambah data obat
    {	
    	// return $arrayName = array(
    	// 	'status' => 'success',
    	// 	'pesan' => 'Berhasil Menambah Obat. '
    	// );
    	$validasi = $this->validate($request, [
    		'nama' => 'required|string',
    		'stok' => 'required|numeric',
    	]);

    	$data = new Obat;
    	$data->nama 	= $request->nama;
    	$data->stok 	= $request->stok;
    	$data->save();

    	return $arrayName = array(
    		'status' => 'success',
    		'pesan' => 'Berhasil Menambah Obat. '
    	);
    }

    public function update(Request $request) // mengubah data obat
    {	
    	$validasi = $this->validate($request, [
    		'nama' => 'required|string',
    		'stok' => 'required|numeric',
    	]);

    	$id = $request->id;
    	$data = Obat::findOrFail($id);
    	$data->nama 	= $request->nama;
    	$data->stok 	= $request->stok;
    	$data->save();

    	return $arrayName = array(
    		'status' => 'success',
    		'pesan' => 'Berhasil Mengubah Data Obat. '
    	);
    }

    public function delete($id) //menghapus data obat
    {	
    	// $id = $request->id;
    	$data = Obat::findOrFail($id);
    	$data->delete();

    	return $arrayName = array(
    		'status' => 'success',
    		'pesan' => 'Berhasil Menghapus Data Obat. '
    	);
    }

    public function table() // api table obat untuk datatable
    {
    	$data = Obat::select('id', 'nama', 'stok')
    	->orderBy('created_at', 'desc')
    	->get();

    	return Datatables::of($data)
    	->addColumn('action', function ($data) {
    		return "
    		<a class='btn btn-success btn-xs'
    		data-toggle='modal' 
    		data-target='#modal-edit-data'
    		title='edit obat' 
    		href='manage-pengecer'
    		data-id='".$data->id."'
    		data-nama='".$data->nama."'
    		data-stok='".$data->stok."'
    		>
    		<i class='fa fa-edit'></i>
    		</a>
    		<button class='btn btn-danger btn-xs'
    		title='hapus obat'
    		id='del_id' 
    		onclick='hapus_data()'
    		data-id='".$data->id."'
    		href='manage-obat/".$data->id."'
    		>
    		<i class='fa fa-trash'></i>
    		</button>";
    	})
    	->addIndexColumn() 
    	->make(true);
    }
}
