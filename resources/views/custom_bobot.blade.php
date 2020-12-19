<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Custom Bobot Karakteristik</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>            
    <script src="https://markcell.github.io/jquery-tabledit/assets/js/tabledit.min.js"></script>
  </head>
  <body>
    <div class="container">
      <br />
      <h3 align="center">Custom Bobot Karakteristik</h3>
      <br />
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3>
            @foreach($aplikasis as $a)
              {{ $a->a_nama }}
            @endforeach
          </h3>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table id="editable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nama Karakteristik</th>
                  <th>Bobot Karakteristik</th>
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
  </body>
</html>

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
      if(data.action == 'delete')
      {
        $('#'+data.k_id).remove();
      }
    }
  });

});  
</script>