<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Patient;
use App\Models\PatientAccount;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('staff.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Base validation rules
        $rules = [
            'role' => 'required|in:patient,staff,admin',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];

        // Add role-specific validation
        if ($request->role === 'patient') {
            $rules = array_merge($rules, [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'age' => 'required|integer|min:1|max:150',
                'gender' => 'required|in:male,female',
                'contact' => 'required|string|max:255',
                'address' => 'required|string|max:1000',
            ]);
            
            // Also check if email is unique in patient_accounts
            $rules['email'] = 'required|string|email|max:255|unique:users|unique:patient_accounts';
        } else {
            $rules['phone'] = 'nullable|string|max:255';
        }

        $validated = $request->validate($rules);

        try {
            if ($request->role === 'patient') {
                // Create patient record
                $patient = Patient::create([
                    'first_name' => $validated['first_name'],
                    'last_name' => $validated['last_name'],
                    'age' => $validated['age'],
                    'gender' => $validated['gender'],
                    'contact' => $validated['contact'],
                    'address' => $validated['address'],
                    'date_of_birth' => now()->subYears($validated['age'])->format('Y-m-d'),
                ]);

                // Create patient account
                $patientAccount = PatientAccount::create([
                    'patient_id' => $patient->id,
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                ]);

                // Log in as patient
                Auth::guard('patient')->login($patientAccount);
                
                return redirect()->route('patient.dashboard')->with('success', 'Patient account created successfully!');
                
            } else {
                // Create staff/admin user
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role' => $validated['role'],
                    'phone' => $validated['phone'] ?? null,
                ]);

                // Log in as staff/admin
                Auth::login($user);
                
                return redirect()->route('staff.dashboard')->with('success', ucfirst($validated['role']) . ' account created successfully!');
            }
            
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }
}
