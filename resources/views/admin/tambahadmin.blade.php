@include('layouts.includes.admin_header')
@include('layouts.includes.admin_leftmenu')
@section('content')
<div class="col-md-2">
</div>
<div class="col-md-9" style="padding:100px; padding-top:5%">
	<h2 style="color: #6699cc" align="center">Tambah Admin</h2>

	<form form action="/admin/storeadmin" method="post" class="form-horizontal">
		{{ csrf_field() }}

		<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	        <label for="name" class="col-md-4 control-label">Nama</label>

	        <div class="col-md-6">
	            <input id="name" type="text" class="form-control" name="name" required autofocus>

	            @if ($errors->has('name'))
	                <span class="help-block">
	                    <strong>{{ $errors->first('name') }}</strong>
	                </span>
	            @endif
	        </div>
	    </div>		

		<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
	        <label for="email" class="col-md-4 control-label">Email</label>

	        <div class="col-md-6">
	            <input id="email" type="text" class="form-control" name="email" required autofocus>

	            @if ($errors->has('email'))
	                <span class="help-block">
	                    <strong>{{ $errors->first('email') }}</strong>
	                </span>
	            @endif
	        </div>
	    </div>	

		<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
	        <label for="password" class="col-md-4 control-label">Password</label>

	        <div class="col-md-6">
	            <input id="password" type="password" class="form-control" name="password" required autofocus>

	            @if ($errors->has('password'))
	                <span class="help-block">
	                    <strong>{{ $errors->first('password') }}</strong>
	                </span>
	            @endif
	        </div>
	    </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-success">
                    Tambah
                </button>
            </div>
        </div>

	</form>		
</div>