@extends('layouts.template')

@section('title')
Laporan Harian
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
          <h2 class="card-title"><i class="fa fa-calendar"></i> Laporan Harian</h2>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="card">
            <div class="card-body">
             <div class="float-left">
              <h4 >Laporan Harian</h4>
            </div>
            <div class="float-right">
              <input type="date" value="" name="waktu" class="form-control" id="filter">
            </div> 
            <br>
            <br>
            <div class="table-responsive-sm">
              <table id="tabel_admin" class="table table-bordered" style="width:100% !important; ">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>No. Distribusi</th>
                    <th>Nama Peternak</th>
                    <th>Jumlah Ayam</th>
                    <th>Umur Ayam</th>
                    <th>Total Kematian</th>
                    <th>BW</th>
                    <th>FCR</th>
                    <th>Pakan Terpakai</th>
                    <th>Stok Pakan</th>
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

<!-- Modal Lihat Data Distribusi -->
<div class="modal fade" id="modal-detail-distribusi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Data Distribusi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table>
          <tr>
            <td>No. Distribusi</td>
            <td>:</td>
            <td id="no_distribusi"></td>
          </tr>
          <tr>
            <td>Jumlah Ayam</td>
            <td>:</td>
            <td id="jml_ayam"></td>
          </tr>
          <tr>
            <td>Jumlah Obat</td>
            <td>:</td>
            <td id="jml_obat"></td>
          </tr>
          <tr>
            <td>Jumlah Pakan</td>
            <td>:</td>
            <td id="jml_pakan"></td>
          </tr>
          <tr>
            <td>Nama Peternak</td>
            <td>:</td>
            <td id="nama_peternak"></td>
          </tr>
          <tr>
            <td>Email</td>
            <td>:</td>
            <td id="email"></td>
          </tr>
          <tr>
            <td>No Hp</td>
            <td>:</td>
            <td id="nohp"></td>
          </tr>
          <tr>
            <td>No KTP</td>
            <td>:</td>
            <td id="noktp"></td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modal Lihat Data Distribusi -->
@endsection

@section('js')
<script type="text/javascript">
  $('#modal-detail-distribusi').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var no_distribusi = button.data('no_distribusi') 
  var jml_ayam = button.data('jml_ayam') 
  var jml_obat = button.data('jml_obat') 
  var jml_pakan = button.data('jml_pakan')
  var nama_peternak = button.data('nama_peternak') 
  var email = button.data('email') 
  var nohp = button.data('nohp') 
  var noktp = button.data('noktp')  

  var modal = $(this)
  modal.find('.modal-body #no_distribusi').text(no_distribusi)
  modal.find('.modal-body #jml_ayam').text(jml_ayam)
  modal.find('.modal-body #jml_obat').text(jml_obat)
  modal.find('.modal-body #jml_pakan').text(jml_pakan)
  modal.find('.modal-body #nama_peternak').text(nama_peternak)
  modal.find('.modal-body #email').text(email)
  modal.find('.modal-body #nohp').text(nohp)
  modal.find('.modal-body #noktp').text(noktp)
})

  Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
  });



  $(document).ready(function () {

    $('#filter').val(new Date().toDateInputValue()); //set type date todays value
    

    datatable(); //load datatable

    $('#filter').change(function(){ // 
      var filter_waktu = $('#filter').val();
      if (filter_waktu != '') {
        $('#tabel_admin').DataTable().destroy();
        datatable(filter_waktu);
      } else {
        alert('Pilih filter waktu!');
      }
    });

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
          "url":  '{{route("table.laporanharian")}}', // URL file untuk proses select datanya
          "type": "GET",
          "data": {waktu:waktu}
        },
        "columns": [
        { data: 'DT_RowIndex', name:'DT_RowIndex'},
        { "data": "distribusi.no_distribusi" },
        { "data": "distribusi.user.name" },
        { "data": "jumlah_ayam" },
        { "data": "umur_ayam" },
        { "data": "total_kematian" },
        { "data": "bw" },
        { "data": "fcr" },
        { "data": "total_pakan_terpakai" },
        { "data": "stok_pakan" },
        { "data": "action" },
        ]
      });
    }

  });

  
  
</script>
@endsection