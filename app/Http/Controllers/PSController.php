<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class PSController extends Controller
{
    public function index($a_id)
    {
        return view('automatic');
    }

    public function loadtest()
    {
		$process = new Process(['C:\Program Files (x86)\Python38-32\python', 'C:\xampp\htdocs\testing\public\flask\main.py']);
		$process->run();

		// executes after the command finishes
		if (!$process->isSuccessful()) {
		    throw new ProcessFailedException($process);
		}
		echo $process->getOutput();
    }    
}

