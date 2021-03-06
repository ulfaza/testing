<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use App\Karakteristik;
use App\SubKarakteristik;
use App\Aplikasi;

class KuisionerController extends Controller
{
    public function kuis($sk_id)
    {
        $data['subkarakteristiks'] = SubKarakteristik::where('sk_id',$sk_id)->get();
        return view('/kuisioner',$data);
    }

    public function update(Request $request, $sk_id)
    {
        $subkarakteristik = SubKarakteristik::findorFail($sk_id);
            
        $this->validate($request,[
            'jml_res'       => 'required|integer',
            'total_per_sub' => 'required|integer',
        ]
        ,$messages = [
            'integer'   => 'Anda harus memasukkan angka',
        ]);
        if (($request->total_per_sub/$request->jml_res) <= 4) {
            $subkarakteristik->jml_res          = $request->jml_res;
            $subkarakteristik->total_per_sub    = $request->total_per_sub;
            $subkarakteristik->bobot_absolut    = $subkarakteristik->karakteristik->k_bobot * $subkarakteristik->bobot_relatif;
            $subkarakteristik->nilai_subfaktor  = $subkarakteristik->total_per_sub / $subkarakteristik->jml_res * 25;
            $subkarakteristik->nilai_absolut    = $subkarakteristik->bobot_absolut * $subkarakteristik->nilai_subfaktor;
            $subkarakteristik->save();
            // insert nilai karakteristik
            $karakteristik = Karakteristik::findOrFail($subkarakteristik->karakteristik->k_id);
            $total = DB::table('subkarakteristik')->where('k_id','=',$karakteristik->k_id)->sum('nilai_absolut');
            $temp_total = ($total/($karakteristik->k_bobot*100))*100;
            $karakteristik->k_nilai = $total;
            $karakteristik->k_final_nilai = $temp_total; 
            $karakteristik->save();

            //insert nilai aplikasi
            $aplikasis = Aplikasi::findOrFail($karakteristik->aplikasi->a_id);
            $total_app = DB::table('karakteristik')->where('a_id','=',$aplikasis->a_id)->sum('k_nilai');
            $aplikasis->a_nilai = $total_app;

            if ($aplikasis->save()) {
                return redirect()->route('nilai', $subkarakteristik->karakteristik->aplikasi->a_id)->with('success', 'item berhasil diubah');
            }
        }
        else{
            return redirect()->route('kuisioner', $sk_id)->with('error', 'Hasil dari "Nilai Total Hasil Kuesioner per Subkarakteristik" dibagi "Jumlah Responden" tidak boleh lebih dari 4');
        }
    }    
}
