@include('layouts.includes.header')
@include('layouts.includes.leftmenu')
@section('content')

    <div id="content">
        <!-- <div class="row"> -->
            <div class="col-md-12">
                <div class="panel box-v4">
                    <div class="panel-heading bg-white border-none">
                        <h3> Halo, {{ Auth::user()->name }}</h3>
                        <h4>Selamat Datang di Aplikasi Pengukuran Kualitas Perangkat Lunak </h4>
                        </br>
                        <p>Sebelum menggunakan aplikasi ini, pastikan untuk membaca petunjuk langkah-langkah penggunaan aplikasi di bawah ini.</p>
                        <p>Selamat Mencoba</p>
                    </div>
                </div>
            </div>
    
            <div class="col-md-12 padding-0">
                <div class="col-md-4">
                    <div class="panel bg-light-blue">
                        <div class="panel-body text-white">
                            <div class="col-md-12 padding-0">
                                <div class="text-left col-md-7 col-xs-12 col-sm-7 padding-0">
                                    <h5>1</h5>
                                </div>
                            </div>
                            <div class="panel-body text-white">
                                <h4>Masukkan Data Aplikasi</h4>
                                <p>[ Langkah pertama yang harus dilakukan adalah memasukkan data aplikasi yang akan diukur. 
                                Data yang harus diisikan yaitu 1) Nama Aplikasi, 2) URL Aplikasi, 3) File berekstensi .php]</p>
                                <p>Pilih menu <b>Aplikasi</b> lalu pilih menu <b>Tambah Aplikasi</b></p>
                                <p>Masukkan <b>Nama Aplikasi, URL, dan File berekstensi .php </b></p> 
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="col-md-4">
                    <div class="panel bg-light-blue">
                        <div class="panel-body text-white">
                            <div class="col-md-12 padding-0">
                                <div class="text-left col-md-7 col-xs-12 col-sm-7 padding-0">
                                    <h5>2</h5>
                                </div>
                            </div>
                            <div class="panel-body text-white">
                                <h4>Lakukan Pengukuran Aplikasi</h4>
                                <p>[ Langkah kedua yaitu pengukuran aplikasi. Terdapat dua pilihan pengukuran yaitu 1) Default menggunakan bobot dari aplikasi, 
                                atau 2) Custom menggunakan bobot yang anda tentukan sendiri ]</p>
                                <p>Pilih menu <b>Pilih menu <b>Pengukuran</b> lalu pilih menu <b>Default</b>atau<b>Custom</b></p>
                                <p>Masukkan <b>Nama Aplikasi, URL, dan File berekstensi .php </b></p> 
                            </div>
                        </div>
                    </div> 
                </div>
           
        <!-- <div class="col-md-12" style="padding:20px;">
            <div class="col-md-12 padding-0">
                <div class="col-md-4">
                    <a href="{{asset('/softwaretester/aplikasi')}}">
                        <div class="panel box-v1">
                            <div class="panel-body text-center">
                            <h3>Aplikasi</h3>
                            <hr/>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{asset('/softwaretester/bobot')}}">
                        <div class="panel box-v1">
                            <div class="panel-body text-center">
                            <h3>Bobot Karakteristik</h3>
                            <hr/>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{asset('/softwaretester/bobot')}}">
                        <div class="panel box-v1">
                            <div class="panel-body text-center">
                            <h3>Bobot Karakteristik</h3>
                            <hr/>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{asset('/softwaretester/bobot')}}">
                        <div class="panel box-v1">
                            <div class="panel-body text-center">
                            <h3>Bobot Karakteristik</h3>
                            <hr/>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{asset('/softwaretester/bobot')}}">
                        <div class="panel box-v1">
                            <div class="panel-body text-center">
                            <h3>Bobot Karakteristik</h3>
                            <hr/>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{asset('/softwaretester/bobot')}}">
                        <div class="panel box-v1">
                            <div class="panel-body text-center">
                            <h5>Bobot KarakteristikKarakteristikKarakteristikKarakteristikKarakteristikKarakteristikKarakteristikKarakteristik</h5>
                            <hr/>
                            </div>
                        </div>
                    </a>
                </div> -->
            </div>
        </div>
    </div>


