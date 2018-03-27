<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacilityType extends Model
{
    protected $fillable = ['name','about'];
    public $timestamps = false;

    public function facilities(){
    	return $this->hasMany(Facility::class, 'facility_type_id');
    }
}
