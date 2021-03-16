@extends('layouts.template')

@section('title')
Profile
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
          <h2 class="card-title"><i class="fa fa-user-cog"></i> Profile</h2>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="alert alert-light alert-dismissible fade show" role="alert">
            <ul class="text-secondary"> 
              <li>Hati-hati saat Anda mengubah password.</li>
              <li>Ubahlah Informasi Akun Anda.</li>
              <li>Email tidak dapat diubah.</li>
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="card">
            <div class="card-body">
              @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{session('success')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <br>
              @elseif(session('error'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{session('error')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <br>
              @endif
              <form action="{{route('profile.admin.update')}}" method="post">
                @csrf
                {{ method_field('PUT') }}
                <!-- <input name="_method" type="hidden" value="PUT"> -->
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Nama</label>
                    <input type="text" class="form-control" value="{{Auth::guard('admin')->user()->name}}" name="nama">
                  </div>
                  <div class="form-group col-md-6">
                    <label>Email</label>
                    <input type="text" class="form-control" value="{{Auth::guard('admin')->user()->email}}" disabled>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label>Password Baru</label>
                    <input type="password" class="form-control" name="password">
                  </div>
                  <div class="form-group col-md-6">
                    <label>Konfirmasi Password</label>
                    <input type="password" class="form-control" name="password_confirmation">
                  </div>
                </div>
                <button type="submit" class="btn btn-primary">Ubah profile</button>
              </form>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->

@endsection