<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\SubKarakteristik;
use App\Karakteristik;
use App\Aplikasi;

class ResponseTimeController extends Controller
{
    public function responsetime(Request $request, $sk_id)
    {   
        $seconds = 5000;
        set_time_limit($seconds);
        $subkarakteristik = SubKarakteristik::findOrFail($sk_id);
        $url = $subkarakteristik->karakteristik->aplikasi->a_url;

        //array of cURL handles
        $arr = array();

        //create the array of cURL handles and add to a multi_curl
        $responsetime = curl_multi_init();
        // foreach ($urls as $req => $url) 
        for ($req=0;$req<7000;$req++){
            $arr[$req] = curl_init($url);
            curl_setopt($arr[$req], CURLOPT_RETURNTRANSFER, true);
            curl_setopt($arr[$req], CURLOPT_POST, true);
            // curl_setopt($chs[$key], CURLOPT_POSTFIELDS, $request_contents[$key]);

            curl_multi_add_handle($responsetime, $arr[$req]);
        }

        //running the requests
        $running = null;
        do{
            curl_multi_exec($responsetime, $running);
        }
        while ($running);
       
        //getting the responses
        foreach(array_keys($arr) as $req){
            $error = curl_error($arr[$req]);
            $last_effective_URL = curl_getinfo($arr[$req], CURLINFO_EFFECTIVE_URL);
            $time = curl_getinfo($arr[$req], CURLINFO_TOTAL_TIME);
            $response = curl_getinfo($arr[$req]);  // get results
            
            if (!empty($error)) {
            echo "The request $req return a error: $error" . "\n";
            }

            curl_multi_remove_handle($responsetime, $arr[$req]);
        }

        // close current handler
        curl_multi_close($responsetime);

        $hasil = $response['total_time'] / 7000;

            //$subkarakteristik->nilai_subfaktor = $hasil;
        if ($hasil <= 0.1) {
             $subkarakteristik->nilai_subfaktor = 100; 
        }

        else if ($hasil > 0.1 && $hasil <= 1) {
             $subkarakteristik->nilai_subfaktor = 67; 
        }

        else if ($hasil > 1 && $hasil <= 10) {
             $subkarakteristik->nilai_subfaktor = 33; 
        }

        else {
            $subkarakteristik->nilai_subfaktor = 33;
        }
        
        $subkarakteristik->bobot_absolut    = $subkarakteristik->karakteristik->k_bobot * $subkarakteristik->bobot_relatif;
        $subkarakteristik->nilai_absolut    = $subkarakteristik->bobot_absolut * $subkarakteristik->nilai_subfaktor;
        $subkarakteristik->save();
        
        //insert nilai karakteristik
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


        if ($subkarakteristik->save() && $karakteristik->save()) {
            return redirect()->route('nilai', $subkarakteristik->karakteristik->aplikasi->a_id)->with('success', 'Url berhasil direquest');
        }
        else {
            return redirect()->route('nilai', $subkarakteristik->karakteristik->aplikasi->a_id)->with('error', 'Url gagal direquest');
        }

    }
}
