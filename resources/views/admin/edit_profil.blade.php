@include('layouts.includes.admin_header')
@include('layouts.includes.admin_leftmenu')
@section('content')
<div class="col-md-2">
</div>
<div class="col-md-9" style="padding:100px; padding-top:5%">
	<h2 style="color: #6699cc">Edit Profil</h2>
	<form form action="/admin/profil" method="post" class="form-horizontal">
		{{ csrf_field() }}
		<input type="hidden" name="username" value=""> <br/>		
		<div class="form-group">
			<label class="control-label col-sm-2" style="text-align:left" for="nama">Nama</label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="nama">
			</div>
		</div>	
		<div class="form-group">
			<label class="control-label col-sm-2" style="text-align:left" for="role">Role</label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="role">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" style="text-align:left" for="instansi">Nama Instansi</label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="instansi">
			</div>
		</div>		
		<div class="form-group">
			<label class="control-label col-sm-2" style="text-align:left" for="pwd">Password Lama</label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="pwd">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" style="text-align:left" for="new_pwd">Password Baru</label>
			<div class="col-sm-3">
				<input type="text" class="form-control" name="new_pwd">
			</div>
		</div>		
		<button type="submit" class="btn btn-danger">Simpan</button>
	</form>		
</div>