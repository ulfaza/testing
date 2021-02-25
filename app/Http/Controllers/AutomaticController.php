<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\SubKarakteristik;
use App\Karakteristik;
use App\Aplikasi;

class AutomaticController extends Controller
{
    public function addcapacity($sk_id)
    {
        $subkarakteristik = SubKarakteristik::findOrFail($sk_id);
        return view('/addcapacity')->with('subkarakteristik', $subkarakteristik);
    }

    public function capacity(Request $request, $sk_id)
    {   
        $seconds = 5000;
        set_time_limit($seconds);
        $subkarakteristik = SubKarakteristik::findOrFail($sk_id);
        $url = $subkarakteristik->karakteristik->aplikasi->a_url;

        //array of cURL handles
        $chs = array();
        $temp = 0;
        $n = $request->jml_req;

      //create the array of cURL handles and add to a multi_curl
        $mh = curl_multi_init();
        for ($key=0;$key<$n;$key++){
            $chs[$key] = curl_init($url);
            curl_setopt($chs[$key], CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chs[$key], CURLOPT_POST, true);

            curl_multi_add_handle($mh, $chs[$key]);
        }

        //running the requests
        $running = null;
        do {
        curl_multi_exec($mh, $running);
        } while ($running);

        //getting the responses
        foreach(array_keys($chs) as $key){
            $error = curl_error($chs[$key]);
            $last_effective_URL = curl_getinfo($chs[$key], CURLINFO_EFFECTIVE_URL);
            $time = curl_getinfo($chs[$key], CURLINFO_TOTAL_TIME);
            $response = curl_multi_getcontent($chs[$key]);  // get results
            if (!empty($error)) {
                $temp += 0;
            }
            else {
                $temp += 1;
            }

            curl_multi_remove_handle($mh, $chs[$key]);
        }
        
        // close current handler
        curl_multi_close($mh);
        $x = $n/100;
        $hasil = $temp/$x;
        $subkarakteristik->nilai_subfaktor = $hasil;
        $subkarakteristik->bobot_absolut 	= $subkarakteristik->karakteristik->k_bobot * $subkarakteristik->bobot_relatif;
        $subkarakteristik->nilai_absolut 	= $subkarakteristik->bobot_absolut * $subkarakteristik->nilai_subfaktor;
        $subkarakteristik->save();

        // insert nilai karakteristik
        $karakteristik = Karakteristik::findOrFail($subkarakteristik->karakteristik->k_id);
        $total = DB::table('subkarakteristik')->where('k_id','=', $karakteristik->k_id)->sum('nilai_absolut');
        $temp_total = ($total/($karakteristik->k_bobot*100))*100;
        $karakteristik->k_nilai = $total;
        $karakteristik->k_final_nilai = $temp_total;
        $karakteristik->save();

        //insert nilai aplikasi
        $aplikasi = Aplikasi::findOrFail($karakteristik->aplikasi->a_id);
        $totalapp = DB::table('karakteristik')->where('a_id', '=', $aplikasi->a_id)->sum('k_nilai');
        $aplikasi->a_nilai = $totalapp;


        if ($aplikasi->save()) {
        	return redirect()->route('nilai', $subkarakteristik->karakteristik->aplikasi->a_id)->with('success', 'Url berhasil direquest');
        }
        else {
            return redirect()->route('nilai', $subkarakteristik->karakteristik->aplikasi->a_id)->with('error', 'Url gagal direquest');
        }

    }

}