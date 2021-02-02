@extends('layouts.app_softwaretester')

@section('content_header')
  <div class="row">
    <div class="col-md-12">
        <div class="panel block">
            <div class="panel-body">
                <h1>Edit Aplikasi</h1>
                <ol class="breadcrumb">
                    <li><a href="{{asset('/softwaretester/home')}}"></i> Home</a></li>
                    <li><a href="{{asset('/softwaretester/aplikasi')}}"></i> Aplikasi</a></li>
                    <li class="active">Edit Aplikasi</li>
                </ol>
            </div>
        </div>
    </div>
  </div>
@endsection

@section('content')
 <div class="col-md-12 top-20 padding-0">
    <div class="col-md-12">
      <div class="panel">
          <div class="panel-body">
            <hr>
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                  </ul>
                </div>
            @endif
            @include('admin.shared.components.alert')
            <form action="{{route('update.aplikasi', $aplikasi->a_id)}}" method="POST" enctype="multipart/form-data" >
                {{ csrf_field() }}
                    <div class="form-group">
                        <label>Nama Aplikasi :</label>
                        <div>
                          <input type="text" class="form-control" name="a_nama" value="{{ $aplikasi->a_nama}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>URL :</label>
                        <div>
                          <input type="text" class="form-control" name="a_url" value="{{ $aplikasi->a_url}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                      <label>File :</label>
                      <div>  
                        <input type="hidden" name="hidden_file" value="{{ $aplikasi->a_file }}" />
                        <input type="file"  name="a_file" value="{{ $aplikasi->a_file}}">
                      </div>
                    </div> 
                    <button type="submit" class="btn btn-primary ">Update</button>
                    <a onclick="return confirm('Perubahan anda belum disimpan. Tetap tinggalkan halaman ini ?')" href="{{asset('/softwaretester/aplikasi')}}" class="btn btn-secondary"> Cancel</a>
            </form>
        </div>
      </div>
    </div>
  </div>
@endsection



