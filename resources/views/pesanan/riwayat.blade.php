@extends('layouts.template')

@section('title')
Riwayat Pesanan
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
          <h2 class="card-title"><i class="fa fa-history"></i> Riwayat Pesanan</h2>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="card">
            <div class="card-body">
             <div class="float-left">
              <h4 >Daftar Riwayat Pesanan</h4>
            </div>
            <br>
            <br>

            <div class="table-responsive-sm">
              <table id="tabel_admin" class="table table-bordered" style="width:100% !important; ">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Nama Pengecer</th>
                    <th>Jumlah Ayam</th>
                    <th>Nohp</th>
                    <th>Alamat</th>
                    <th>Waktu Pesan</th>
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

  function berhasil(status, pesan) {
    Swal.fire({
      type: status,
      title: pesan,
      showConfirmButton: true,
      button: "Ok"
    })
  } 

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
                "url":  '{{route("table.riwayatpesanan")}}', // URL file untuk proses select datanya
                "type": "GET"
              },
              "columns": [
              { data: 'DT_RowIndex', name:'DT_RowIndex'},
              { "data": "user.name" },
              { "data": "jumlah_ayam" },
              { "data": "nohp" },
              { "data": "user.alamat" },
              { "data": "created_at" },
              ]
            });
  });
</script>
@endsection