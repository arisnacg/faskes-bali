<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrafficSign extends Model
{

	protected $fillable = [
		'name', 'image', 'traffic_sign_type_id'
	];

    public $timestamps = false;

    public function type(){
    	return $this->belongsTo(TrafficSignType::class, 'traffic_sign_type_id');
    }
}
