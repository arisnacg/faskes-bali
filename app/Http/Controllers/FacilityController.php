<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facility;
use App\FacilityType;
use App\Condition;
use App\TrafficSign;
use App\TrafficSignType;

class FacilityController extends Controller
{
    public function index(){
    	return response()->json([
    		'facilities' => Facility::with(['type', 'contract', 'condition', 'traffic_sign'])->get(),
            'facility_types' => FacilityType::all(),
            'conditions' => Condition::all(),
            'traffic_sign_types' => TrafficSignType::all(),
            'traffic_signs' => TrafficSign::all()
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
            'contract_id' => 'required|integer'
        ]);

    	$facility = Facility::create($req->all());

    	if($req->traffic_sign_id){
            $this->validate($req, [
                'traffic_sign_id' => 'integer'
            ]);
            if($req->traffic_sign_id != 0)
                $facility->traffic_sign()->attach($req->traffic_sign_id);
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
