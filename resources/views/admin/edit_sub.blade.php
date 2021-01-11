@extends('layouts.app_admin')

@section('content_header') 
  <div class="col-md-12">
      <div class="panel block">
          <div class="panel-body">
              <h1>Edit Subkarakteristik</h1>
              <ol class="breadcrumb">
                  <li><a href="{{asset('/admin/edit_sub')}}"></i>Admin</a></li>
                  <li class="active">Edit Subkarakteristik</li>
              </ol>
          </div>
      </div>
  </div>
@endsection

@section('content')
 <div class="col-md-12 top-20 padding-0">
    <div class="col-md-12">
      <div class="panel">
        <div class="panel-heading"><h3>Daftar Admin</h3></div>
          <div class="panel-body">
            
            <form action="{{route('update.sub', $subkarakteristik->sk_id)}}" method="POST">
                {{ csrf_field() }}

                    <div class="form-group">
                        <label>Sub Karakteristik Baru :</label>
                        <div>
                          <input type="text" class="form-control" name="sk_nama" value="{{ $subkarakteristik->sk_nama}}"required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Bobot Relatif Baru :</label>
                        <div>
                          <input type="text" class="form-control" name="bobot_relatif" value="{{ $subkarakteristik->bobot_relatif}}"required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary ">Update</button>
                    <a onclick="return confirm('Perubahan anda belum disimpan. Tetap tinggalkan halaman ini ?')" href="{{asset('/superadmin/user')}}" class="btn btn-secondary"> Cancel</a>
            </form>

        </div>
      </div>
    </div>
</div>
@endsection


