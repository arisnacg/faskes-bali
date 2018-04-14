<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Partner;
use App\Contract;
use App\Facility;
use App\TrafficSign;
use App\TrafficSignType;
use App\Condition;
use DB;

class FilterController extends Controller
{
    public function employee(Request $req){
    	$filter = [];
    	if($req->position_id){
    		$filter["position_id"] = $req->position_id;
    	}

    	return response()->json([
    		'employees' => Employee::with('position')->where($filter)->get()
    	]);
    	
    }

    public function partner(Request $req){
    	$filter = [];
    	if($req->type){
    		$filter["type"] = $req->type;
    	}

    	return response()->json([
    		'partners' => Partner::where($filter)->get()
    	]);
    }

    public function contract(Request $req){
    	$filter = [];
    	if($req->consultant_id){
    		$filter["consultant_id"] = $req->consultant_id;
    	}
    	if($req->contractor_id){
    		$filter["contractor_id"] = $req->contractor_id;
    	}
    	if($req->ppk_id){
    		$filter["ppk_id"] = $req->ppk_id;
    	}
    	if($req->pptk_id){
    		$filter["pptk_id"] = $req->pptk_id;
    	}

    	return response()->json([
    		'contracts' => Contract::with(['consultant','contractor', 'ppk','pptk'])->where($filter)->get()
    	]);
    }

    public function facility(Request $req){
    	$filter = [];
    	if($req->condition_id){
    		$filter["condition_id"] = $req->condition_id;
    	}
    	if($req->facility_type_id){
    		$filter["facility_type_id"] = $req->facility_type_id;
    	}
    	if($req->contract_id){
    		$filter["contract_id"] = $req->contract_id;
    	}

    	return response()->json([
    		'facilities' => Facility::with(['type', 'contract', 'condition', 'traffic_sign'])
    										->where($filter)->get()
    	]);
    }

    public function traffic_sign(Request $req){

        // $db = DB::table('facilities')
        //             ->join('facility_traffic_sign', 'facility_id', '=', 'facilities.id')
        //             ->join('contracts', 'contracts.id', '=', 'contract_id')
        //             ->join('traffic_signs', 'traffic_signs.id', '=', 'traffic_sign_id')
        //             ->join('traffic_sign_types', 'traffic_sign_types.id', '=', 'traffic_signs.traffic_sign_type_id')
        //             ->where('facility_type_id', 2);

        $db = DB::table('facilities')
                    ->join('contracts', 'contracts.id', '=', 'contract_id')
                    ->join('facility_traffic_sign', 'facility_id', '=', 'facilities.id')
                    ->join('traffic_signs', 'traffic_signs.id', '=', 'traffic_sign_id')
                    ->join('conditions', 'conditions.id', '=', 'condition_id')
                    ->join('traffic_sign_types', 'traffic_sign_types.id', '=', 'traffic_signs.traffic_sign_type_id');
                    
        if($req->condition_id){
           $db->where('condition_id', $req->condition_id);
        }
        if($req->contract_id){
           $db->where('contract_id', $req->contract_id);
        }
        if($req->traffic_sign_id){
            $db->where('traffic_sign_id', $req->traffic_sign_id);
        }

        $db->select('facilities.*', 'traffic_signs.*', 'traffic_sign_types.name as traffic_sign_type_name', 'conditions.name as condition_name', 'contracts.code as contract_code');

        return response()->json([
            'facilities' => $db->get(),
            'traffic_sign_types' => TrafficSignType::all(),
            'traffic_signs' => TrafficSign::all(),
            'conditions' => Condition::all()
        ]);
    }

}
