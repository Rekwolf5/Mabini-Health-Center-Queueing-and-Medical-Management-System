@extends('layouts.app')

@section('title', 'Patient Details - Mabini Health Center')
@section('page-title', 'Patient Details')

@section('content')
<div class="patient-profile">
    <div class="profile-header">
        <div class="patient-avatar">
            <i class="fas fa-user-circle"></i>
        </div>
        <div class="patient-basic-info">
            <h2>{{ $patient->full_name }}</h2>
            <p>Age: {{ $patient->age }} | Gender: {{ ucfirst($patient->gender) }}</p>
            <p>Contact: {{ $patient->contact }}</p>
            <p>Address: {{ $patient->address }}</p>
        </div>
        <div class="profile-actions">
            <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i>
                Edit Patient
            </a>
        </div>
    </div>

    <div class="profile-content">
        <div class="medical-history">
            <h3>Medical History</h3>
            @if($patient->medicalRecords->count() > 0)
                <div class="history-timeline">
                    @foreach($patient->medicalRecords->sortByDesc('visit_date') as $record)
                    <div class="history-item">
                        <div class="history-date">{{ $record->visit_date->format('M d, Y') }}</div>
                        <div class="history-details">
                            <h4>{{ $record->diagnosis }}</h4>
                            <p>{{ $record->treatment }}</p>
                            @if($record->notes)
                                <p><strong>Notes:</strong> {{ $record->notes }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p style="color: #718096; text-align: center; padding: 2rem;">
                    No medical records found for this patient.
                </p>
            @endif
        </div>
    </div>
</div>
@endsection
