@extends('layouts.app_topnav')

@section('content_header')
<div class="row">
    <div class="col-md-12">
        <div class="panel block">
            <div class="panel-body">
                <h1>Custom Karakteristik</h1>
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
            <span class="info-box-number">{{$total}}</span><br>
            <a class="btn btn-info btn-sm" id="belom"  >
              <span>belom</span>
            </a>
            <a href="{{route('custom.sub',$id_aplikasi)}}" id="next" class="btn btn-info btn-sm"  >
              <span>Next</span>
            </a>
          </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
function toggleNext(sum){
  if(sum == 1){
    $("#next").show();
    $("#belom").hide();
  }
  else{
    $("#next").hide();
    $("#belom").show();
  }
}

$(document).ready(function(){
  toggleNext(Number($('.info-box-number').html()));

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
      editable:[[2, 'k_bobot']]
    },
    deleteButton:false,
    restoreButton:false,
    onAlways:function(){
      var sum = 0;
       
      // we use jQuery each() to loop through all the textbox with 'bobot' class
      // and compute the sum for each loop
      $('input[name="k_bobot"]').each(function() {
          let val = Number($(this).val());
          if(!isNaN(val))
            sum += val;
          if(sum == 0.30000000000000004)
          sum = 0.3
      });
       
      // set the computed value to 'total_bobot' textbox
      $('.info-box-number').html(sum);

      toggleNext(sum);
    },
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
