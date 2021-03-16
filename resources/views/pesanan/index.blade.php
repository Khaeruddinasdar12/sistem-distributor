@extends('layouts.template')

@section('title')
Pesanan
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
          <h2 class="card-title"><i class="fa fa-cash-register"></i> Pesanan</h2>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="card">
            <div class="card-body">
             <div class="float-left">
              <h4 >Daftar Pesanan</h4>
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

  function berhasil(status, pesan) {
    Swal.fire({
      type: status,
      title: pesan,
      showConfirmButton: true,
      button: "Ok"
    })
  } 
  function konfirmasi() { //hapus data obat
   $(document).on('click', '#konfirmasi_id', function(){
    Swal.fire({
      title: 'Anda Yakin ?',
      text: "Pastikan data yang diubah telah di cek!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Lanjutkan!',
      timer: 6500
    }).then((result) => {
      if (result.value) {
        var me = $(this),
        url = me.attr('href'),
        token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
          url: url,
          method: "POST",
          data : {
            '_method' : 'PUT',
            '_token'  : token
          },
          success:function(data){
            berhasil(data.status, data.pesan);
            $('#tabel_admin').DataTable().ajax.reload();
            // $('#table_admin').DataTable().ajax.reload();
          },
          error: function(xhr, status, error){
            var error = xhr.responseJSON; 
            if ($.isEmptyObject(error) == false) {
              $.each(error.errors, function(key, value) {
                gagal(key, value);
              });
            }
          } 
        });
      }
    });
  });
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
                "url":  '{{route("table.pesanan")}}', // URL file untuk proses select datanya
                "type": "GET"
              },
              "columns": [
              { data: 'DT_RowIndex', name:'DT_RowIndex'},
              { "data": "user.name" },
              { "data": "jumlah_ayam" },
              { "data": "nohp" },
              { "data": "user.alamat" },
              { "data": "created_at" },
              { "data": "action" },
              ]
            });
});
</script>
@endsection