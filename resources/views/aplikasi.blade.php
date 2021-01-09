@extends('layouts.app_softwaretester')

@section('content_header')
<div class="row">
    <div class="col-md-12">
        <div class="panel block">
            <div class="panel-body">
                <h1>Daftar Aplikasi</h1>
                <ol class="breadcrumb">
                    <li><a href="{{asset('/softwaretester/home')}}"></i> Home</a></li>
                    <li class="active">Aplikasi</li>
                </ol>
            </div>
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
              <a href="{{asset('softwaretester/insert_aplikasi')}}" class="btn btn-info btn-md">Tambah Aplikasi</a>
              <hr>
              <div class="responsive-table">
                <table id="mydatatables" class="table table-striped table-bordered" width="100%" cellspacing="0">
                  <thead>
                    <th style="width: 5%">ID</th>
                    <th style="width: 25%">Nama User</th>
                    <th style="width: 25%">Nama Aplikasi</th>
                    <th style="width: 15%">Ukur Aplikasi</th>
                    <th style="width: 15%">Lihat Hasil Ukur</th>
                    <th style="width: 15%">Aksi</th>
                  </thead>
                  <tbody>
                  @foreach($aplikasis as $aplikasi)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $aplikasi->user->name }}</td>
                    <td>{{ $aplikasi->a_nama }}</td>

                    <td>
                      <a href="{{route('nilai',$aplikasi->a_id)}}" class="btn btn-info btn-sm">
                        <span class="fa fa-pencil"></span>
                      </a>
                    </td>

                    <td>
                      <a href="" class="btn btn-info btn-sm">
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

            <div class="col-md-12">
                <div class="modal fade modal-v1" id="modal_custom">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h2 class="modal-title">
                          <h3>Custom Bobot</h3>
                        </h2>
                      </div>
                      <div class="modal-body">
                        <h3>Apakah Anda ingin melakukan custom bobot atau menggunakan bobot default?</h3>
                        <p>Bobot karakteristik dan subkarakteristik default didapatkan dari kuesioner pakar dan dihitung menggunakan metode AHP. Jika Anda ingin melakukan custom bobot, maka Anda harus menghitung bobot karakteristik dan subkarakteristik. </p>
                        <a href="{{route('nilai',$aplikasi->a_id)}}" class="btn btn-primary btn-3d btn-login">
                          Gunakan Bobot Default                          
                        </a> 
                        <a href="{{route('custom.kar',$aplikasi->a_id)}}" class="btn btn-default btn-login">
                          Custom Bobot?                         
                        </a> 
<!--                        <button href="{{route('edit.kar',$aplikasi->a_id)}}" class="btn btn-default btn-login">
                          Custom Bobot?
                         </button> -->
                      </div>
                      <div class="modal-footer">
                      </div>
                    </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            </div>

          </div>
        </div>
      </div>
  </div>
@endsection


