@include('layouts.includes.header')
@include('layouts.includes.leftmenu')

@section('content')

<div id="content">
  <div class="panel box-shadow-none content-header">
     <div class="panel-body">
       <div class="col-md-12">
           <h3 class="animated fadeInLeft">Uji Aplikasi</h3>
           <p class="animated fadeInDown">
        </p>
      </div>
    </div>
  </div>

 <div class="col-md-12 top-20 padding-0">
    <div class="col-md-12">
      <div class="panel">
        <div class="panel-heading"><h3>Daftar Aplikasi</h3></div>
          <div class="panel-body">
            <div class="responsive-table">
              <table id="datatables-example" class="table table-striped table-bordered" width="100%" cellspacing="0">
                <thead>
                  <th>ID</th>
                  <th>Nama User</th>
                  <th>Nama Aplikasi</th>

                  <th>Uji Aplikasi</th>
                  <th>Aksi</th>
                </thead>
                <tbody>
                @foreach($aplikasis as $aplikasi)
                <tr>
                  <td>{{ $aplikasi->a_id }}</td>
                  <td>{{ $aplikasi->user->name }}</td>
                  <td>{{ $aplikasi->a_nama }}</td>

                  <td>
                    <a href="{{route('insert.pk',$aplikasi->a_id)}}" class="btn btn-info btn-sm">
                      <span class="fa fa-pencil"></span>
                    </a>
                  </td>

                  <td>
                    <a href="{{route('edit.aplikasi',$aplikasi->a_id)}}" class="btn btn-info btn-sm">
                      <span class="fa fa-pencil"></span>
                    </a>
                    <a onclick="return confirm('Apakah anda yakin akan menghapus data ini ?')" href="{{route('delete.aplikasi',$aplikasi->a_id)}}" class="btn btn-danger btn-sm">
                      <span class="fa fa-trash"></span>
                    </a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <a href="{{asset('/insert/aplikasi')}}" class="btn btn-info btn-md">Tambah Aplikasi</a>
        </div>
      </div>
    </div>
</div>


