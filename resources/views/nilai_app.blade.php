@include('layouts.includes.header')
@include('layouts.includes.leftmenu')
@section('tabeladmin')

<style>
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 80%;
  margin-left: 10%;
  margin-bottom: 105px;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #5DADE2;
  color: white;
}

</style>

<div id="content">
  <div class="panel box-shadow-none content-header">
     <div class="panel-body">
       <div class="col-md-12">
           <h3 class="animated fadeInLeft">Nilai Aplikasi</h3>
           <p class="animated fadeInDown">
            Home <span class="fa-angle-right fa"></span> Nilai Aplikasi
        </p>
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
                  <th>pk_id</th>
                  <th>a_id</th>
                  <th>k_id</th>
                  <th>pk_nilai</th>
                  <th>Aksi</th>
                </thead>
                <tbody>
                @foreach($pk as $pk)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $pk->pk_id }}</td>
                    <td>{{ $pk->a_id }}</td>
                    <td>{{ $pk->k_id }}</td>
                    <td>{{ $pk->pk_nilai }}</td>
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