<!DOCTYPE html>
<html lang="en">
<head>
	
	<meta charset="utf-8">
	<meta name="description" content="Miminium Admin Template v.1">
	<meta name="author" content="Isna Nur Azis">
	<meta name="keyword" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Miminium</title>

  <!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}"/>

  <!-- plugins -->
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/plugins/font-awesome.min.css')}}"/>
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/plugins/simple-line-icons.css')}}"/>
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/plugins/mediaelementplayer.css')}}"/>
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/plugins/animate.min.css')}}"/>
  <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/plugins/datatables.bootstrap.min.css')}}"/>
  <!-- end: Css -->

  <link rel="shortcut icon" href="{{asset('assets/img/logomi.png')}}">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
</head>

<body id="mimin" class="dashboard topnav">
      <!-- start: Header -->
        <nav class="navbar navbar-default header navbar-fixed-top">
          <div class="col-md-12 nav-wrapper">
            <div class="navbar-header" style="width:100%;">
                <a href="{{asset('indexs.html')}}" class="navbar-brand"> 
                 <b>MIMIN</b>
                </a>

              <ul class="nav navbar-nav navbar-right user-nav">
                <li class="user-name"><span>Akihiko Avaron</span></li>
                  <li class="dropdown avatar-dropdown">
                   <img src="asset/img/avatar.jpg" class="img-circle avatar" alt="user name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"/>
                   <ul class="dropdown-menu user-dropdown">
                     <li><a href="{{asset('#')}}"><sspan class="fa fa-user"></span> My Profile</a></li>
                     <li><a href="{{asset('#')}}"><sspan class="fa fa-calendar"></span> My Calendar</a></li>
                     <li role="separator" class="divider"></li>
                     <li class="more">
                      <ul>
                        <li><a href=""><spsan class="fa fa-cogs"></span></a></li>
                        <li><a href=""><spsan class="fa fa-lock"></span></a></li>
                        <li><a href=""><spsan class="fa fa-power-off "></span></a></li>
                      </ul>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      <!-- end: Header -->

      <!-- start: Content -->
        <div id="content">
          <div class="panel box-shadow-none content-header">
              <div class="panel-body">
                <div class="col-md-12">
                    <h3 class="animated fadeInLeft">TimeLine</h3>
                    <p class="animated fadeInDown">
                      Ui Element <span class="fa-angle-right fa"></span> TimeLine
                    </p>
                </div>
              </div>
          </div>
          <div class="col-md-12 top-20 padding-0">
            <div class="col-md-12">
            <div class="panel">
              	<div class="panel-heading"><h3>Default Timeline</h3></div>
              	<div class="panel-body">
              		@yield('content')

              </div>
            </div>
            </div>


          </div>
        </div>

<!-- start: Javascript -->
<script src="{{asset('asset/js/jquery.min.js')}}"></script>
<script src="{{asset('asset/js/jquery.ui.min.js')}}"></script>
<script src="{{asset('asset/js/bootstrap.min.js')}}"></script>

<!-- {{-- table edit --}} -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>            
<script src="https://markcell.github.io/jquery-tabledit/assets/js/tabledit.min.js"></script>

<!-- plugins -->
<script src="{{asset('asset/js/plugins/holder.min.js')}}"></script>
<script src="{{asset('asset/js/plugins/moment.min.js')}}"></script>
<script src="{{asset('asset/js/plugins/jquery.nicescroll.js')}}"></script>


<!-- custom -->
<script src="{{asset('asset/js/main.js')}}"></script>
<script type="text/javascript">
	@yield('js')
  $(document).ready(function(){

  });
</script>
<!-- end: Javascript -->
</body>
</html>