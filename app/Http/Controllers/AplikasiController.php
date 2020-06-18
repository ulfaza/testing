<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;

class AplikasiController extends Controller
{
    public function insert()
    {
        return view('/aplikasi');
    }

    public function store(Request $request)
    {
      $this->validate($request,[
        'a_id'      =>['required','unique:aplikasi'],
        'a_nama'    =>['required', 'string'],   

      ]);

      $aplikasi = new aplikasi;
      $aplikasi->a_id      = $request->a_id;
      $aplikasi->a_nama    = $request->a_nama;     

      if ($karakteristik->save()){
        return redirect('/home');
      }
      else{
        return redirect('/aplikasi');
      }
    }
}
