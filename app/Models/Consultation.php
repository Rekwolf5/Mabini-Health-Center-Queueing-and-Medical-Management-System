<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'queue_id',
        'diagnosis',
        'symptoms',
        'treatment',
        'prescription',
        'notes',
        'follow_up_date'
    ];

    protected $casts = [
        'follow_up_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }

    public function medicinesDispensed()
    {
        return $this->hasMany(MedicineDispensed::class);
    }
}
