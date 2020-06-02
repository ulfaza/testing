@include('layouts.includes.admin_header')
@include('layouts.includes.admin_leftmenu')
@section('content')
<div class="col-md-2">
</div>
<div class="col-md-9" style="padding:100px; padding-top:5%">
	<h2 style="color: #6699cc">Tambah Admin</h2>
	<form action="/admin/storeadmin" method="post" class="form-horizontal">
		{{ csrf_field() }}
		<div class="form-group">
			<label class="control-label col-sm-2" style="text-align:left" for="name" required="required">Nama</label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="name">
			</div>
		</div>		
		<div class="form-group">
			<label class="control-label col-sm-2" style="text-align:left" for="email" required="required">Email</label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="email">
			</div>
		</div>		
		<div class="form-group">
			<label class="control-label col-sm-2" style="text-align:left" for="password" required="required">Password</label>
			<div class="col-sm-3">
				<input type="password" class="form-control" name="password">
			</div>
		</div>
		<button type="submit" class="btn btn-success">Tambah</button>
	</form>		
</div>