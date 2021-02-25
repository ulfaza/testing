@extends('layouts.app_softwaretester')

@section('content_header')
  <div class="col-md-12">
    <div class="panel block">
        <div class="panel-body">
            <h1>Pengukuran Otomatis Capacity</h1>
            <ol class="breadcrumb">
                <li><a href="{{asset('/softwaretester/home')}}">Home</a></li>
                <li><a href="{{asset('/softwaretester/aplikasi')}}">Aplikasi</a></li>
                <li><a href="{{route('nilai',$subkarakteristik->karakteristik->aplikasi->a_id)}}">Pengukuran Aplikasi</a></li>
                <li class="active">Pengukuran Otomatis Capacity</li>
            </ol>
        </div>
      </div>
  </div>
@endsection

@section('content')
<div class="col-md-12 padding-0">
  <div class="col-md-12">
    <div class="panel">
        <div class="panel-body">
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
            <h5>Pengukuran otomatis capacity dengan melakukan request bersamaan pada url yang Anda masukkan. Silahkan masukkan jumlah request yang akan dilakukan.
            </h5>
          <form action="{{route('capacity',$subkarakteristik->sk_id)}}" method="post">
              {{ csrf_field() }}
              <div class="form-group">
                <div class="form-group col-md-12">
                    <label class="font-weight-bold">Jumlah Request</label>
                    <input type="text" class="form-control" name="jml_req" value ="" required>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary ">Submit</button>
                    <a onclick="return confirm('Perubahan anda belum disimpan. Tetap tinggalkan halaman ini ?')" href="{{route('nilai',$subkarakteristik->karakteristik->aplikasi->a_id)}}" class="btn btn-secondary"> Cancel</a>
                 </div>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection