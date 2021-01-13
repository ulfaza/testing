@extends('layouts.app_admin')

@section('content_header') 
  <div class="col-md-12">
      <div class="panel block">
          <div class="panel-body">
              <h1>Kelola Sub Karakteristik</h1>
              <ol class="breadcrumb">
                  <li><a href="{{asset('/admin/tambahbobot')}}"></i>Admin</a></li>
                  <li class="active">Sub Karakteristik</li>
              </ol>
          </div>
      </div>
  </div>
@endsection

@section('content')
        <div class="col-md-12 top-20 padding-0">
          <div class="col-md-12">
            <div class="panel">
              <div class="panel-heading"><h3>Daftar Sub Karakteristik</h3></div>
                <div class="panel-body">
                  <a href="{{asset('/admin/karakteristik')}}" class="btn btn-info btn-md">Karakteristik</a><br><br>
                  <div class="responsive-table">
                    <table id="datatables-example" class="table table-striped table-bordered" width="100%" cellspacing="0">
                      <thead>
                        <th>ID</th>
                        <th>Karakteristik</th>
                        <th>Nama Sub Karakteristik</th>
                        <th>Bobot Relatif</th>
                        <th>Aksi</th>
                      </thead>
                      <tbody>
                      @foreach($subkarakteristiks as $subkarakteristik)
                      <tr>
                        <td>{{ $subkarakteristik->sk_id }}</td>
                        <td>{{ $subkarakteristik->karakteristik->k_nama }}</td>
                        <td>{{ $subkarakteristik->sk_nama }}</td>
                        <td>{{ $subkarakteristik->bobot_relatif }}</td>
      
                        <td>
                          <a href="{{route('edit.sub',$subkarakteristik->sk_id)}}" class="btn btn-info btn-sm">
                            <span class="fa fa-pencil"></span>
                          </a>
                          <a onclick="return confirm('Apakah anda yakin akan menghapus data ini ?')" href="{{route('delete.subkarakteristik',$subkarakteristik->sk_id)}}" class="btn btn-danger btn-sm">
                            <span class="fa fa-trash"></span>
                          </a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <a href="#" class="btn btn-info btn-md">Tambah Subkarakteristik</a>
              </div>
            </div>
          </div>
      </div>
    </div>
@endsection
                

