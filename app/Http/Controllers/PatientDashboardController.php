<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Queue;
use App\Models\MedicalRecord;

class PatientDashboardController extends Controller
{
    // Constructor can be empty or removed entirely
    // Middleware will be handled in routes

    public function index()
    {
        $patient = Auth::guard('patient')->user()->patient;
        
        // Get current queue status
        $currentQueue = Queue::where('patient_id', $patient->id)
            ->whereDate('created_at', today())
            ->whereIn('status', ['Waiting', 'Consulting'])
            ->first();

        // Get queue position if waiting
        $queuePosition = null;
        if ($currentQueue && $currentQueue->status === 'Waiting') {
            $queuePosition = Queue::where('arrived_at', '<', $currentQueue->arrived_at)
                ->whereDate('created_at', today())
                ->whereIn('status', ['Waiting', 'Consulting'])
                ->count() + 1;
        }

        // Get recent medical history
        $recentHistory = MedicalRecord::where('patient_id', $patient->id)
            ->orderBy('visit_date', 'desc')
            ->take(5)
            ->get();

        // Get upcoming appointments (if any)
        $upcomingAppointments = Queue::where('patient_id', $patient->id)
            ->whereDate('created_at', '>', today())
            ->orderBy('arrived_at', 'asc')
            ->get();

        return view('patient.dashboard', compact(
            'patient',
            'currentQueue',
            'queuePosition',
            'recentHistory',
            'upcomingAppointments'
        ));
    }

    public function profile()
    {
        $patient = Auth::guard('patient')->user()->patient;
        return view('patient.profile', compact('patient'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'contact' => 'required|string|max:255',
            'address' => 'required|string|max:1000',
            'emergency_contact' => 'nullable|string|max:255',
        ]);

        $patient = Auth::guard('patient')->user()->patient;
        $patient->update($request->only(['contact', 'address', 'emergency_contact']));

        return back()->with('success', 'Profile updated successfully!');
    }

    public function medicalHistory()
    {
        $patient = Auth::guard('patient')->user()->patient;
        $medicalHistory = MedicalRecord::where('patient_id', $patient->id)
            ->orderBy('visit_date', 'desc')
            ->paginate(10);

        return view('patient.medical-history', compact('patient', 'medicalHistory'));
    }
}
