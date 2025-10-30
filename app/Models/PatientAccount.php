<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class PatientAccount extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'patient_id',
        'email',
        'password',
        'status',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'last_login_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function getFullNameAttribute()
    {
        return $this->patient->full_name;
    }
}
