<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Karakteristik;
use App\SubKarakteristik;
use App\Aplikasi;

class AutomaticController extends Controller
{
    public function capacity(Request $request, $sk_id){
        $subkarakteristik = SubKarakteristik::findOrFail($sk_id);
        $url = $subkarakteristik->karakteristik->aplikasi->a_url;

        $test = public_path()."/python";
        system("cd $test && python ping.py");
    }
}