@extends('layouts.app_topnav')

@section('content_header') 
  <div class="col-md-12">
      <div class="panel block">
          <div class="panel-body">
              <h1>Hasil Pengukuran Aplikasi</h1>
              <ol class="breadcrumb">
                  <li><a href="{{asset('/softwaretester/home')}}"></i> Home</a></li>
                  <li><a href="{{asset('/softwaretester/aplikasi')}}">Aplikasi</a></li>
                  <li class="active">Hasil Pengukuran</li>
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
                @include('admin.shared.components.alert')
                <button onclick="window.print()">Print this page</button>
                <div class="responsive-table">
                    <table id="datatables-example" class="table table-bordered">
                        <thead>
                            <th>ID</th>
                            <th>Karakteristik</th>
                            <th>Deskripsi</th>
                            <th>Nilai Karakteristik</th>
                        </thead>
                        <tbody>
                            @foreach($subkarakteristiks as $key => $s)
                                <tr>                                
                                    @if (@$subkarakteristiks[$key - 1]->k_nama != $s->k_nama)
                                        <td rowspan="{{ $rowspan[$s->k_nama] }}">{{ $no++ }}</td>
                                        <td rowspan="{{ $rowspan[$s->k_nama] }}">{{ $s->k_nama }}</td>
                                        <td rowspan="{{ $rowspan[$s->k_nama] }}">{{ 'isinya deskripsi masing-masing karakteristik, kalo di database udh ada ya tinggal manggil brrti kan k_deskripsi gitu isinya deskripsi masing-masing karakteristik, kalo di database udh ada ya tinggal manggil brrti kan k_deskripsi gitu isinya deskripsi masing-masing karakteristik, kalo di database udh ada ya tinggal manggil brrti kan k_deskripsi gitu' }}</td>
                                        <td rowspan="{{ $rowspan[$s->k_nama] }}">{{ $s->k_nilai }}</td>
                                    @endif                                
                                </tr>                                
                            @endforeach
                        </tbody>
                    </table>          
                </div>
            </div>
        </div>
      </div>
  </div>
@endsection