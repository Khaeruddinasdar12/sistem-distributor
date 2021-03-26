@extends('layouts.template')

@section('title')
Manage Obat
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
          <h2 class="card-title"><i class="fa fa-tablets"></i> Manage Obat</h2>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="card">
            <div class="card-body">
             <div class="float-left">
              <h4 >Daftar Obat</h4>
            </div>
            <div class="float-right">
              <button class="btn btn-primary" data-toggle="modal" data-target="#tambah-admin"><i class="fa fa-plus"></i> Tambah Obat</button>
            </div> 
            <br>
            <br>

            <div class="table-responsive-sm">
              <table id="tabel_admin" class="table table-bordered" style="width:100% !important; ">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Nama Obat</th>
                    <th>Stok</th>
                    <th>Harga</th>
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

<!-- MODAL -->
<!-- Modal Edit -->
<div class="modal fade" id="modal-edit-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Data Obat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post" id="edit-pengecer">
        <div class="modal-body">
          @csrf
          {{ method_field('PUT') }}
          <input type="hidden" name="id" id="hidden-id">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Nama:</label>
            <input type="text" class="form-control" id="nama" name="nama">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Stok (Bungkus):</label>
            <input type="text" class="form-control" id="stok" name="stok">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Harga (Rp):</label>
            <input type="text" class="form-control" id="harga" name="harga">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Edit</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modal Edit -->

<!-- Modal Tambah -->
<div class="modal fade bd-example-modal" id="tambah-admin" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" id="add">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Obat </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label>Nama Obat</label>
            <input type="text" class="form-control" name="nama">
          </div>
          <div class="form-group">
            <label>Stok (Bungkus)</label>
            <input type="number" class="form-control" name="stok">
          </div>
          <div class="form-group">
            <label>Harga (Rp)</label>
            <input type="number" class="form-control" name="harga">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Tambah</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- End Modal Tambah -->
<!-- END MODALS -->
@endsection

@section('js')
<script type="text/javascript">
  $('#modal-edit-data').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var href = button.data('href') 
  var id = button.data('id') 
  var nama = button.data('nama')
  var stok = button.data('stok') 
  var harga = button.data('harga')  

  var modal = $(this)
  modal.find('.modal-body #edit-pengecer').attr('action', href)
  modal.find('.modal-body #hidden-id').val(id)
  modal.find('.modal-body #nama').val(nama)
  modal.find('.modal-body #stok').val(stok)
  modal.find('.modal-body #harga').val(harga)
})

  function berhasil(status, pesan) {
    Swal.fire({
      type: status,
      title: pesan,
      showConfirmButton: true,
      button: "Ok"
    })
  } 

  $('#edit-pengecer').submit(function(e){ //edit pengecer
    e.preventDefault();

    var request = new FormData(this);
    var endpoint= '{{route("manage.obat.update")}}';
    $.ajax({
      url: endpoint,
      method: "POST",
      data: request,
      contentType: false,
      cache: false,
      processData: false,
            // dataType: "json",
            success:function(data){
              $('#add')[0].reset();
              $('#tabel_admin').DataTable().ajax.reload();
              $('#modal-edit-data').modal('hide');
              berhasil(data.status, data.pesan);
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
  });

  $('#add').submit(function(e){ // tambah obat
    e.preventDefault();

    var request = new FormData(this);
    var endpoint= '{{route("manage.obat.store")}}';
    // alert('hai');
    $.ajax({
      url: endpoint,
      method: "POST",
      data: request,
      contentType: false,
      cache: false,
      processData: false,
            // dataType: "json",
            success:function(data){
              $('#add')[0].reset();
              $('#tabel_admin').DataTable().ajax.reload();
              $('#tambah-admin').modal('hide');
              berhasil(data.status, data.pesan);
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
  });

  function hapus_data() { //hapus data obat
   $(document).on('click', '#del_id', function(){
    Swal.fire({
      title: 'Anda Yakin ?',
      text: "Anda tidak dapat mengembalikan data yang telah di hapus!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Lanjutkan Hapus!',
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
            '_method' : 'DELETE',
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
                "url":  '{{route("table.obat")}}', // URL file untuk proses select datanya
                "type": "GET"
              },
              "columns": [
              { data: 'DT_RowIndex', name:'DT_RowIndex'},
              { "data": "nama" },
              { "data": "stok" },
              { "data": "harga" },
              { "data": "action" },
              ]
            });
});
</script>
@endsection