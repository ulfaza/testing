<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Aplikasi;
use App\Karakteristik;
use App\Subkarakteristik;
use App\PenilaianKarakteristik;
use App\PenilaianSubKarakteristik;

class AplikasiController extends Controller
{
    public function index()
    {
        $data['aplikasis'] = Aplikasi::where('id',Auth::user()->id)->get();
        return view('/aplikasi',$data);
    }
    public function nilai($a_id)
    {
        $data['no'] = 1;
        $data['aplikasis'] = Aplikasi::where('a_id',$a_id)->get();
        $data['subkarakteristiks'] = SubKarakteristik::all();
        return view('/nilai_app', $data);
    }

    public function custombobot($a_id)
    {
        $data['aplikasis'] = Aplikasi::where('a_id',$a_id)->get();
        $data['karakteristiks'] = Karakteristik::all();        
        return view('/custom_bobot', $data);
    }

    public function action(Request $request, $a_id)
    {
        if($request->ajax())
        {
            if($request->action == 'edit')
            {
                $data = array(
                    'k_nama'    =>  $request->k_nama,
                    'k_bobot'     =>  $request->k_bobot
                );
                DB::table('karakteristik')
                    ->where('k_id', $request->k_id)
                    ->update($data)
                    ->save();
            }
            if($request->action == 'delete')
            {
                DB::table('karakteristik')
                    ->where('k_id', $request->k_id)
                    ->delete()
                    ->save();
            }
            return response()->json($request);
        }
    }

    public function insert()
    {
        return view('/tambah_aplikasi');
    }

    public function edit($a_id)
    {
        $aplikasi = Aplikasi::findOrFail($a_id);
        return view('/edit_aplikasi')->with('aplikasi', $aplikasi);
    }

    public function update(Request $request, $a_id){
        $aplikasi = Aplikasi::findorFail($a_id);
        $this->validate($request,[
            'a_nama'      =>['required'],
        ]);
        $aplikasi->a_nama       = $request->a_nama;
            
  
        if ($aplikasi->save())
          return redirect()->route('index.aplikasi');
    }

    public function store(Request $request)
    {
        $aplikasi = new aplikasi;

        $aplikasi->id        = Auth::user()->id;
        $aplikasi->a_nama    = $request->a_nama;
        $aplikasi->a_url     = $request->a_url;
        $aplikasi->a_nilai   = 0;
        $aplikasi->save();

        return redirect('/softwaretester/aplikasi')->with('success', 'item berhasil ditambahkan');
    }

    public function delete($a_id){
        $aplikasi = Aplikasi::findOrFail($a_id)->delete();
        return redirect()->route('index.aplikasi');
    }
}
