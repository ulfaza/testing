<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Kuisioner;
use App\Aplikasi;
use App\Karakteristik;
use App\Subkarakteristik;

class KuisionerController extends Controller
{
    public function kuis($a_id)
    {
        $data['aplikasis'] = Aplikasi::all();
        $data['karakteristiks'] = Karakteristik::all();
        $data['subkarakteristiks'] = Subkarakteristik::all();
        return view('/kuisioner',$data);
    }
}
