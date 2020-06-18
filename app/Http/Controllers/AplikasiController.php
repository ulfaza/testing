<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Aplikasi;

class AplikasiController extends Controller
{
    public function insert()
    {
        return view('/aplikasi');
    }

    public function store(Request $request)
    {
      $aplikasi = new aplikasi;
      $aplikasi->a_id      = $request->a_id;
      $aplikasi->id        = Auth::user()->id;
      $aplikasi->a_nama    = $request->a_nama;  
      $aplikasi->a_total   = 0;

      if ($aplikasi->save()){
        return redirect('/home');
      }
      else{
        return redirect('/aplikasi');
      }
    }
}
