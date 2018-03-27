<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;

class EmployeeController extends Controller
{
    public function index(){
    	return response()->json([
    		'employees' => Employee::all()
    	]);
    }

    public function show($id){
    	return response()->json([
    		'employee' => Employee::findOrFail($id)
    	]);
    }

    public function store(Request $req){

        $this->validate($req, [
            'name' => "required",
            'nip' => "required",
            'position_id' => "required|integer|between:1,3"
        ]);

    	$employee = Employee::create([
    		'name' => $req->name,
    		'nip' => $req->nip,
    		'position_id' => $req->position_id
    	]);

    	return response()->json([
    		'stored' => true,
    		'msg' => 'Pegawai berhasil didaftarkan',
    	]);
    }

    public function update($id, Request $req){
        
        $this->validate($req, [
            'name' => "required",
            'nip' => "required",
            'position_id' => "required|between:1,3"
        ]);

    	$employee = Employee::find($id)->update([
    		'name' => $req->name,
    		'nip' => $req->nip,
    		'position_id' => $req->position_id
    	]);

    	return response()->json([
    		'updated' => true,
    		'msg' => 'Pegawai berhasil di-update',
    	]);
    }

    public function destroy($id){
    	Employee::findOrFail($id)->delete();

    	return response()->json([
    		'deleted' => true,
    		'msg' => 'Pegawai berhasil dihapus',
    	]);
    }

}
