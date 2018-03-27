<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = [
    	'name', 'director', 'address', 'email', 'phone', 'type'
    ];
}
