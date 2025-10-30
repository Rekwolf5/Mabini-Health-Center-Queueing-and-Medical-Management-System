@extends('layouts.app')

@section('title', 'Dashboard - Mabini Health Center')
@section('page-title', 'Dashboard')

@section('content')
<div class="dashboard-grid">
    <!-- Stats Cards -->
    <div class="stats-row">
        <div class="stat-card patients">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['patients_today'] }}</h3>
                <p>Patients Today</p>
            </div>
        </div>

        <div class="stat-card queue">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['queue_waiting'] }}</h3>
                <p>In Queue</p>
            </div>
        </div>

        <div class="stat-card medicines">
            <div class="stat-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['medicines_low'] }}</h3>
                <p>Low Stock</p>
            </div>
        </div>

        <div class="stat-card reports">
            <div class="stat-icon">
                <i class="fas fa-chart-bar"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['reports_generated'] }}</h3>
                <p>Reports Generated</p>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="dashboard-section">
        <div class="section-header">
            <h2>Recent Patients</h2>
            <a href="{{ route('patients.index') }}" class="btn btn-primary">View All</a>
        </div>
        
        <div class="recent-patients">
            @foreach($recent_patients as $patient)
            <div class="patient-item">
                <div class="patient-info">
                    <h4>{{ $patient['name'] }}</h4>
                    <p>{{ $patient['time'] }}</p>
                </div>
                <div class="patient-status status-{{ $patient['status'] }}">
                    {{ ucfirst($patient['status']) }}
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="dashboard-section">
        <div class="section-header">
            <h2>Quick Actions</h2>
        </div>
        
        <div class="quick-actions">
            <a href="{{ route('patients.create') }}" class="action-btn">
                <i class="fas fa-user-plus"></i>
                <span>Add Patient</span>
            </a>
            <a href="{{ route('queue.add') }}" class="action-btn">
                <i class="fas fa-plus"></i>
                <span>Add to Queue</span>
            </a>
            <a href="{{ route('medicines.create') }}" class="action-btn">
                <i class="fas fa-pills"></i>
                <span>Add Medicine</span>
            </a>
            <a href="{{ route('reports.index') }}" class="action-btn">
                <i class="fas fa-chart-bar"></i>
                <span>Generate Report</span>
            </a>
        </div>
    </div>
</div>
@endsection
