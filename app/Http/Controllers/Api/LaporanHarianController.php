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
            'status'    => false,
            'message'   => 'Berhasil menginput laporan harian '. $time->isoFormat('dddd, D MMMM Y')
        ]);

    }
}
