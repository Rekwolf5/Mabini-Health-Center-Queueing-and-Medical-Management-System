@extends('layouts.app')

@section('title', 'Patient Reports - Mabini Health Center')
@section('page-title', 'Patient Reports')

@section('content')
<div class="reports-detail">
    <div class="page-header">
        <div class="header-actions">
            <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to Reports
            </a>
            <button class="btn btn-primary" onclick="generateReport('patients')">
                <i class="fas fa-download"></i>
                Generate Report
            </button>
        </div>
    </div>

    <!-- Patient Statistics -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $patientData['total_registered'] }}</h3>
                <p>Total Registered</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $patientData['new_this_month'] }}</h3>
                <p>New This Month</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-heartbeat"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $patientData['active_patients'] }}</h3>
                <p>Active Patients</p>
            </div>
        </div>
    </div>

    <!-- Demographics -->
    <div class="reports-grid">
        <div class="report-section">
            <h3>Age Distribution</h3>
            <div class="chart-container">
                @foreach($patientData['by_age_group'] as $ageGroup => $count)
                <div class="chart-item">
                    <div class="chart-label">{{ $ageGroup }} years</div>
                    <div class="chart-bar">
                        <div class="chart-fill" style="width: {{ ($count / $patientData['total_registered']) * 100 }}%"></div>
                    </div>
                    <div class="chart-value">{{ $count }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="report-section">
            <h3>Gender Distribution</h3>
            <div class="chart-container">
                @foreach($patientData['by_gender'] as $gender => $count)
                <div class="chart-item">
                    <div class="chart-label">{{ ucfirst($gender) }}</div>
                    <div class="chart-bar">
                        <div class="chart-fill" style="width: {{ ($count / $patientData['total_registered']) * 100 }}%"></div>
                    </div>
                    <div class="chart-value">{{ $count }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="report-section">
            <h3>Common Conditions</h3>
            <div class="chart-container">
                @foreach($patientData['common_conditions'] as $condition => $count)
                <div class="chart-item">
                    <div class="chart-label">{{ $condition }}</div>
                    <div class="chart-bar">
                        <div class="chart-fill" style="width: {{ ($count / 100) * 100 }}%"></div>
                    </div>
                    <div class="chart-value">{{ $count }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
