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
            <div class="panel-body">
              @include('admin.shared.components.alert')
              <div class="responsive-table">
                <table id="datatables-example" class="table table-striped table-bordered" width="100%" cellspacing="0">
                  <thead>
                    <th style="width: 5%">ID</th>
                    <th style="width: 25%">Nama Karakteristik</th>
                    <th style="width: 20%">Bobot Karakteristik</th>
                    <th style="width: 30%">Nama Subkarakteristik</th>
                    <th style="width: 20%">Bobot Subkarakteristik</th>
                  </thead>
                  <tbody>
                  @foreach($subkarakteristiks as $subs)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $subs->k_nama }}</td>
                    <td>{{ $subs->k_bobot }}</td>
                    <td>{{ $subs->sk_nama }}</td>
                    <td>{{ $subs->bobot_relatif }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

          </div>
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


