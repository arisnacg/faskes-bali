<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Facility;
use DB;
use View;
use PDF;

class CobaController extends Controller
{
    public function index(){
    	$pdf = PDF::loadView('pdf.coba');
        $pdf->setPaper('A4', 'portrait');
        $filename = 'coba.pdf';
        $pdf->save('pdf/'.$filename);
    } 
}
