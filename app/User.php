<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'email', 'password','employee_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function employee(){
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
