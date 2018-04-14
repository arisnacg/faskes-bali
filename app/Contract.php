<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
	protected $fillable = [
		'code', 'value', 'consultant_id', 'contractor_id', 'ppk_id', 'pptk_id', 'year'
	];

	public function consultant(){
		return $this->belongsTo(Partner::class, 'consultant_id');
	}

	public function contractor(){
		return $this->belongsTo(Partner::class, 'contractor_id');
	}

	public function ppk(){
		return $this->belongsTo(Employee::class, 'ppk_id');
	}

	public function pptk(){
		return $this->belongsTo(Employee::class, 'pptk_id');
	}
}
