<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::orderBy('created_at', 'desc')->paginate(10);
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        // Log the incoming request
        Log::info('Patient store method called');
        Log::info('Request data: ', $request->all());
        Log::info('Request method: ' . $request->method());
        Log::info('Request URL: ' . $request->url());

        try {
            // Validate the request
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'age' => 'required|integer|min:1|max:150',
                'gender' => 'required|in:male,female',
                'contact' => 'required|string|max:255',
                'address' => 'required|string|max:1000',
            ]);

            Log::info('Validation passed');
            Log::info('Validated data: ', $validated);

            // Test database connection
            DB::connection()->getPdo();
            Log::info('Database connection successful');

            // Create the patient
            $patient = new Patient();
            $patient->first_name = $validated['first_name'];
            $patient->last_name = $validated['last_name'];
            $patient->age = $validated['age'];
            $patient->gender = $validated['gender'];
            $patient->contact = $validated['contact'];
            $patient->address = $validated['address'];
            $patient->save();

            Log::info('Patient created successfully with ID: ' . $patient->id);

            return redirect()->route('patients.index')->with('success', 'Patient registered successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed: ', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Exception occurred: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return back()->withInput()->with('error', 'Error saving patient: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $patient = Patient::with('medicalRecords')->findOrFail($id);
        return view('patients.show', compact('patient'));
    }

    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'age' => 'required|integer|min:1|max:150',
                'gender' => 'required|in:male,female',
                'contact' => 'required|string|max:255',
                'address' => 'required|string|max:1000',
            ]);

            $patient = Patient::findOrFail($id);
            $patient->update($validated);
            
            return redirect()->route('patients.show', $id)->with('success', 'Patient updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating patient: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error updating patient: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $patient = Patient::findOrFail($id);
            $patient->delete();
            return redirect()->route('patients.index')->with('success', 'Patient deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting patient: ' . $e->getMessage());
            return back()->with('error', 'Error deleting patient: ' . $e->getMessage());
        }
    }
}
