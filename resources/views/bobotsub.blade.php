@extends('layouts.app_softwaretester')

@section('content_header')
<div class="row">
    <div class="col-md-12">
        <div class="panel block">
            <div class="panel-body">
                <h1>Bobot SubKarakteristik</h1>
                <ol class="breadcrumb">
                    <li><a href="{{asset('/softwaretester/home')}}"></i> Home</a></li>
                    <li><a href="{{asset('/softwaretester/bobot')}}"></i> Karakteristik</a></li>
                    <li class="active">Bobot SubKarakteristik</li>
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
              @include('admin.shared.components.alert')
              <table id="datatables-example" class="table table-striped table-bordered" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nama Sub Karakteristik</th>
                    <th>Bobot Sub Karakteristik</th>
                  </tr>
                </thead>
                <tbody>
              
                  @foreach($subkarakteristiks as $sk)
                  <tr>
                    <td>{{ $loop->iteration  }}</td>
                    <td>{{ $sk->sk_nama }}</td>
                    <td>{{ $sk->bobot_relatif }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
          </div>
        </div>
      </div>
    </div>
@endsection
    