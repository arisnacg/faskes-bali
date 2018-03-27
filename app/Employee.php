<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name', 'nip', 'position_id'
    ];

    public function position(){
    	return $this->belongsTo(Position::class, 'position_id');
    }

    public function user(){
    	return $this->hasOne(User::class, 'employee_id');
    }
}
