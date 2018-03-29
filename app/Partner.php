<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = [
    	'name', 'director', 'address', 'email', 'phone', 'type'
    ];

    public function ppk_contracts(){
    	return $this->hasMany(Contract::class, 'ppk');
    }

    public function pptk_contracts(){
    	return $this->hasMany(Contract::class, 'pptk');
    }
}
