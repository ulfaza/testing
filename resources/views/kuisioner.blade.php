@include('layouts.includes.header')
@include('layouts.includes.leftmenu')

@section('content')

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
        <div class="panel-heading"><h3>Daftar Aplikasi</h3></div>
          <div class="panel-body">

            <form action="#" method="post">
                {{ csrf_field() }}
                

                <div class="form-group">
                    <div class="form-group col-md-12">
                      <label>Nama Aplikasi</label>
                      <select class="form-control select2" name="a_id">
                        <option value="" disabled selected hidden>Pilih Aplikasi</option>
                        @foreach($aplikasis as $aplikasi)
                          <option value="{{ $aplikasi->a_id }}">{{ $aplikasi->a_nama }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Nama Karakteristik :</label>
                        <select class="form-control" name="k_id">
                        <option value="" disabled selected hidden>Pilih Karakteristik</option>
                        @foreach($karakteristiks as $karakteristik)
                            <option value="{{ $karakteristik->k_id }}">{{ $karakteristik->k_nama }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Nama SubKarakteristik :</label>
                        <select class="form-control" name="sk_id">
                        <option value="" disabled selected hidden>Pilih SubKarakteristik</option>
                        @foreach($subkarakteristiks as $subkarakteristik)
                            <option value="{{ $subkarakteristik->sk_id }}">{{ $subkarakteristik->sk_nama }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="font-weight-bold">Nilai Hasil Kuisioner</label>
                        <input type="text" class="form-control" name="hk_nilai" required>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary ">Submit</button>
                        <a onclick="return confirm('Perubahan anda belum disimpan. Tetap tinggalkan halaman ini ?')" href="{{('/home')}}" class="btn btn-secondary"> Cancel</a>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(".select2").select2({
      placeholder: "Select a state",
      allowClear: true
    });
});
</script>

