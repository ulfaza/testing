@include('layouts.includes.header')
@include('layouts.includes.leftmenu')

@section('content')

<div id="content">
  <div class="row">
    <div class="col-md-12">
        <div class="panel block">
            <div class="panel-body">
                <h1>Edit Bobot Karakteristik</h1>
                <ol class="breadcrumb">
                    <li><a href="{{asset('/softwaretester/home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Aplikasi</li>
                </ol>
            </div>
        </div>
    </div>
  </div>

  <div class="col-md-12 top-20 padding-0">
      <div class="col-md-12">
        <div class="panel">
          @foreach($karakteristiks as $k)
          <form action="{{route('store.kar',$k->k_id)}}" method="post" class="form-horizontal">
            {{ csrf_field() }}
              <div class="panel form-element-padding">
                    <div class="panel-heading">
                     <h4>Edit Bobot Karakteristik</h4>
                    </div>
                     <div class="panel-body" style="padding-bottom:30px;">
                      <div class="col-md-12">
                       
                        <div class="form-group"><label class="col-sm-2 control-label text-left">Nama Karakteristik</label>
                          <div class="col-sm-10"><input type="text" class="form-control" disabled value="{{ $k->k_nama }}"></div>
                        </div>

                        <div class="form-group"><label class="col-sm-2 control-label text-left">Bobot Karakteristik</label>
                          <div class="col-sm-10"><input type="text" name="k_bobot" class="form-control" value="{{ $k->k_bobot }}"></div>
                        </div>
                        <div class="col-md-6">
                            <input type="submit" class="btn btn-primary" value="Submit"/>
                        </div>
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>            
          </form>
          @endforeach
        </div>
      </div>
  </div>
</div>
@section('js')
<script>  
$(document).ready(function() {
  $(document).ready( function () {
    $('#mydatatables').DataTable();
  });
})
</script>
@endsection


