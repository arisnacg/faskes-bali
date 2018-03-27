<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrafficSignType extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    public function traffic_signs(){
    	return $this->hasMany(TrafficSign::class, 'traffic_sign_type_id');
    }
}
