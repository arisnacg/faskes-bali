<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index(){
    	return response()->json([
    		'users' => User::all()
    	]);
    }

    public function show($id){
    	return response()->json([
    		'user' => User::findOrFail($id)
    	]);
    }

    public function store(Request $req){

    	$this->validate($req, [
            'email' => "required|email",
            'password' => "required",
            'employee_id' => "required|integer"
        ]);

    	if(User::where('employee_id', $req->employee_id)){
    		return response()->json([
	    		'stored' => false,
	    		'msg' => 'Pegawai sudah memiliki akun',
	    	]);
    	}

    	$user = new User();

    	$user->email = $req->email;
    	$user->password = $req->password;
    	$user->employee_id = $req->employee_id;
    	$user->save();

    	return response()->json([
    		'stored' => true,
    		'msg' => 'Akun berhasil didaftarkan',
    	]);
    }

    public function update($id, Request $req){

    	$this->validate($req, [
            'email' => "required|email",
            'password' => "required",
            'employee_id' => "required|integer"
        ]);

    	$user = User::findOrFail($id);

    	if(count(User::where('employee_id', $req->employee_id)->get()) != 1){
    		return response()->json([
	    		'updated' => true,
	    		'msg' => 'Akun gagal di-update'
	    	]);
    	}

    	$user->email = $req->email;
    	$user->password = $req->password;
    	$user->employee_id = $req->employee_id;
    	$user->save();

    	return response()->json([
    		'updated' => true,
    		'msg' => 'Akun berhasil di-update'
    	]);
    }

    public function destroy($id){
    	User::findOrFail($id)->delete();

    	return response()->json([
    		'deleted' => true,
    		'msg' => 'Akun berhasil dihapus',
    	]);
    }
}
