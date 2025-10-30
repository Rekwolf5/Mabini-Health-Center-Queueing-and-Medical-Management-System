<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Queue;
use App\Models\Medicine;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'patients_today' => Patient::whereDate('created_at', today())->count(),
            'queue_waiting' => Queue::where('status', 'Waiting')->count(),
            'medicines_low' => Medicine::where('stock', '<=', 25)->count(),
            'reports_generated' => 0 // Start with 0 since no sample data
        ];

        // Get recent patients (empty if no data)
        $recent_patients = Queue::with('patient')
            ->whereDate('created_at', today())
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($queue) {
                return [
                    'name' => $queue->patient->full_name,
                    'time' => $queue->arrived_at->format('h:i A'),
                    'status' => strtolower($queue->status)
                ];
            });

        return view('dashboard', compact('stats', 'recent_patients'));
    }
}
