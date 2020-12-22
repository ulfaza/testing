@include('layouts.includes.header')
@include('layouts.includes.leftmenu')

@section('content')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://markcell.github.io/jquery-tabledit/assets/js/tabledit.min.js"></script>

  <div id="content">
  <div class="row"> 
    <div class="col-md-12">
        <div class="panel block">
            <div class="panel-body">
                <h1>Custom Bobot</h1>
                <ol class="breadcrumb">
                    <li><a href="{{asset('/softwaretester/home')}}">Home</a></li>
                    <li><a href="{{asset('/softwaretester/aplikasi')}}">Aplikasi</a></li>
                    <li>Custom Bobot</li>
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
                @foreach($aplikasis as $a)
                  {{ $a->a_nama }}
                @endforeach
                </h3>
              </div>
                <div class="responsive-table">
                  <table id="editable" class="table table-bordered table-striped" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Nama Karakteristik</th>
                        <th>Bobot Karakteristik</th>
                        <!-- <th>action</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($karakteristiks as $k)
                      <tr>
                        <td>{{ $k->k_id }}</td>
                        <td>{{ $k->k_nama }}</td>
                        <td>{{ $k->k_bobot }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

<script type="text/javascript">
$(document).ready(function(){
  $('#editable').Tabledit({
    url:'{{ route("custombobot.action", $a->a_id) }}',
    dataType:"json",
    columns:{
      identifier:[0, 'k_id'],
      editable:[[2, 'k_bobot']]
    },
   
    restoreButton:false,
    onSuccess:function(data, textStatus, jqXHR)
    {
      if(data.action == 'deelte')
      {
        $('#'+data.k_id).remove();
      }
    }
  });

});  
</script>