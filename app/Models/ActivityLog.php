<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_type',
        'user_id',
        'action',
        'description',
        'data',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function user()
    {
        if ($this->user_type === 'user') {
            return $this->belongsTo(User::class, 'user_id');
        } elseif ($this->user_type === 'patient') {
            return $this->belongsTo(PatientAccount::class, 'user_id');
        }
        return null;
    }

    public static function log($action, $description, $data = null, $userType = 'user', $userId = null)
    {
        $userId = $userId ?? auth()->id();
        
        if (!$userId) return;

        self::create([
            'user_type' => $userType,
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'data' => $data,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
