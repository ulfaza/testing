<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PSController extends Controller
{
    public function index($a_id)
    {
        return view('automatic');
    }

    public function loadtest()
    {
    	function curl($url) {
    		$ch = curl_init(); 
		    curl_setopt($ch, CURLOPT_URL, $url);
		    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer TRG11avzEbCu6tA-VJYVgbRx3UGk42nacpoPyajPGUrJjfjJMvhR4qxW-NkG-C1IPKd7h4I"));
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		    $output = curl_exec($ch); 
		    curl_close($ch);      
		    echo $output;
		}
		echo curl("https://api.pingdom.com/api/3.1/checks");
    }    
}

