<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contract;
use App\Facility;

class ContractController extends Controller
{
    public function index(){
    	return response()->json([
    		'contracts' => Contract::with(['consultant','contractor', 'ppk','pptk'])->get()
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
            'value' => 'required|integer',
            'consultant_id' => 'required|integer',
            'contractor_id' => 'required|integer',
            'ppk_id' => 'required|integer',
            'pptk_id' => 'required|integer',
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
            'value' => 'required|integer',
            'consultant_id' => 'required|integer',
            'contractor_id' => 'required|integer',
            'ppk_id' => 'required|integer',
            'pptk_id' => 'required|integer',
            'year' => 'required|integer'
        ]);

    	$contract = Contract::find($id)->update($req->all());

    	return response()->json([
    		'updated' => true,
    		'msg' => 'Kontrak berhasil di-update',
    	]);
    }

    public function destroy($id){
    	$contract = Contract::findOrFail($id);
        Facility::where('contract_id', $contract->id)->delete();
        $contract->delete();

    	return response()->json([
    		'deleted' => true,
    		'msg' => 'Kontrak berhasil dihapus',
    	]);
    }
}
