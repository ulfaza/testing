<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AdminController extends Controller
{
    //
    public function index()
    {
        return view('/admin/home_admin');
    }

    public function view_admin()
    {
        return view('/admin/view_admin');
    }

    public function editprofil()
	{
  //       $users = DB::table('users')->where('username',$username)->get();

		 return view('/admin/edit_profil');
	}

	public function tambahadmin()
	{

		return view('/admin/tambahadmin');
	}

    public function tambahbobot()
    {
        return view('/admin/tambahbobot');
    }

    public function storeadmin(Request $request)
    {
        // insert data ke table users
        DB::table('users')->insert([
            'name' => $request->name,
            'role' => "admin",
            'instansi' => "",
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        // alihkan halaman ke halaman pegawai
        return redirect('/admin/home');
    }

}

