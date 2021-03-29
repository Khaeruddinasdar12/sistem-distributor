@extends('layouts.template')

@section('title')
Laporan Panen
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
          <h2 class="card-title"><i class="fa fa-calendar"></i> Laporan Panen</h2>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="card">
            <div class="card-body">
             <div class="float-left">
              <h4 >Laporan Panen</h4>
            </div>
            <div class="table-responsive-sm">
              <table id="tabel_admin" class="table table-bordered" style="width:100% !important; ">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Nama Peternak</th>
                    <th>No. Polisi</th>
                    <th>Umur Panen</th>
                    <th>Jumlah Panen</th>
                    <th>Waktu</th>
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




  $(document).ready(function () {

    datatable(); //load datatable

    function datatable(waktu = '') {
      $('#tabel_admin').DataTable({
        "processing": true,

        "serverSide": true,
        "deferRender": true,
        "ordering": true,
        // "scrollX" : true,
        "order": [[ 0, 'desc' ]],
        "aLengthMenu": [[10, 25, 50],[ 10, 25, 50]],
        "ajax":{
          "url":  '{{route("table.laporanpanen")}}', // URL file untuk proses select datanya
          "type": "GET",
          "data": {waktu:waktu}
        },
        "columns": [
        { data: 'DT_RowIndex', name:'DT_RowIndex'},
        { "data": "user.name" },
        { "data": "no_polisi" },
        { "data": "umur_panen" },
        { "data": "jumlah_panen" },
        { "data": "created_at"}
        ]
      });
    }

  });

  
  
</script>
@endsection