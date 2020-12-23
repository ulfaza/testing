<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Karakteristik;
use App\Subkarakteristik;

class SubkarakteristikController extends Controller
{
    public function edit($sk_id)
    {
        $subkarakteristik = Subkarakteristik::findOrFail($sk_id);
        return view('/admin/edit_sub')->with('subkarakteristik', $subkarakteristik);
    }
   
    public function update(Request $request, $id){
        $subkarakteristik = Subkarakteristik::findorFail($id);
        $this->validate($request,[
            'bobot_relatif'      =>['required'],
        ]);
        $subkarakteristik->bobot_relatif       = $request->bobot_relatif;
            
  
        if ($subkarakteristik->save())
          return redirect()->route('tambahbobot');
    }

    public function customsub($k_id)
    {
        $data['no'] = 1;
        $data['karakteristiks'] = Karakteristik::where('k_id',$k_id)->get();
        $data['subkarakteristiks'] = SubKarakteristik::where('k_id',$k_id)->get();        
        return view('/custom_sub', $data);
    }

    public function editbobotsub($sk_id)
    {
        $subkarakteristiks = SubKarakteristik::where('sk_id',$sk_id)->get();
        return view('/edit_bobotsub', ['subkarakteristiks' => $subkarakteristiks]);
    }

    public function storebobotsub(Request $request, $sk_id)
    {
        DB::table('subkarakteristik')->where('sk_id',$sk_id)->update([
            'bobot_relatif' => $request->bobot_relatif,
        ]);    
        return view('/home');
    }
}
