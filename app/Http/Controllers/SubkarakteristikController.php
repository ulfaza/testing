<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Aplikasi;
use App\Karakteristik;
use App\SubKarakteristik;

class SubkarakteristikController extends Controller
{
    public function edit($sk_id)
    {
        $subkarakteristik = SubKarakteristik::findOrFail($sk_id);
        return view('/admin/edit_sub')->with('subkarakteristik', $subkarakteristik);
    }
   
    public function update(Request $request, $id){
        $subkarakteristik = SubKarakteristik::findorFail($id);
        $this->validate($request,[
            'bobot_relatif'      =>['required'],
        ]);
        $subkarakteristik->bobot_relatif       = $request->bobot_relatif;
            
  
        if ($subkarakteristik->save())
          return redirect()->route('tambahbobot');
    }

    public function bobotsub(Request $request, $k_id)
    {
        $data['karakteristiks'] = Karakteristik::where('k_id',$k_id)->get();
        $data['subkarakteristiks'] = SubKarakteristik::where('k_id',$k_id)->get();
        return view('/bobotsub', $data);
    }
    
    public function customsub($a_id)
    {
        $data['no'] = 1;
        $data['aplikasis'] = Aplikasi::where('a_id',$a_id)->get();
        $data['subkarakteristiks'] = DB::table('subkarakteristik')
                                    ->join('karakteristik', 'karakteristik.k_id', '=', 'subkarakteristik.k_id')
                                    ->join('aplikasi','aplikasi.a_id','=','karakteristik.a_id')
                                    ->where('aplikasi.a_id',$a_id)->get();
        $data['total'] = DB::table('subkarakteristik')
                                    ->join('karakteristik', 'karakteristik.k_id', '=', 'subkarakteristik.k_id')
                                    ->join('aplikasi','aplikasi.a_id','=','karakteristik.a_id')
                                    ->where('aplikasi.a_id',$a_id)->sum('bobot_relatif');
        return view('/custom_sub', $data);
    }

    function actionsub(Request $request)
    {
        if($request->ajax())
        {
            if($request->action == 'edit')
            {
                $data = array(
                    'bobot_relatif'       =>  $request->bobot_relatif
                );
                DB::table('subkarakteristik')
                    ->where('sk_id', $request->sk_id)
                    ->update($data);
            }
            if($request->action == 'delete')
            {
                DB::table('subkarakteristik')
                    ->where('sk_id', $request->sk_id)
                    ->delete();
            }
            return response()->json($request);
        }
    }

    public function editbobotsub($sk_id)
    {
        $subkarakteristiks = SubKarakteristik::where('sk_id',$sk_id)->get();
        return view('/edit_bobotsub', ['subkarakteristiks' => $subkarakteristiks]);
    }

    public function storebobotsub(Request $request, $sk_id)
    {
        $subkarakteristik = SubKarakteristik::findorFail($sk_id);

        $subkarakteristik->bobot_relatif      = $request->bobot_relatif;
        if ($subkarakteristik->save()) {
          return redirect()->route('custom.sub', $subkarakteristik->karakteristik->k_id)->with('success', 'item berhasil diubah');
        }    
    }
}
