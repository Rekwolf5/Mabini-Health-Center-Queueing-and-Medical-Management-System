<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineDispensed extends Model
{
    use HasFactory;

    protected $table = 'medicine_dispensed';

    protected $fillable = [
        'consultation_id',
        'medicine_id',
        'quantity',
        'instructions'
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
