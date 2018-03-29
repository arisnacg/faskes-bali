<?php

namespace App\Http\Controllers;
use Auth;
use App\User;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
    	return view('dashboard')
    		->with('user', User::with('employee')->find(Auth::user()->id));
    }

    public function pegawai(){
    	return view('kelola_pegawai')
    		->with('user', User::with('employee')->find(Auth::user()->id));
    }
}
