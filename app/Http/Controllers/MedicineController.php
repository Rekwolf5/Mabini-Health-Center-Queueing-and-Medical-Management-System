<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::orderBy('name')->get();
        return view('medicines.index', compact('medicines'));
    }

    public function create()
    {
        return view('medicines.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'dosage' => 'required|string|max:255',
            'type' => 'required|in:Tablet,Capsule,Syrup,Injection',
            'stock' => 'required|integer|min:0',
            'expiry_date' => 'required|date|after:today',
            'description' => 'nullable|string',
        ]);

        try {
            Medicine::create($validated);
            return redirect()->route('medicines.index')->with('success', 'Medicine added successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error saving medicine: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $medicine = Medicine::findOrFail($id);
        return view('medicines.show', compact('medicine'));
    }

    public function edit($id)
    {
        $medicine = Medicine::findOrFail($id);
        return view('medicines.edit', compact('medicine'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'dosage' => 'required|string|max:255',
            'type' => 'required|in:Tablet,Capsule,Syrup,Injection',
            'stock' => 'required|integer|min:0',
            'expiry_date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        try {
            $medicine = Medicine::findOrFail($id);
            $medicine->update($validated);
            return redirect()->route('medicines.show', $id)->with('success', 'Medicine updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating medicine: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $medicine = Medicine::findOrFail($id);
            $medicine->delete();
            return redirect()->route('medicines.index')->with('success', 'Medicine deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting medicine: ' . $e->getMessage());
        }
    }
}
