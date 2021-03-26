<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LaporanHarian;
use Yajra\DataTables\DataTables;
use illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use App\Distribusi;

class LaporanHarianController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:admin');
	}

	public function index()
	{
		return view('laporan-harian.index');
	}

	public function laporan($id) //laporan harian distribusi
	{
		$data = Distribusi::where('no_distribusi', $id)
				->where('status', '1') //status distribusi terkonfirmasi peternak
				->with('laporan')
				->with('user:id,name')
				->with('pakan:id,nama')
				->with('obat:id,nama')
				->first();
// return $data;
		return view('laporan-harian.laporan', ['data' => $data]);
	}

	public function table(Request $request) // api table laporan harian untuk datatable
	{
		$time = Carbon::now();
		$wkt = $time->format('Y-m-d');
		
		if (!empty($request->waktu)) {
			$data = LaporanHarian::with('distribusi:id,no_distribusi,user_id,obat_id,jumlah_obat,pakan_id,jumlah_pakan,jumlah_ayam', 'distribusi.user:id,name,email,nohp,noktp', 'distribusi.obat:id,nama', 'distribusi.pakan:id,nama')
			->whereDate('created_at', $request->waktu)
			->orderBy('created_at', 'desc')
			->get();
		} else {
			$data = LaporanHarian::with('distribusi:id,no_distribusi,user_id,obat_id,jumlah_obat,pakan_id,jumlah_pakan,jumlah_ayam', 'distribusi.user:id,name,email,nohp,noktp', 'distribusi.obat:id,nama', 'distribusi.pakan:id,nama')
			->orderBy('created_at', 'desc')
			->whereDate('created_at', $wkt)
			->get();
		}

		return DataTables::of($data)
		->addIndexColumn()
		->addColumn('action', function ($data) {
			return "
			<a href ='#' class='btn btn-info btn-xs'
			title='lihat detail distribusi'
			data-toggle='modal' 
    		data-target='#modal-detail-distribusi'
    		data-no_distribusi='".$data->distribusi->no_distribusi."'
    		data-jml_ayam='".$data->distribusi->jumlah_ayam."'
    		data-jml_obat='".$data->distribusi->jumlah_obat."'
    		data-jml_pakan='".$data->distribusi->jumlah_pakan."'
    		data-nama_peternak='".$data->distribusi->user->name."'
    		data-email='".$data->distribusi->user->email."'
    		data-nohp='".$data->distribusi->user->nohp."'
    		data-noktp='".$data->distribusi->user->noktp."'

			>
			<i class='fa fa-eye'></i>
			</a>
			<a href ='laporan-harian/".$data->distribusi->no_distribusi."' class='btn btn-secondary btn-xs'
			title='lihat laporan harian distribusi'

			>
			<i class='fa fa-clipboard-list'></i>
			</a>";
		})
		->make(true);
	}
}
