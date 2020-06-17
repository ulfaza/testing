@include('layouts.includes.header')
@include('layouts.includes.leftmenu')

@section('content')

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
           <h3 class="animated fadeInLeft">Uji Aplikasi</h3>
           <p class="animated fadeInDown">
        </p>
      </div>
    </div>
  </div>

 <div class="col-md-12 top-20 padding-0">
    <div class="col-md-12">
      <div class="panel">
        <div class="panel-heading"><h3>Spesifikasi Aplikasi</h3></div>
          <div class="panel-body">
            <div class="responsive-table">
              <form form action="/storeaplikasi" method="post" class="form-horizontal">
              {{ csrf_field() }}
               <div class="panel-body" style="padding-bottom:30px;">
                <div class="col-md-12">

                  <div class="form-group"><label class="col-sm-2 control-label text-left">Nama Aplikasi</label>
                    <div class="col-sm-10"><input type="text" class="form-control"></div>
                  </div>
                </div>
               </div>
              </form>
          </div>
          <a href="" class="btn btn-success btn-md" style="float:right" >Submit</a>
        </div>
      </div>
    </div>
</div>