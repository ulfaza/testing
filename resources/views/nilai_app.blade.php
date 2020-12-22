@include('layouts.includes.header')
@include('layouts.includes.leftmenu')

@section('content')

  <div id="content">
  <div class="row">
    <div class="col-md-12">
        <div class="panel block">
            <div class="panel-body">
                <h1>Pengukuran Aplikasi</h1>
                <ol class="breadcrumb">
                    <li><a href="{{asset('/softwaretester/home')}}">Home</a></li>
                    <li><a href="{{asset('/softwaretester/aplikasi')}}">Aplikasi</a></li>
                    <li class="active">Pengukuran Aplikasi</li>
                </ol>
            </div>
        </div>
    </div>
  </div>
 <div class="col-md-12 top-20 padding-0">
    <div class="col-md-12">
      <div class="panel">
        <div class="panel-heading">
            <h3>
                @foreach ($aplikasis as $aplikasi)
                {{ $aplikasi->a_nama }}
                @endforeach
            </h3>
        </div>
          <div class="panel-body">
            @include('admin.shared.components.alert')
            <div class="responsive-table">
              <table id="datatables-example" class="table table-striped table-bordered" width="100%" cellspacing="0">
                <thead>
                  <th>ID</th>
                  <th>Karakteristik</th>
                  <th>Bobot Karakteristik</th>
                  <th>Sub Karakteristik</th>
                  <th>Bobot Relatif</th>
                  <th>Aksi</th>
                </thead>
                <tbody>
                @foreach($subkarakteristiks as $s)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $s->karakteristik->k_nama }}</td>
                    <td>{{ $s->karakteristik->k_bobot }}</td>
                    <td>{{ $s->sk_nama }}</td>
                    <td>{{ $s->bobot_relatif }}</td>
                    <td>
                        <a href="{{route('kuisioner',$aplikasi->a_id)}}" class="btn btn-info btn-sm">
                        <span class="fa fa-pencil"></span>
                        </a>
                        <a onclick="return confirm('Apakah anda yakin akan menghapus data ini ?')" href="#" class="btn btn-danger btn-sm">
                        <span class="fa fa-trash"></span>
                        </a>
                    </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</div>
