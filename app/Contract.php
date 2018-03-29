<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
	protected $fillable = [
		'code', 'name', 'value', 'consultant', 'contractor', 'ppk', 'pptk', 'year'
	];

	public function consultant(){
		return $this->belongsTo(Employee::class, 'consultant');
	}

	public function contractor(){
		return $this->belongsTo(Employee::class, 'contractor');
	}

	public function ppk(){
		return $this->belongsTo(Partner::class, 'ppk');
	}

	public function pptk(){
		return $this->belongsTo(Partner::class, 'pptk');
	}
}
