@extends('layouts.template')

@section('title')
Riwayat Distribusi
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
          <h2 class="card-title"><i class="fa fa-hourglass-half"></i> Manage Distribusi</h2>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="card">
            <div class="card-body">
             <div class="float-left">
              <h4>Riwayat Distribusi</h4>
            </div>

            <div class="table-responsive-sm">
              <table id="tabel_admin" class="table table-bordered" style="width:100% !important; ">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>No Distribusi</th>
                    <th>Peternak</th>
                    <th>Alamat</th>
                    <th>Nama Obat</th>
                    <th>Jumlah Obat (Bungkus)</th>
                    <th>Nama Pakan</th>
                    <th>Jumlah Pakan (Bungkus)</th>
                    <th>Jumlah Ayam (Ekor)</th>
                    <th>Action</th>
                  </tr>
                </thead>  
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

@section('js')
<script type="text/javascript">
  tabel = $(document).ready(function(){
    $('#tabel_admin').DataTable({
      "processing": true,

      "serverSide": true,
      "deferRender": true,
      "ordering": true,
        // "scrollX" : true,
        "order": [[ 0, 'desc' ]],
        "aLengthMenu": [[10, 25, 50],[ 10, 25, 50]],
        "ajax":  {
                "url":  '{{route("table.distribusi.riwayat")}}', // URL file untuk proses select datanya
                "type": "GET"
              },
              "columns": [
              { data: 'DT_RowIndex', name:'DT_RowIndex'},
              { "data": "no_distribusi" },
              { "data": "user.name" },
              { "data": "user.alamat" },
              { "data": "obat.nama" },
              { "data": "jumlah_obat"},
              { "data": "pakan.nama" },
              { "data": "jumlah_pakan" },
              { "data": "jumlah_ayam" },
              { "data": "action" },
              ]
            });
  });
</script>
@endsection