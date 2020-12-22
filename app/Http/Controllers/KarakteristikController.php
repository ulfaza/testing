<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Karakteristik;
use App\SubKarakteristik;
use App\Aplikasi;

class KarakteristikController extends Controller
{
    public function index()
    {
        $data['karakteristiks'] = Karakteristik::all();
        return view('/admin/karakteristik',$data);
    }
    public function insert()
    {
        return view('/admin/tambah_karakteristik');
    }

    public function custombobot($a_id)
    {
        $data['no'] = 1;
        $data['subkarakteristiks'] = DB::table('subkarakteristik')
        ->join('karakteristik', 'karakteristik.k_id', '=', 'subkarakteristik.k_id')
        ->join('aplikasi','aplikasi.a_id','=','karakteristik.a_id')
        ->where('aplikasi.a_id',1)->get();
        return view('/custom_bobot', $data);
    }



    public function store(Request $request)
    {

      $karakteristik = new karakteristik;
      $karakteristik->k_id      = $request->k_id;
      $karakteristik->a_id      = 1;
      $karakteristik->k_nama    = $request->k_nama;
      $karakteristik->k_bobot   = $request->k_bobot;
      $karakteristik->k_nilai   = 0;

      if ($karakteristik->save()){
        return redirect('/admin/karakteristik');
      }
      else{
        return redirect('/admin/tambah_karakteristik');
      }
    }

    public function delete($k_id){
        $karakteristik = Karakteristik::findOrFail($k_id)->delete();
        return redirect()->route('index.karakteristik');
    }

}
