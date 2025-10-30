<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Queue;
use App\Models\Patient;

class QueueController extends Controller
{
    public function index()
    {
        // SQLite-compatible ordering - get all queue entries for today
        $queue = Queue::with('patient')
            ->whereDate('created_at', today())
            ->orderBy('arrived_at', 'asc')
            ->get()
            ->sortBy(function ($item) {
                // Custom priority sorting: Emergency = 1, Urgent = 2, Normal = 3
                $priorities = ['Emergency' => 1, 'Urgent' => 2, 'Normal' => 3];
                return $priorities[$item->priority] ?? 4;
            })
            ->values(); // Reset array keys

        return view('queue.index', compact('queue'));
    }

    public function add()
    {
        $patients = Patient::orderBy('first_name')->get();
        return view('queue.add', compact('patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'priority' => 'required|in:Normal,Urgent,Emergency',
            'service_type' => 'required|in:Consultation,Check-up,Vaccination,Emergency',
            'notes' => 'nullable|string',
        ]);

        try {
            // Flexible patient name matching
            $inputName = trim(preg_replace('/\s+/', ' ', strtolower($validated['patient_name'])));
            $patient = Patient::all()->first(function ($p) use ($inputName) {
                $fullName = trim(preg_replace('/\s+/', ' ', strtolower($p->first_name . ' ' . $p->last_name)));
                return strpos($fullName, $inputName) !== false;
            });

            if (!$patient) {
                return back()->withInput()->with('error', 'Patient not found. Please register the patient first or check the spelling.');
            }

            // Generate queue number
            $todayCount = Queue::whereDate('created_at', today())->count();
            $queueNumber = 'Q' . str_pad($todayCount + 1, 3, '0', STR_PAD_LEFT);

            Queue::create([
                'patient_id' => $patient->id,
                'queue_number' => $queueNumber,
                'priority' => $validated['priority'],
                'service_type' => $validated['service_type'],
                'notes' => $validated['notes'],
                'arrived_at' => now(),
            ]);

            return redirect()->route('queue.index')->with('success', 'Patient added to queue successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error adding to queue: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $queue = Queue::findOrFail($id);
            
            if ($request->status === 'Consulting' && $queue->status === 'Waiting') {
                $queue->update([
                    'status' => 'Consulting',
                    'started_at' => now(),
                ]);
            } elseif ($request->status === 'Completed' && $queue->status === 'Consulting') {
                $queue->update([
                    'status' => 'Completed',
                    'completed_at' => now(),
                ]);
            }

            return redirect()->route('queue.index')->with('success', 'Queue status updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating queue status: ' . $e->getMessage());
        }
    }
}
