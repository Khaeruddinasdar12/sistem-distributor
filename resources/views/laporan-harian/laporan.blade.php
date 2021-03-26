@extends('layouts.template')

@section('title')
Laporan Harian Distribusi
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
</div>
<!-- /.content-header -->
<section class="content">
  <div class="row">
    <div class="col-12">

      <div class="card">
        <div class="card-header">
          <h2 class="card-title"><i class="fa fa-calendar"></i> Laporan Harian Distribusi </h2>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="alert alert-light">
            <table>
              <tr>
                <td>No. Distribusi</td>
                <td>:</td>
                <td>{{$data->no_distribusi}}</td>
              </tr>
              <tr>
                <td>Nama Peternak</td>
                <td>:</td>
                <td>{{$data->user->name}}</td>
              </tr>
              <tr>
                <td>Nama Obat</td>
                <td>:</td>
                <td>{{$data->obat->nama}}</td>
              </tr>
              <tr>
                <td>Jumlah Obat</td>
                <td>:</td>
                <td>{{$data->jumlah_obat}}</td>
              </tr>
              <tr>
                <td>Nama Pakan</td>
                <td>:</td>
                <td>{{$data->pakan->nama}}</td>
              </tr>
              <tr>
                <td>Jumlah Pakan</td>
                <td>:</td>
                <td>{{$data->jumlah_pakan}}</td>
              </tr>
              <tr>
                <td>Jumlah Ayam</td>
                <td>:</td>
                <td>{{$data->jumlah_ayam}}</td>
              </tr>
              <tr>
                <td>Status</td>
                <td>:</td>
                @php $sts = 'danger'; $msg = ''; @endphp

                @if($data->open == "1")
                  @php 
                    $sts = 'warning'; 
                    $msg = 'Distribusi Masih Berlangsung'; 
                  @endphp
                @else
                  @php 
                    $sts = 'danger'; 
                    $msg = 'Distribusi Ditutup'; 
                  @endphp
                @endif
                <td><span class="badge badge-{{$sts}}">{{$msg}}</span></td>
              </tr>
            </table>
          </div>

          <div class="card">
            <div class="card-body">
             <div class="float-left">
              <h4 >Laporan Harian Distribusi</h4>
            </div>
            <br>

            <div class="table-responsive-sm">
              <table class="table table-bordered" style="width:100% !important; ">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Jumlah Ayam</th>
                    <th>Umur Ayam</th>
                    <th>Total Kematian</th>
                    <th>BW</th>
                    <th>FCR</th>
                    <th>Pakan Terpakai</th>
                    <th>Stok Pakan</th>
                    <th>Waktu</th>
                  </tr>
                </thead> 
                @php $no = 1; @endphp
                <tbody>
                  @foreach($data->laporan as $dt)
                  <tr>
                    <td>{{$no++}}</td>
                    <td>{{$dt->jumlah_ayam}}</td>
                    <td>{{$dt->umur_ayam}}</td>
                    <td>{{$dt->total_kematian}}</td>
                    <td>{{$dt->bw}}</td>
                    <td>{{$dt->fcr}}</td>
                    <td>{{$dt->total_pakan_terpakai}}</td>
                    <td>{{$dt->stok_pakan}}</td>
                    <td>{{$dt->created_at}}</td>
                  </tr>
                  @endforeach
                </tbody> 
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
@endsection
