@extends('layouts.app_softwaretester')

@section('content_header')
  <div class="col-md-12">
      <div class="panel block">
          <div class="panel-body">
              <h1>Pengukuran Aplikasi</h1>
              <ol class="breadcrumb">
                <li><a href="{{asset('/softwaretester/home')}}">Home</a></li>
                <li><a href="{{asset('/softwaretester/aplikasi')}}">Aplikasi</a></li>
                <li class="active">Pengukuran Aplikasi</li>
          </div>
      </div>
  </div>
@endsection

@section('content')
  <div class="col-md-12 padding-0">
    <div class="col-md-12">
      <div class="panel">
        <div class="panel-heading" style="background:#2196F3">
            <h3 style="color: white">
                @foreach ($aplikasis as $aplikasi)
                {{ $aplikasi->a_nama }}
                @endforeach
            </h3>
        </div>
          <div class="panel-body">
            @include('admin.shared.components.alert') 
            <div class="responsive-table">
              <table id="datatables-example" class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                  <th style="width: 5%">ID</th>
                  <th style="width: 15%">Karakteristik</th>
                  <th style="width: 10%">Bobot Karakteristik</th>
                  <th style="width: 15%">Sub Karakteristik</th>
                  <th style="width: 10%">Bobot Relatif</th>
                  <th style="width: 10%">Bobot Absolut</th>
                  <th style="width: 10%">Nilai Subkarakteristik</th>
                  <th style="width: 10%">Nilai Absolut</th>
                  <th style="width: 10%">Nilai Karakteristik</th>
                  <th style="width: 15%">Tambah Hasil Kuesioner</th>
                </thead>
                <tbody>
                @foreach($subkarakteristiks as $key => $s)
                <tr>
                    
                    @if (@$subkarakteristiks[$key - 1]->k_nama != $s->k_nama)
                      <td rowspan="{{ $rowspan[$s->k_nama] }}">{{ $no++ }}</td>
                      <td rowspan="{{ $rowspan[$s->k_nama] }}">{{ $s->k_nama }}</td>
                      <td rowspan="{{ $rowspan[$s->k_nama] }}">{{ $s->k_bobot }}</td>
                    @endif
                    <td>{{ $s->sk_nama }}</td>
                    <td>{{ $s->bobot_relatif }}</td>
                    <td>{{ $s->bobot_absolut }}</td>
                    <td>{{ $s->nilai_subfaktor }}</td>
                    <td>{{ $s->nilai_absolut }}</td>
                    @if (@$subkarakteristiks[$key - 1]->k_nama != $s->k_nama)
                    <td rowspan="{{ $rowspan[$s->k_nama] }}">{{ $s->k_final_nilai }}</td>
                    @endif

                    @if ($s->nilai_absolut == null)
                      @if ($s->sk_nama == 'Modularity')
                        <td>
                          <a href="{{route('cohesion',$s->sk_id)}}" class="btn btn-success btn-sm loading">
                            <span class="fa fa-plus"></span>
                          </a>
                        </td>
                      @elseif ($s->sk_nama == 'Time Behaviour')
                        <td>
                          <a href="{{route('responsetime',$s->sk_id)}}" class="btn btn-success btn-sm loading">
                            <span class="fa fa-plus"></span>
                          </a>
                        </td>
                      @elseif ($s->sk_nama == 'Capacity')
                        <td>
                          <a href="{{route('addcapacity',$s->sk_id)}}" class="btn btn-success btn-sm">
                            <span class="fa fa-plus"></span>
                          </a>
                        </td>
                      @else
                        <td>
                          <a href="{{route('kuisioner',$s->sk_id)}}" class="btn btn-info btn-sm">
                            <span class="fa fa-plus"></span>
                          </a>
                        </td>
                      @endif
                    @else

                        @if ($s->sk_nama == 'Modularity')
                          <td>
                            <a href="{{route('cohesion',$s->sk_id)}}" class="btn btn-warning btn-sm loading">
                              <span class="fa fa-pencil"></span>
                            </a>
                          </td>
                        @elseif ($s->sk_nama == 'Time Behaviour')
                          <td>
                            <a href="{{route('responsetime',$s->sk_id)}}" class="btn btn-warning btn-sm loading">
                              <span class="fa fa-pencil"></span>
                            </a>
                          </td>
                        @elseif ($s->sk_nama == 'Capacity')
                          <td>
                            <a href="{{route('addcapacity',$s->sk_id)}}" class="btn btn-warning btn-sm">
                              <span class="fa fa-pencil"></span>
                            </a>
                          </td>
                        @else
                          <td>
                            <a href="{{route('kuisioner',$s->sk_id)}}" class="btn btn-warning btn-sm">
                              <span class="fa fa-pencil"></span>
                            </a>
                          </td>
                        @endif

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
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
  $('.loading').on('click',function(){
    var $btn = $(this);
      $btn.button('loading');
      setTimeout(function(){
        $btn.button('reset');
    },1000000);
  });
});
</script>
@endsection
