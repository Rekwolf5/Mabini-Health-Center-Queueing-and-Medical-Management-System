<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dosage',
        'type',
        'stock',
        'expiry_date',
        'description',
        'price',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'price' => 'decimal:2',
    ];

    public function getStatusAttribute()
    {
        if ($this->stock <= 5) {
            return 'Critical';
        } elseif ($this->stock <= 25) {
            return 'Low Stock';
        }
        return 'Available';
    }

    public function getIsExpiredAttribute()
    {
        return $this->expiry_date->isPast();
    }

    public function getExpiresInDaysAttribute()
    {
        return now()->diffInDays($this->expiry_date, false);
    }
}
