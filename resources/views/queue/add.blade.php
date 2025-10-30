@extends('layouts.app')

@section('title', 'Add to Queue - Mabini Health Center')
@section('page-title', 'Add Patient to Queue')

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

    <form action="{{ route('queue.store') }}" method="POST" class="queue-form">
        @csrf
        
        <div class="form-section">
            <h3>Queue Information</h3>
            
            <div class="form-group">
                <label for="patient_name">Patient Name *</label>
                <input type="text" id="patient_name" name="patient_name" value="{{ old('patient_name') }}" required>
                <small style="color: #718096;">Enter patient's name (e.g., "Maria Santos"). Patient must be registered first.</small>
                
                @if($patients->count() > 0)
                <div style="margin-top: 0.5rem;">
                    <small style="color: #059669;"><strong>Registered Patients:</strong></small>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 0.25rem;">
                        @foreach($patients->take(10) as $patient)
                            <span style="background: #ecfdf5; color: #059669; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem; cursor: pointer;" 
                                  onclick="document.getElementById('patient_name').value = '{{ $patient->full_name }}'">
                                {{ $patient->full_name }}
                            </span>
                        @endforeach
                        @if($patients->count() > 10)
                            <span style="color: #6b7280; font-size: 0.75rem;">+{{ $patients->count() - 10 }} more...</span>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="priority">Priority *</label>
                    <select id="priority" name="priority" required>
                        <option value="Normal" {{ old('priority') == 'Normal' ? 'selected' : '' }}>Normal</option>
                        <option value="Urgent" {{ old('priority') == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                        <option value="Emergency" {{ old('priority') == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="service_type">Service Type *</label>
                    <select id="service_type" name="service_type" required>
                        <option value="Consultation" {{ old('service_type') == 'Consultation' ? 'selected' : '' }}>Consultation</option>
                        <option value="Check-up" {{ old('service_type') == 'Check-up' ? 'selected' : '' }}>Check-up</option>
                        <option value="Vaccination" {{ old('service_type') == 'Vaccination' ? 'selected' : '' }}>Vaccination</option>
                        <option value="Emergency" {{ old('service_type') == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="notes">Notes (Optional)</label>
                <textarea id="notes" name="notes" rows="3" placeholder="Any additional notes or symptoms...">{{ old('notes') }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('queue.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Add to Queue
            </button>
        </div>
    </form>
</div>

@if($patients->count() == 0)
<div class="dashboard-section" style="margin-top: 1.5rem;">
    <div style="text-align: center; padding: 2rem; color: #6b7280;">
        <i class="fas fa-user-plus" style="font-size: 2rem; margin-bottom: 1rem; color: #d1d5db;"></i>
        <h3 style="margin-bottom: 0.5rem;">No patients registered yet</h3>
        <p>You need to register patients first before adding them to the queue.</p>
        <a href="{{ route('patients.create') }}" class="btn btn-primary" style="margin-top: 1rem;">
            <i class="fas fa-user-plus"></i>
            Register First Patient
        </a>
    </div>
</div>
@endif
@endsection
