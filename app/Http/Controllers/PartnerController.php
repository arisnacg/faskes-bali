<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Partner;

class PartnerController extends Controller
{

    public function index(){
    	return response()->json([
    		'partners' => Partner::all()
    	]);
    }

    public function show($id){
    	return response()->json([
    		'partner' => Partner::findOrFail($id)
    	]);
    }

    public function store(Request $req){
        $this->validate($req, [
            'name' => 'required',
            'director' => 'required',
            'address' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'type' => 'required|integer'
        ]);

    	$partner = Partner::create([
    		'name' => $req->name,
            'director' => $req->director,
            'address' => $req->address,
            'email' => $req->email,
            'phone' => $req->phone,
            'type' => $req->type
    	]);

    	return response()->json([
    		'stored' => true,
    		'msg' => 'Rekanan berhasil didaftarkan',
    	]);
    }

    public function update($id, Request $req){
        
        $this->validate($req, [
            'name' => 'required',
            'director' => 'required',
            'address' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'type' => 'required|integer'
        ]);

    	$partner = Partner::find($id)->update([
    		'name' => $req->name,
            'director' => $req->director,
            'address' => $req->address,
            'email' => $req->email,
            'phone' => $req->phone,
            'type' => $req->type
    	]);

    	return response()->json([
    		'updated' => true,
    		'msg' => 'Rekanan berhasil di-update',
    	]);
    }

    public function destroy($id){
    	Partner::findOrFail($id)->delete();

    	return response()->json([
    		'deleted' => true,
    		'msg' => 'Rekanan berhasil dihapus',
    	]);
    }
}
