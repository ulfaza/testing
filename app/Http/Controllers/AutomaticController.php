<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\SubKarakteristik;

class AutomaticController extends Controller
{
    public function capacity(Request $request, $sk_id){
        $subkarakteristik = SubKarakteristik::findOrFail($sk_id);
        $url = $subkarakteristik->karakteristik->aplikasi->a_url;

        $test = public_path()."/python";
        system("cd $test && python ping.py");
    }
}