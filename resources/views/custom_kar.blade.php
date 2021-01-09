@extends('layouts.app_softwaretester')

@section('content_header')
<div class="row">
    <div class="col-md-12">
        <div class="panel block">
            <div class="panel-body">
                <h1>Daftar Aplikasi</h1>
                <ol class="breadcrumb">
                    <li><a href="{{asset('/softwaretester/home')}}"></i> Home</a></li>
                    <li class="active">Custom Karakteristik</li>
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
        <div class="table-responsive">
            {{ csrf_field() }}
            <table id="editable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nama Karakteristik</th>
                  <th>Bobot Karakteristik</th>
                </tr>
              </thead>
              <tbody>
                @foreach($karakteristiks as $row)
                <tr>
                  <td>{{ $row->k_id }}</td>
                  <td>{{ $row->k_nama }}</td>
                  <td>{{ $row->k_bobot }}</td>
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
<script type="text/javascript">
$(document).ready(function(){
   
  $.ajaxSetup({
    headers:{
      'X-CSRF-Token' : $("input[name=_token]").val()
    }
  });

  $('#editable').Tabledit({
    url:'{{ route("action.kar") }}',
    dataType:"json",
    columns:{
      identifier:[0, 'k_id'],
      editable:[[1, 'k_nama'], [2, 'k_bobot']]
    },
    restoreButton:false,
    onSuccess:function(data, textStatus, jqXHR)
    {
      if(data.action == 'delete')
      {
        $('#'+data.k_id).remove();
      }
    }
  });

});  
</script>
@endsection
