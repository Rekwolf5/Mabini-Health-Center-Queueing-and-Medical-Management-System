@extends('layouts.app')

@section('title', 'Add Patient - Mabini Health Center')
@section('page-title', 'Add New Patient')

@section('content')
<div class="form-container">
    @if ($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <strong>Please fix the following errors:</strong>
            <ul style="margin: 0.5rem 0 0 1rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('patients.store') }}" method="POST" class="patient-form" id="patientForm">
        @csrf
        
        <div class="form-section">
            <h3>Personal Information</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">First Name *</label>
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name *</label>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="age">Age *</label>
                    <input type="number" id="age" name="age" value="{{ old('age') }}" min="1" max="150" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender *</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="contact">Contact Number *</label>
                <input type="tel" id="contact" name="contact" value="{{ old('contact') }}" required>
            </div>

            <div class="form-group">
                <label for="address">Address *</label>
                <textarea id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('patients.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary" id="submitBtn">
                <i class="fas fa-save"></i>
                Save Patient
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('patientForm');
    const submitBtn = document.getElementById('submitBtn');
    
    form.addEventListener('submit', function(e) {
        console.log('Form submission started');
        
        // Disable button to prevent double submission
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
        
        // Re-enable after 10 seconds as fallback
        setTimeout(function() {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-save"></i> Save Patient';
        }, 10000);
    });
});
</script>
@endsection
