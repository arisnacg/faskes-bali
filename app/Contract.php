<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
	protected $fillable = [
		'code', 'value', 'consultant', 'contractor', 'ppk', 'pptk'
	];
}
