<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\LaporanHarian;
use Carbon\Carbon;
use App\User;
use App\Distribusi;
use Illuminate\Support\Facades\Validator;

class LaporanHarianController extends Controller
{
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id'       => 'required|numeric',
            'distribusi_id' => 'required|numeric',
            'jumlah_ayam'   => 'required|numeric',
            'umur_ayam'   => 'required|numeric',
            'total_kematian'   => 'required|numeric',
            'bw'   => 'required|numeric',
            'fcr'   => 'required|numeric',
            'total_pakan_terpakai'   => 'required|numeric',
            'stok_pakan'   => 'required|numeric',
        ]);

        if($validator->fails()) {
            $message = $validator->messages()->first();
            return response()->json([
                'status' => false,
                'messsage' => $message
            ]);
        }

        $data = User::find($request->user_id);

        if($data == '') {
            return response()->json([
                'status'    => false,
                'message'   => 'Id Tidak ditemukan'
            ]);
        }

        if($data->role != 'peternak' ) {
            return response()->json([
                'status'    => false,
                'message'   => 'User ini BUKAN peternak, user ini pengecer'
            ]);
        }

        $data = Distribusi::find($request->distribusi_id);

        if($data == '') {
            return response()->json([
                'status'    => false,
                'message'   => 'Id distribusi tidak ditemukan'
            ]);
        }

        if($data->status != 1) {
            return response()->json([
                'status'    => false,
                'message'   => 'Id distribusi ini tidak aktif'
            ]);
        }

        $time = Carbon::now();

        $cek = LaporanHarian::where('distribusi_id', $request->distribusi_id)
        ->whereDate('created_at', $time->today())
        ->first();
        if($cek != '') {
            return response()->json([
                'status'    => false,
                'message'   => 'Laporan Harian sudah di input'
            ]);
        }
        
        $data = new LaporanHarian;
        $data->distribusi_id = $request->distribusi_id;
        $data->jumlah_ayam  = $request->jumlah_ayam;
        $data->umur_ayam    = $request->umur_ayam;
        $data->total_kematian = $request->total_kematian;
        $data->bw   = $request->bw;
        $data->fcr  = $request->fcr;
        $data->total_pakan_terpakai = $request->total_pakan_terpakai;
        $data->stok_pakan = $request->stok_pakan;
        $data->save();

        return response()->json([
            'status'    => true,
            'message'   => 'Berhasil menginput laporan harian '. $time->isoFormat('dddd, D MMMM Y')
        ]);

    }

    public function list(Request $request) //list laporan harian per id distribusi & id peternak
    {
        $validator = Validator::make($request->all(), [
            'user_id'     => 'required|numeric',
            'distribusi_id' => 'required|numeric',
        ]);

        if($validator->fails()) {
            $message = $validator->messages()->first();
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        $data = User::find($request->user_id);

        if($data == '') {
            return response()->json([
                'status'    => false,
                'message'   => 'Id Tidak ditemukan'
            ]);
        }

        if($data->role != 'peternak' ) {
            return response()->json([
                'status'    => false,
                'message'   => 'User ini BUKAN peternak, user ini pengecer'
            ]);
        }        


        if(!empty($request->waktu)) {
            $arraybln = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"); 
            if(!in_array($request->waktu, $arraybln)) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'bulan harus angka 1-12'
                ]);
            }
            // $bln = date('m', strtotime($request->waktu)); //yyyy-mm-dd
            // $thn = date('Y', strtotime($request->waktu)); //yyyy-mm-dd

            $dt = LaporanHarian::where('distribusi_id', $request->distribusi_id)
            ->whereMonth('created_at', $request->waktu)
            ->whereYear('created_at', 2021)
            ->get();
        } else {
            $time = Carbon::now();
            $blnIni = $time->now()->month;
            $thnIni = $time->now()->year;
            $dt = LaporanHarian::where('distribusi_id', $request->distribusi_id)
            ->whereMonth('created_at', $blnIni)
            ->whereYear('created_at', $thnIni)
            ->get();
        }

        return response()->json([
            'status'    => true,
            'message'   => 'list laporan harian per distribusi & per peternak',
            'data'      => $dt,
        ]);
    }
}
