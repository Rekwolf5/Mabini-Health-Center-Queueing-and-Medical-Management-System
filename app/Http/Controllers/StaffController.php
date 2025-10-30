<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Queue;
use App\Models\Patient;
use App\Models\Medicine;
use App\Models\MedicalRecord;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function __construct()
    {
        // Remove the middleware calls from constructor
        // These will be handled in routes instead
    }

    public function queueManagement()
    {
        $queue = Queue::with('patient')
            ->whereDate('created_at', today())
            ->orderBy('arrived_at', 'asc')
            ->get()
            ->sortBy(function ($item) {
                $priorities = ['Emergency' => 1, 'Urgent' => 2, 'Normal' => 3];
                return $priorities[$item->priority] ?? 4;
            })
            ->values();

        return view('staff.queue-management', compact('queue'));
    }

    public function callNext(Request $request, $id)
    {
        $queue = Queue::findOrFail($id);
        
        if ($queue->status === 'Waiting') {
            $queue->update([
                'status' => 'Consulting',
                'started_at' => now(),
            ]);

            ActivityLog::log('queue_start', "Started consultation for {$queue->patient->full_name}", [
                'queue_id' => $queue->id,
                'patient_id' => $queue->patient_id,
            ]);

            return back()->with('success', 'Patient called for consultation.');
        }

        return back()->with('error', 'Cannot call this patient.');
    }

    public function markServed(Request $request, $id)
    {
        $request->validate([
            'diagnosis' => 'nullable|string|max:500',
            'treatment' => 'nullable|string|max:1000',
            'notes' => 'nullable|string|max:1000',
        ]);

        $queue = Queue::findOrFail($id);
        
        if ($queue->status === 'Consulting') {
            $queue->update([
                'status' => 'Completed',
                'completed_at' => now(),
                'notes' => $request->notes,
            ]);

            // Create medical record if diagnosis/treatment provided
            if ($request->diagnosis || $request->treatment) {
                MedicalRecord::create([
                    'patient_id' => $queue->patient_id,
                    'diagnosis' => $request->diagnosis,
                    'treatment' => $request->treatment,
                    'notes' => $request->notes,
                    'visit_date' => today(),
                ]);
            }

            ActivityLog::log('queue_complete', "Completed consultation for {$queue->patient->full_name}", [
                'queue_id' => $queue->id,
                'patient_id' => $queue->patient_id,
                'diagnosis' => $request->diagnosis,
            ]);

            return back()->with('success', 'Patient marked as served.');
        }

        return back()->with('error', 'Cannot mark this patient as served.');
    }

    public function markNoShow(Request $request, $id)
    {
        $queue = Queue::findOrFail($id);
        
        $queue->update([
            'status' => 'No Show',
            'notes' => 'Patient did not show up for appointment',
        ]);

        ActivityLog::log('queue_no_show', "Marked {$queue->patient->full_name} as no-show", [
            'queue_id' => $queue->id,
            'patient_id' => $queue->patient_id,
        ]);

        return back()->with('success', 'Patient marked as no-show.');
    }

    public function patientHistory($id)
    {
        $patient = Patient::findOrFail($id);
        $medicalHistory = MedicalRecord::where('patient_id', $id)
            ->orderBy('visit_date', 'desc')
            ->paginate(10);

        return view('staff.patient-history', compact('patient', 'medicalHistory'));
    }

    public function printQueueList()
    {
        $queue = Queue::with('patient')
            ->whereDate('created_at', today())
            ->orderBy('arrived_at', 'asc')
            ->get()
            ->sortBy(function ($item) {
                $priorities = ['Emergency' => 1, 'Urgent' => 2, 'Normal' => 3];
                return $priorities[$item->priority] ?? 4;
            })
            ->values();

        return view('staff.print-queue', compact('queue'));
    }

    public function medicineInventory()
    {
        $medicines = Medicine::orderBy('name')->get();
        return view('staff.medicine-inventory', compact('medicines'));
    }

    public function updateMedicineStock(Request $request, $id)
    {
        $request->validate([
            'stock_change' => 'required|integer',
            'reason' => 'required|string|max:255',
        ]);

        $medicine = Medicine::findOrFail($id);
        $oldStock = $medicine->stock;
        $newStock = $oldStock + $request->stock_change;

        if ($newStock < 0) {
            return back()->with('error', 'Stock cannot be negative.');
        }

        $medicine->update(['stock' => $newStock]);

        ActivityLog::log('medicine_stock_update', "Updated {$medicine->name} stock from {$oldStock} to {$newStock}", [
            'medicine_id' => $medicine->id,
            'old_stock' => $oldStock,
            'new_stock' => $newStock,
            'change' => $request->stock_change,
            'reason' => $request->reason,
        ]);

        return back()->with('success', 'Medicine stock updated successfully.');
    }
}
