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
    public function index()
    {
        $data['aplikasis'] = Aplikasi::all();
        return view('/admin/aplikasi',$data);
    }

    public function insert()
    {
        return view('/admin/tambah_aplikasi');
    }

    public function store(Request $request)
    {
      $aplikasi = new aplikasi;
      $aplikasi->a_id      = $request->a_id;
      $aplikasi->id        = Auth::user()->id;
      $aplikasi->a_nama    = $request->a_nama;  
      $aplikasi->a_total   = 0;

      if ($aplikasi->save()){
        return redirect('/admin/aplikasi');
      }
      else{
        return redirect('/admin/tambah_aplikasi');
      }
    }

    public function delete($a_id){
        $karakteristik = Karakteristik::findOrFail($a_id)->delete();
        return redirect()->route('index.aplikasi');
    }
}
