@extends('layouts.template')

@section('title')
Tambah Distribusi
@endsection

@section('content')
<div class="content-header">
</div>

<section class="content">
  <div class="row">
    <div class="col-12">

      <div class="card">
        <div class="card-header">
          <h2 class="card-title"><i class="fa fa-hourglass-half"></i> Manage Distribusi</h2>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <!-- tambah distribusi -->
            <div class="card">
              <div class="card-body">
               <div class="float-left">
                <h4 >Form Tambah Distribusi</h4>
              </div>
              <form id="add-distribusi" method="post">
                @csrf
                <div class="float-right">
                  <button class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Distribusi</button>
                </div> 
                <br>
                <br>
                <div class="row">
                  <div class="col-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="form-group">
                          <label class="col-form-label">Nama Peternak:</label>
                          <select class="form-control" id="peternak" name="id_peternak">
                            <option>Pilih Peternak</option>
                            @foreach($peternak as $data)
                            <option value="{{$data->id}}">{{$data->name}} ID {{$data->id}}</option>
                            @endforeach
                          </select>
                        </div>
                        <h6>Keterangan peternak:</h6>
                        <ul>
                          <li id="ket_nama">Nama : </li>
                          <li id="ket_nohp">No HP : </li>
                          <li id="ket_alamat">Alamat : </li>
                          <li id="ket_email">Email : </li>
                          <li id="ket_ktp">No KTP : </li>
                        </ul>
                        <div class="form-group">
                          <label class="col-form-label">Jumlah Ayam (Ekor):</label>
                          <input type="text" class="form-control" name="jumlah_ayam">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="form-group">
                          <label class="col-form-label">Nama Pakan:</label>
                          <select class="form-control" id="pakan" name="id_pakan">
                            <option>Pilih Pakan</option>
                            @foreach($pakan as $data)
                            <option value="{{$data->id}}">{{$data->nama}}</option>
                            @endforeach
                          </select>
                        </div>
                        <h6>Keterangan pakan:</h6>
                        <ul>
                          <li id="nama_pakan">Nama Pakan : </li>
                          <li id="stok_pakan">Stok : </li>
                          <br>
                          <br>
                          <br>
                        </ul>
                        <div class="form-group">
                          <label class="col-form-label">Jumlah Pakan (Bungkus):</label>
                          <input type="text" class="form-control" name="jumlah_pakan">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="card">
                      <div class="card-body">
                        <div class="form-group">
                          <label class="col-form-label">Nama Obat:</label>
                          <select class="form-control" id="obat" name="id_obat">
                            <option>Pilih Obat</option>
                            @foreach($obat as $data)
                            <option value="{{$data->id}}">{{$data->nama}}</option>
                            @endforeach
                          </select>
                        </div>
                        <h6>Keterangan obat:</h6>
                        <ul>
                          <li id="nama_obat">Nama Obat : </li>
                          <li id="stok_obat">Stok : </li>
                          <br>
                          <br>
                          <br>
                        </ul>
                        <div class="form-group">
                          <label class="col-form-label">Jumlah Obat (Bungkus):</label>
                          <input type="text" class="form-control" name="jumlah_obat">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- end tambah distribusi -->

          <div class="card">
            <div class="card-body">
             <div class="float-left">
              <h4 >Daftar Distribusi Belum Terkonfirmasi</h4>
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
  function hapus_data() { //membatalkan (menghapus) distribusi belum terkonfirmasi
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

  $('#add-distribusi').submit(function(e){ // tambah pengecer
    e.preventDefault();

    var request = new FormData(this);
    var endpoint= '{{route("distribusi.tambah.store")}}';
    $.ajax({
      url: endpoint,
      method: "POST",
      data: request,
      contentType: false,
      cache: false,
      processData: false,
            // dataType: "json",
            success:function(data){
              if(data.status == 'success') {
                $('#add-distribusi')[0].reset();
              }
              $('#tabel_admin').DataTable().ajax.reload();
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

  $('#peternak').on('change', function() { //keterangan peternak
    var id = $('#peternak').val();
    $.ajax({
      'url': "keterangan-peternak/"+id,
      'dataType': 'json',
      success:function(data){
        $('#ket_nama').text("Nama : "+data.name);
        $('#ket_nohp').text("No HP : "+data.nohp);
        $('#ket_alamat').text("Alamat : "+data.alamat);
        $('#ket_email').text("Email : "+data.email);
        $('#ket_ktp').text("No KTP : "+data.noktp);
      }
    })
  });

  $('#pakan').on('change', function() { //keterangan pakan
    var id = $('#pakan').val();
    $.ajax({
      'url': "keterangan-pakan/"+id,
      'dataType': 'json',
      success:function(data){
        $('#nama_pakan').text("Nama Pakan : "+data.nama);
        $('#stok_pakan').text("Stok : "+data.stok+" Bungkus");
      }
    })
  });

  $('#obat').on('change', function() { //keterangan obat
    var id = $('#obat').val();
    $.ajax({
      'url': "keterangan-obat/"+id,
      'dataType': 'json',
      success:function(data){
        $('#nama_obat').text("Nama Obat : "+data.nama);
        $('#stok_obat').text("Stok : "+data.stok+" Bungkus");
      }
    })
  });

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
    var endpoint= '{{route("manage.peternak.update")}}';
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
    var endpoint= '{{route("manage.peternak.store")}}';
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
                "url":  '{{route("table.distribusi.unconfirmed")}}', // URL file untuk proses select datanya
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