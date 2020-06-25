<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

class PSController extends Controller
{
    public function index($a_id)
    {
        return view('automatic');
    }

    public function loadtest()
    {
	    // Init cURL
	    $curl = curl_init();
	    // Set target URL
	    curl_setopt($curl, CURLOPT_URL, "https://api.pingdom.com/api/3.1/checks");
	    // Set the desired HTTP method (GET is default, see the documentation for each request)
	    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
	    // Add header with Bearer Authorization
	    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer TRG11avzEbCu6tA-VJYVgbRx3UGk42nacpoPyajPGUrJjfjJMvhR4qxW-NkG-C1IPKd7h4I"));
	    // Ask cURL to return the result as a string
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    // Execute the request and decode the json result into an associative array
	    $response = json_decode(curl_exec($curl), true);
	    // Check for errors returned by the API
	    if (isset($response['error'])) {
	        print "Error: " . $response['error']['errormessage'] . "\n";
	        exit;
	    }
	    // Fetch the list of checks from the response
	    $checksList = $response['checks'];
	    // Print the names and statuses of all checks in the list
	    foreach ($checksList as $check) {
	        print $check['name'] . " is " . $check['status'] . "\n";
    	}
    }    
}

