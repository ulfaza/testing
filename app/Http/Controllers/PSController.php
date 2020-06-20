<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PSController extends Controller
{
    public function index($a_id)
    {
        return view('automatic');
    }
}
