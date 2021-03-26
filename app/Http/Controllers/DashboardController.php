<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Distribusi;
use App\User;
use App\Pesanan;
class DashboardController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $jmlDistribusiAktif = Distribusi::where('status', '1')
                        ->where('open', '0')
                        ->count();
        $jmlPeternak = User::where('role', 'peternak')->count();
        $jmlPengecer = User::where('role', 'pengecer')->count();
        $jmlPesanan = Pesanan::where('status', '0')->count();
        // return $jmlDistribusiAktif;
    	return view('dashboard.index', [
            'jmlDistribusiAktif' => $jmlDistribusiAktif,
            'jmlPeternak' => $jmlPeternak,
            'jmlPengecer' => $jmlPengecer,
            'jmlPesanan' => $jmlPesanan,
        ]);
    }

    // public function profile()
    // {
    // 	return view('dashboard.index');
    // }
}
