<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use DB;
use App\Employee;
use App\Partner;
use App\Contract;
use App\Facility;

class PDFController extends Controller
{
    public function employee(Request $req){

    	$filter = [];
    	if($req->position_id){
    		$filter["position_id"] = $req->position_id;
    	}
    	$rows = Employee::with('position')->where($filter)->get();

    	$pdf = PDF::loadView('pdf.pegawai', compact('rows'));
    	$pdf->setPaper('A4', 'portrait');
    	$filename = 'tabel_pegawai.pdf';
    	$pdf->save('pdf/'.$filename);

    	return response()->json([
    		'printed' => true,
    		'filename' => $filename
    	]);
    }

    public function partner(Request $req){

        $filter = [];
        if($req->type){
            $filter["type"] = $req->type;
        }
        $rows = Partner::where($filter)->get();

        $pdf = PDF::loadView('pdf.rekanan', compact('rows'));
        $pdf->setPaper('A4', 'landscape');
        $filename = 'tabel_rekanan.pdf';
        $pdf->save('pdf/'.$filename);

        return response()->json([
            'printed' => true,
            'filename' => $filename
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
        $rows = Contract::with(['consultant','contractor', 'ppk','pptk'])->where($filter)->get();
        $pdf = PDF::loadView('pdf.kontrak', compact('rows'));
        $pdf->setPaper('A4', 'landscape');
        $filename = 'tabel_kontrak.pdf';
        $pdf->save('pdf/'.$filename);

        return response()->json([
            'printed' => true,
            'filename' => $filename
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
        $rows = Facility::with(['type', 'contract', 'condition', 'traffic_sign'])->where($filter)->get();

        $pdf = PDF::loadView('pdf.fasilitas', compact('rows'));
        $pdf->setPaper('A4', 'landscape');
        $filename = 'tabel_fasilitas.pdf';
        $pdf->save('pdf/'.$filename);

        return response()->json([
            'printed' => true,
            'filename' => $filename
        ]);
    }

    public function traffic_sign(Request $req){

        $rows = DB::table('facilities')
                    ->join('contracts', 'contracts.id', '=', 'contract_id')
                    ->join('facility_traffic_sign', 'facility_id', '=', 'facilities.id')
                    ->join('traffic_signs', 'traffic_signs.id', '=', 'traffic_sign_id')
                    ->join('conditions', 'conditions.id', '=', 'condition_id')
                    ->join('traffic_sign_types', 'traffic_sign_types.id', '=', 'traffic_signs.traffic_sign_type_id');
                    
        if($req->condition_id){
           $rows->where('condition_id', $req->condition_id);
        }
        if($req->contract_id){
           $rows->where('contract_id', $req->contract_id);
        }
        if($req->traffic_sign_id){
            $rows->where('traffic_sign_id', $req->traffic_sign_id);
        }

        $rows->select('facilities.*', 'traffic_signs.*', 'traffic_sign_types.name as traffic_sign_type_name', 'conditions.name as condition_name', 'contracts.code as contract_code');

        $pdf = PDF::loadView('pdf.rambu', ['rows' => $rows->get()]);
        $pdf->setPaper('A4', 'landscape');
        $filename = 'tabel_rambu.pdf';
        $pdf->save('pdf/'.$filename);

        return response()->json([
            'printed' => true,
            'filename' => $filename
        ]);
    }

    public function download($filename){
    	$file = public_path(). '/pdf/'.$filename;
        return response()->download($file, $filename);
    }

}
