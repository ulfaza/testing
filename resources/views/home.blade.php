@extends('layouts.app_softwaretester')

@section('content_header')
<div class="row">
    <div class="col-md-12">
        <div class="panel block">
            <div class="panel-body">
                <h3> Halo, {{ Auth::user()->name }}</h3>
                <h4>Selamat Datang di Aplikasi Pengukuran Kualitas Perangkat Lunak </h4>
                </br>
                <p>Sebelum menggunakan aplikasi ini, pastikan untuk membaca petunjuk langkah-langkah penggunaan aplikasi di bawah ini.</p>
                <p>Selamat Mencoba</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="col-md-12">
    <div class="col-md-5">
        <div class="panel bg-light-blue">
            <div class="panel-body text-white">
                <div class="col-md-12 padding-0">
                    <div class="text-left col-md-7 col-xs-12 col-sm-7 padding-0">
                        <h5>1</h5>
                    </div>
                </div>
                <div class="panel-body text-white">
                    <h4>Masukkan Data Aplikasi</h4>
                    <p>Langkah pertama yang harus dilakukan adalah memasukkan data aplikasi yang akan diukur. 
                    Data yang harus diisikan yaitu<br> 
                    1). Nama Aplikasi<br> 
                    2). URL Aplikasi<br> 
                    3). File berekstensi .php</p>
                    <p>Pilih menu <b>Aplikasi</b> lalu pilih menu <b>Tambah Aplikasi</b></p>
                    <p>Masukkan <b>Nama Aplikasi, URL, dan File berekstensi .php </b></p> 
                </div>
            </div>
        </div> 
    </div>
    <div class="col-md-5">
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
</div>
@endsection
