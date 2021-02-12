@extends('layouts.app_admin')

@section('content_header') 
  <div class="col-md-12">
      <div class="panel block">
          <div class="panel-body">
              <h1>Kelola Sub Karakteristik</h1>
          </div>
      </div>
  </div>
@endsection

@section('content')
 <div class="col-md-12 top-20 padding-0">
    <div class="col-md-12">
      <div class="panel">
        <div class="panel-heading"><h3>Tambah Sub Karakteristik</h3></div>
          <div class="panel-body">

            <form action="{{route('store.subkarakteristik')}}" method="post">
                {{ csrf_field() }} 
                <div class="form-group">
                  <label>Nama Sub Karakteristik :</label>
                  <div><input type="text" class="form-control"  name="sk_nama" required></div>
                </div>
                <div class="form-group">
                  <label>Bobot Relatif :</label>
                  <div><input type="text" class="form-control"  name="bobot_relatif" required></div>
                </div>
                

                <button type="submit" class="btn btn-primary ">Submit</button>
                <a onclick="return confirm('Perubahan anda belum disimpan. Tetap tinggalkan halaman ini ?')" href="{{('/superadmin/user')}}" class="btn btn-secondary"> Cancel</a>
            </form>
            

        </div>
      </div>
    </div>
</div>
@endsection


