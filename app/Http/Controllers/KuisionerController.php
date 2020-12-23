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
    public function kuis($sk_id)
    {
        $data['subkarakteristiks'] = Subkarakteristik::where('sk_id',$sk_id)->get();
        return view('/kuisioner',$data);
    }
}
