@extends('layouts.app_softwaretester')

@section('content_header')
<div class="row">
    <div class="col-md-12">
        <div class="panel block">
            <div class="panel-body">
                <h1>Custom Subkarakteristik</h1>
                <ol class="breadcrumb">
                    <li><a href="{{asset('/softwaretester/home')}}"></i> Home</a></li>
                    <li class="active">Custom Subkarakteristik</li>
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
                  <th>Nama Subkarakteristik</th>
                  <th>Bobot Subarakteristik</th>
                </tr>
              </thead>
              <tbody>
                @foreach($subkarakteristiks as $row)
                <tr>
                  <td>{{ $row->sk_id }}</td>
                  <td>{{ $row->k_nama }}</td>
                  <td>{{ $row->sk_nama }}</td>
                  <td>{{ $row->bobot_relatif }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            <span class="info-box-number">{{$total}}</span><br>
            @foreach ($aplikasis as $app)
                @if ($total != 1)
                  <a class="btn btn-info btn-sm">
                    <span>belom</span>
                  </a>
                @else
                  <a href="{{route('custom.kar',$app->a_id)}}" class="btn btn-info btn-sm">
                    <span>Next</span>
                  </a> 
                @endif
                   
              @endforeach
                
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
    url:'{{ route("action.sub") }}',
    dataType:"json",
    columns:{
      identifier:[0, 'sk_id'],
      editable:[[3, 'bobot_relatif']]
    },
    deleteButton:false,
    restoreButton:false,
    onAlways:function(){
      var sum = 0;
       
      // we use jQuery each() to loop through all the textbox with 'bobot' class
      // and compute the sum for each loop
      $('input[name="bobot_relatif"]').each(function() {
          let val = Number($(this).val());
          if(!isNaN(val))
            sum += val;
          if(sum == 0.30000000000000004)
          sum = 0.3
      });
       
      // set the computed value to 'total_bobot' textbox
      $('.info-box-number').html(sum);
    },
    onSuccess:function(data, textStatus, jqXHR)
    {
      if(data.action == 'delete')
      {
        $('#'+data.sk_id).remove();
      }
    }
  });

});  
</script>
@endsection
