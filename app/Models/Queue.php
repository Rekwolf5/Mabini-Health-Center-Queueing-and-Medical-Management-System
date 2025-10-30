<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    protected $table = 'queue';

    protected $fillable = [
        'patient_id',
        'queue_number',
        'priority',
        'status',
        'service_type',
        'notes',
        'arrived_at',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'arrived_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function getWaitTimeAttribute()
    {
        if ($this->status === 'Waiting') {
            return now()->diffInMinutes($this->arrived_at);
        } elseif ($this->status === 'Consulting' && $this->started_at) {
            return $this->started_at->diffInMinutes($this->arrived_at);
        } elseif ($this->status === 'Completed' && $this->started_at) {
            return $this->started_at->diffInMinutes($this->arrived_at);
        }
        return 0;
    }
}
