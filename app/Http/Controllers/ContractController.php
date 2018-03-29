<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contract;

class ContractController extends Controller
{
    public function index(){
    	return response()->json([
    		'contracts' => Contract::all()
    	]);
    }

    public function show($id){
    	return response()->json([
    		'contract' => Contract::findOrFail($id)
    	]);
    }

    public function store(Request $req){
        $this->validate($req, [
        	'code' => 'required',
            'name' => 'required',
            'value' => 'required|integer',
            'consultant' => 'required|integer',
            'contractor' => 'required|integer',
            'ppk' => 'required|integer',
            'pptk' => 'required|integer',
            'year' => 'required|integer'
        ]);

    	$contract = Contract::create($req->all());

    	return response()->json([
    		'stored' => true,
    		'msg' => 'Kontrak berhasil didaftarkan',
    	]);
    }

    public function update($id, Request $req){
        
        $this->validate($req, [
            'code' => 'required',
            'name' => 'required',
            'value' => 'required|integer',
            'consultant' => 'required|integer',
            'contractor' => 'required|integer',
            'ppk' => 'required|integer',
            'pptk' => 'required|integer',
            'year' => 'required|integer'
        ]);

    	$contract = Contract::find($id)->update($req->all());

    	return response()->json([
    		'updated' => true,
    		'msg' => 'Kontrak berhasil di-update',
    	]);
    }

    public function destroy($id){
    	Contract::findOrFail($id)->delete();

    	return response()->json([
    		'deleted' => true,
    		'msg' => 'Kontrak berhasil dihapus',
    	]);
    }
}
