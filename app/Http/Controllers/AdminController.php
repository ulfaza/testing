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
    	return view('/admin/edit_profil');
	}

    public function edit($id)
    {
        // mengambil data users berdasarkan id yang dipilih
        $users = DB::table('users')->where('id',$id)->get();
        // passing data admin yang didapat ke view edit_profil.blade.php
        return view('/admin/edit_profil',['users' => $users]);
    }

	public function tambahadmin()
	{

		return view('/admin/tambahadmin');
	}

    public function tambahbobot()
    {
        return view('/admin/tambahbobot');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'instansi' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);
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
        // alihkan halaman ke halaman home admin
        return redirect('/admin/home');
    }

    public function update(Request $request)
    {
        // update data users
        DB::table('users')->where('id',$request->id)->update([
            'name' => $request->name,
            'instansi' => $request->instansi,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        // alihkan halaman ke halaman home admin
        return view('/admin/view_admin');
    }

}

