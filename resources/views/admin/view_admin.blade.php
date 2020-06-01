@include('layouts.includes.admin_header')
@include('layouts.includes.admin_leftmenu')
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
                        <h3 class="animated fadeInLeft">KELOLA ADMIN</h3>
                        <!--<p class="animated fadeInDown">
                          Form <span class="fa-angle-right fa"></span> Form Element
                        </p>-->
                    </div>
                  </div>
                </div>
        <table id="customers">
        <tr>
            <th>ID</th>
            <th>USERNAME</th>
            <th>ACTION</th>
        </tr>
        <tr>
            <td>1</td>
            <td>sultana</td>
            <td><button type="submit" style="margin:5px">edit</button><button>delete</button></td>
        </tr>
        <tr>
            <td>2</td>
            <td>itsna</td>
            <td><button type="submit" style="margin:5px">edit</button><button>delete</button></td>
        </tr>
        <tr>
            <td>3</td>
            <td>ulfa</td>
            <td><button type="submit" style="margin:5px">edit</button><button>delete</button></td>
        </tr>
        </table>
        <button type="submit" style="margin-left: 880px" class="btn btn-success" href="/admin/tambahadmin">Tambah Admin</button>
</div>



