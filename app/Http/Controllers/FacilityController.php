<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facility;

class FacilityController extends Controller
{
    public function index(){
    	return response()->json([
    		'facilitys' => Facility::all()
    	]);
    }

    public function show($id){
    	return response()->json([
    		'facility' => Facility::findOrFail($id)
    	]);
    }

    public function store(Request $req){

        $this->validate($req, [
            'code' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'volume' => 'required|integer',
            'condition_id' => 'required|integer',
            'facility_type_id' => 'required|integer',
            'contract_id' => 'required|integer',
            'traffic_sign_id' => 'integer'
        ]);

    	$facility = Facility::create($req->all());

    	if($req->traffic_sign_id){
    		$facility->traffic_signs()->attach($req->traffic_sign_id);
    	}

    	return response()->json([
    		'stored' => true,
    		'msg' => 'Faskes berhasil didaftarkan',
    	]);
    }

    public function update($id, Request $req){
        //'code', 'latitude', 'longitude', 'volume', 'condition_id', 'facility_type_id', 'contract_id'
        $this->validate($req, [
            'code' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'volume' => 'required|integer',
            'condition_id' => 'required|integer',
            'facility_type_id' => 'required|integer',
            'contract_id' => 'required|integer',
            'traffic_sign_id' => 'integer'
        ]);

    	$facility = Facility::find($id)->update($req->all());

    	return response()->json([
    		'updated' => true,
    		'msg' => 'Faskes berhasil di-update',
    	]);
    }

    public function destroy($id){
    	Facility::findOrFail($id)->delete();

    	return response()->json([
    		'deleted' => true,
    		'msg' => 'Faskes berhasil dihapus',
    	]);
    }
}
