<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pakan;
use DataTables;

class PakanController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth:admin');
	}

    public function index() // menampilkan halaman pakan
    {
    	return view('pakan.index');
    }

    public function store(Request $request) // tambah data pakan
    {	
    	$validasi = $this->validate($request, [
    		'nama' => 'required|string',
    		'stok' => 'required|numeric',
    	]);

    	$data = new Pakan;
    	$data->nama 	= $request->nama;
    	$data->stok 	= $request->stok;
        $data->harga    = $request->harga;
    	$data->save();

    	return $arrayName = array(
    		'status' => 'success',
    		'pesan' => 'Berhasil Menambah Pakan. '
    	);
    }

    public function update(Request $request) // mengubah data pakan
    {	
    	$validasi = $this->validate($request, [
    		'nama' => 'required|string',
    		'stok' => 'required|numeric',
    	]);

    	$id = $request->id;
    	$data = Pakan::findOrFail($id);
    	$data->nama 	= $request->nama;
    	$data->stok 	= $request->stok;
        $data->harga    = $request->harga;
    	$data->save();

    	return $arrayName = array(
    		'status' => 'success',
    		'pesan' => 'Berhasil Mengubah Data Pakan. '
    	);
    }

    public function delete($id) //menghapus data pakan
    {	
    	$data = Pakan::findOrFail($id);
    	$data->delete();

    	return $arrayName = array(
    		'status' => 'success',
    		'pesan' => 'Berhasil Menghapus Data Pakan. '
    	);
    }

    public function table() // api table pakan untuk datatable
    {
    	$data = Pakan::select('id', 'nama', 'stok', 'harga')
    	->orderBy('created_at', 'desc')
    	->get();

    	return Datatables::of($data)
    	->addColumn('action', function ($data) {
    		return "
    		<a class='btn btn-success btn-xs'
    		data-toggle='modal' 
    		data-target='#modal-edit-data'
    		title='edit pengecer' 
    		href='manage-pengecer'
    		data-id='".$data->id."'
            data-nama='".$data->nama."'
            data-stok='".$data->stok."'
            data-harga='".$data->harga."'
    		>
    		<i class='fa fa-user-edit'></i>
    		</a>
            <button class='btn btn-danger btn-xs'
            title='hapus obat'
            id='del_id' 
            onclick='hapus_data()'
            data-id='".$data->id."'
            href='manage-pakan/".$data->id."'
            >
            <i class='fa fa-trash'></i>
            </button>";
    	})
        ->editColumn('harga', function($data){
            return "Rp. ".format_uang($data->harga);
        })
    	->addIndexColumn() 
    	->make(true);
    }
}
