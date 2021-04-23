<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DataTables;

class ManagePeternak extends Controller
{
    public function __construct()
    {
      $this->middleware('auth:admin');
  }

  public function index()
  {
      return view('manage-peternak.index');
  }

    public function store(Request $request) // tambah data peternak
    {	
    	$validasi = $this->validate($request, [
    		'nama' => 'required|string',
    		'email' => 'required|string|email|unique:users',
    		'password' => 'required|string|min:8|confirmed',
    		'noktp' => 'required|string',
    		'nohp' => 'required|string',
    		'alamat' => 'required|string',
    	]);

    	$data = new User;
    	$data->role 	= 'peternak';
    	$data->name 	= $request->nama;
    	$data->email 	= $request->email;
    	$data->password = bcrypt($request->password);
    	$data->noktp 	= $request->noktp;
    	$data->nohp 	= $request->nohp;
    	$data->alamat 	= $request->alamat;
    	$data->save();

    	return $arrayName = array(
    		'status' => 'success',
    		'pesan' => 'Berhasil Menambah Peternak.'
    	);
    }

	public function update(Request $request) //ubah data admin
	{
		$validasi = $this->validate($request, [
			'nama' => 'required',
			'noktp' => 'required',
			'nohp' => 'required',
			'alamat' => 'required',
		]);

		if($request->password != null) {
			if(strlen($request->password) < 8) {
				return $arrayName = array(
					'status' => 'error',
					'pesan' => 'Password minimal 8 digit'
				);
			}
			if($request->password != $request->password_confirmation) {
				return $arrayName = array(
					'status' => 'error',
					'pesan' => 'Password tidak sama'
				);
			}
		}

		$id = $request->id;
		$data = User::findOrFail($id);
		$data->name 	= $request->nama;
		$data->noktp 	= $request->noktp;
		$data->nohp 	= $request->nohp;
		$data->alamat 	= $request->alamat;
		if($request->password == null) {
			$data->password = bcrypt($request->password);
		}

		$data->save();

		return $arrayName = array(
			'status' => 'success',
			'pesan' => 'Berhasil mengubah data peternak'
		);
	}

    public function delete($id) // delete peterenak
    {
        $data = User::findOrFail($id);
        if($data->role != 'peternak') {
            return $arrayName = array(
                'status'    => 'error',
                'pesan'     => 'User ini bukan peternak, user ini pengecer'
            );
        }
        $data->delete();
        return $arrayName = array(
            'status'    => 'success',
            'pesan'     => 'Berhasil Menghapus Data Peternak'
        );
    }

    public function table() // api table user (role pengecer) untuk datatable
    {
    	$data = User::select('id', 'name', 'noktp', 'email', 'nohp', 'alamat')
    	->where('role', 'peternak')
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
    		data-name='".$data->name."'
    		data-email='".$data->email."'
    		data-nohp='".$data->nohp."'
    		data-noktp='".$data->noktp."'
    		data-alamat='".$data->alamat."'
    		>
    		<i class='fa fa-user-edit'></i>
    		</a>

            <button class='btn btn-danger btn-xs'
            title='Hapus Peternak' 
            href='manage-peternak/".$data->id."'
            onclick='hapus_data()'
            id='del_id'
            >
            <i class='fa fa-trash'></i>
            </button>";
    	})
    	->addIndexColumn() 
    	->make(true);
    }
}
