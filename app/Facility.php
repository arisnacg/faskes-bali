<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{

	protected $fillable = [
		'code', 'latitude', 'longitude', 'volume', 'condition_id', 'facility_type_id', 'contract_id'
	];

	public function type(){
		return $this->belongsTo(FacilityType::class, 'facility_type_id');
	}
	
}
