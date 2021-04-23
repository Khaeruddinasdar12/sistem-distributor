@extends('layouts.template')

@section('title')
Manage Pengecer
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
          <h2 class="card-title"><i class="fa fa-user-cog"></i> Manage Pengecer</h2>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="card">
            <div class="card-body">
             <div class="float-left">
              <h4 >Daftar Pengecer</h4>
            </div>
            <div class="float-right">
              <button class="btn btn-primary" data-toggle="modal" data-target="#tambah-admin"><i class="fa fa-plus"></i> Tambah Pengecer</button>
            </div> 
            <br>
            <br>

            <div class="table-responsive-sm">
              <table id="tabel_admin" class="table table-bordered" style="width:100% !important; ">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>No KTP</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Alamat</th>
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
        <h5 class="modal-title" id="exampleModalLabel">Edit Data Pengecer</h5>
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
            <input type="text" class="form-control" id="name" name="nama">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">No KTP:</label>
            <input type="text" class="form-control" id="noktp" name="noktp">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Email</label>
            <input type="text" class="form-control" id="email" disabled>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">No HP:</label>
            <input type="text" class="form-control" id="nohp" name="nohp">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Alamat:</label>
            <textarea class="form-control" id="alamat" name="alamat"></textarea>
          </div>
          <div class="row">
            <div class="col-6">
              <label>Password</label>
              <input type="password" class="form-control" name="password" placeholder="min. 8 digit">
            </div>
            <div class="col-6">
              <label>Password Confirmation</label>
              <input type="password" class="form-control" name="password_confirmation">
            </div>
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
          <h5 class="modal-title" id="exampleModalLabel">Tambah Pengecer </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" name="nama">
          </div>
          <div class="form-group">
            <label>No. KTP</label>
            <input type="text" class="form-control" name="noktp">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email">
          </div>
          <div class="row">
            <div class="col-6">
              <label>Password</label>
              <input type="password" class="form-control" name="password" placeholder="min. 8 digit">
            </div>
            <div class="col-6">
              <label>Password Confirmation</label>
              <input type="password" class="form-control" name="password_confirmation">
            </div>
          </div>
          <div class="form-group">
            <label>No Hp</label>
            <input type="text" class="form-control" name="nohp">
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <textarea class="form-control" rows="3" name="alamat"></textarea>
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
  var name = button.data('name') 
  var noktp = button.data('noktp') 
  var email = button.data('email') 
  var nohp = button.data('nohp')
  var alamat = button.data('alamat')  

  var modal = $(this)
  modal.find('.modal-body #edit-pengecer').attr('action', href)
  modal.find('.modal-body #hidden-id').val(id)
  modal.find('.modal-body #name').val(name)
  modal.find('.modal-body #noktp').val(noktp)
  modal.find('.modal-body #email').val(email)
  modal.find('.modal-body #nohp').val(nohp)
  modal.find('.modal-body #alamat').val(alamat)
})

  function hapus_data() { //menghapus data pengecer
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
            $('#tabel_admin').DataTable().ajax.reload();
            berhasil(data.status, data.pesan);
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
    var endpoint= '{{route("manage.pengecer.update")}}';
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

  $('#add').submit(function(e){ // tambah pengecer
    e.preventDefault();

    var request = new FormData(this);
    var endpoint= '{{route("manage.pengecer.store")}}';
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
                "url":  '{{route("table.pengecer")}}', // URL file untuk proses select datanya
                "type": "GET"
              },
              "columns": [
              { data: 'DT_RowIndex', name:'DT_RowIndex'},
              { "data": "name" },
              { "data": "noktp" },
              { "data": "email" },
              { "data": "nohp" },
              { "data": "alamat" },
              { "data": "action" },
              ]
            });
  });
</script>
@endsection