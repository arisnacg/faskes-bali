<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Position;

class PositionController extends Controller
{
    public function index(){
    	return response()->json([
    		'positions' => Position::all()
    	]);
    }
}
