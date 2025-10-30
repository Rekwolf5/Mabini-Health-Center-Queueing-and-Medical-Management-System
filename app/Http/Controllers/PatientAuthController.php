<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\PatientAccount;
use App\Models\Patient;
use App\Models\ActivityLog;

class PatientAuthController extends Controller
{
    public function showLogin()
    {
        return view('patient.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('patient')->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $patient = Auth::guard('patient')->user();
            $patient->update(['last_login_at' => now()]);
            
            ActivityLog::log('login', 'Patient logged in', null, 'patient', $patient->id);
            
            $request->session()->regenerate();
            return redirect()->route('patient.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('patient.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:patient_accounts',
            'password' => 'required|string|min:8|confirmed',
            'age' => 'required|integer|min:1|max:150',
            'gender' => 'required|in:male,female',
            'contact' => 'required|string|max:255',
            'address' => 'required|string|max:1000',
        ]);

        // Create patient record
        $patient = Patient::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'age' => $request->age,
            'gender' => $request->gender,
            'contact' => $request->contact,
            'address' => $request->address,
            'date_of_birth' => now()->subYears($request->age)->format('Y-m-d'),
        ]);

        // Create patient account
        $patientAccount = PatientAccount::create([
            'patient_id' => $patient->id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        ActivityLog::log('register', 'New patient registered', ['patient_id' => $patient->id], 'patient', $patientAccount->id);

        Auth::guard('patient')->login($patientAccount);

        return redirect()->route('patient.dashboard');
    }

    public function logout(Request $request)
    {
        $patient = Auth::guard('patient')->user();
        ActivityLog::log('logout', 'Patient logged out', null, 'patient', $patient->id);
        
        Auth::guard('patient')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('patient.login');
    }
}
