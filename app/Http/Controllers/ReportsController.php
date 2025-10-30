<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Queue;
use App\Models\Medicine;

class ReportsController extends Controller
{
    public function index()
    {
        $reportStats = [
            'total_patients' => Patient::count(),
            'consultations_today' => Queue::whereDate('created_at', today())->count(),
            'medicines_dispensed' => 0,
            'queue_average_wait' => '0 mins'
        ];

        $recentReports = []; // Empty - no sample reports

        return view('reports.index', compact('reportStats', 'recentReports'));
    }

    public function patients()
    {
        $totalPatients = Patient::count();
        
        $patientData = [
            'total_registered' => $totalPatients,
            'new_this_month' => Patient::whereMonth('created_at', now()->month)->count(),
            'active_patients' => $totalPatients,
            'by_age_group' => [
                '0-18' => Patient::where('age', '<=', 18)->count(),
                '19-35' => Patient::whereBetween('age', [19, 35])->count(),
                '36-50' => Patient::whereBetween('age', [36, 50])->count(),
                '51+' => Patient::where('age', '>', 50)->count(),
            ],
            'by_gender' => [
                'male' => Patient::where('gender', 'male')->count(),
                'female' => Patient::where('gender', 'female')->count(),
            ],
            'common_conditions' => [] // Empty - no sample conditions
        ];

        return view('reports.patients', compact('patientData'));
    }

    public function queue()
    {
        $todayQueue = Queue::whereDate('created_at', today());
        
        $queueData = [
            'total_served_today' => $todayQueue->count(),
            'average_wait_time' => '0 minutes',
            'peak_hours' => 'No data yet',
            'by_priority' => [
                'Normal' => $todayQueue->where('priority', 'Normal')->count(),
                'Urgent' => $todayQueue->where('priority', 'Urgent')->count(),
                'Emergency' => $todayQueue->where('priority', 'Emergency')->count(),
            ],
            'by_service' => [
                'Consultation' => $todayQueue->where('service_type', 'Consultation')->count(),
                'Check-up' => $todayQueue->where('service_type', 'Check-up')->count(),
                'Vaccination' => $todayQueue->where('service_type', 'Vaccination')->count(),
                'Emergency' => $todayQueue->where('service_type', 'Emergency')->count(),
            ],
            'hourly_data' => [] // Empty - no sample hourly data
        ];

        return view('reports.queue', compact('queueData'));
    }

    public function medicines()
    {
        $totalMedicines = Medicine::count();
        
        $medicineData = [
            'total_medicines' => $totalMedicines,
            'low_stock_items' => Medicine::where('stock', '<=', 25)->count(),
            'expired_items' => Medicine::where('expiry_date', '<', now())->count(),
            'total_value' => '₱' . number_format(Medicine::sum('price'), 2),
            'top_dispensed' => [], // Empty - no dispensing data yet
            'stock_levels' => [
                'Critical (0-10)' => Medicine::whereBetween('stock', [0, 10])->count(),
                'Low (11-25)' => Medicine::whereBetween('stock', [11, 25])->count(),
                'Normal (26-100)' => Medicine::whereBetween('stock', [26, 100])->count(),
                'High (100+)' => Medicine::where('stock', '>', 100)->count(),
            ],
            'expiry_alerts' => [
                'Expiring in 30 days' => Medicine::whereBetween('expiry_date', [now(), now()->addDays(30)])->count(),
                'Expiring in 60 days' => Medicine::whereBetween('expiry_date', [now()->addDays(30), now()->addDays(60)])->count(),
                'Expiring in 90 days' => Medicine::whereBetween('expiry_date', [now()->addDays(60), now()->addDays(90)])->count(),
            ]
        ];

        return view('reports.medicines', compact('medicineData'));
    }

    public function generate(Request $request)
    {
        $reportType = $request->input('type', 'daily');
        $category = $request->input('category', 'patients');
        
        return redirect()->route('reports.index')->with('success', 'Report generated successfully!');
    }
}
