@include('layouts.includes.header')
@include('layouts.includes.leftmenu')
@section('content')

    <div id="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel block">
                    <div class="panel-body">
                        <h3 class="animated fadeInLeft">Welcome {{ Auth::user()->name }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12" style="padding:20px;">
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
                </div>
            </div>
        </div>
    </div>


