<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Employee;
use App\Position;
use App\User;


class EmployeeController extends Controller
{
    
    public function index(Request $req){
    	return response()->json([
    		'employees' => Employee::with('position')->get(),
            'positions' => Position::all()
    	]);
    }

    public function show($id){
    	return response()->json([
    		'employee' => Employee::with('position')->findOrFail($id)
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
    	$employee = Employee::findOrFail($id);
        if(Auth::user()->employee_id == $employee->id){
            return response()->json([
                'deleted' => false,
                'msg' => 'Pegawai dalam keadaan login',
            ]);
        }

        $employee->delete();
    	return response()->json([
    		'deleted' => true,
    		'msg' => 'Pegawai berhasil dihapus',
    	]);
    }

}
