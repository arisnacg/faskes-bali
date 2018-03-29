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

	public function contract(){
		return $this->belongsTo(Contract::class, 'contract_id');
	}

	public function condition(){
		return $this->belongsTo(Condition::class, 'condition_id');
	}

	public function traffic_signs(){
		return $this->belongsToMany(TrafficSign::class, 'facility_traffic_sign', 'facility_id', 'traffic_sign_id')
			->withPivot('id');
	}
	
}
