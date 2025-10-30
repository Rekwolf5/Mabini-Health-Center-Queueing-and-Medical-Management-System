@extends('layouts.app')

@section('title', 'Queue Reports - Mabini Health Center')
@section('page-title', 'Queue Performance Reports')

@section('content')
<div class="reports-detail">
    <div class="page-header">
        <div class="header-actions">
            <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to Reports
            </a>
            <button class="btn btn-primary" onclick="generateReport('queue')">
                <i class="fas fa-download"></i>
                Generate Report
            </button>
        </div>
    </div>

    <!-- Queue Statistics -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $queueData['total_served_today'] }}</h3>
                <p>Served Today</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $queueData['average_wait_time'] }}</h3>
                <p>Average Wait</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $queueData['peak_hours'] }}</h3>
                <p>Peak Hours</p>
            </div>
        </div>
    </div>

    <!-- Queue Analytics -->
    <div class="reports-grid">
        <div class="report-section">
            <h3>Priority Distribution</h3>
            <div class="chart-container">
                @foreach($queueData['by_priority'] as $priority => $count)
                <div class="chart-item">
                    <div class="chart-label">{{ $priority }}</div>
                    <div class="chart-bar">
                        <div class="chart-fill priority-{{ strtolower($priority) }}" style="width: {{ ($count / $queueData['total_served_today']) * 100 }}%"></div>
                    </div>
                    <div class="chart-value">{{ $count }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="report-section">
            <h3>Service Types</h3>
            <div class="chart-container">
                @foreach($queueData['by_service'] as $service => $count)
                <div class="chart-item">
                    <div class="chart-label">{{ $service }}</div>
                    <div class="chart-bar">
                        <div class="chart-fill" style="width: {{ ($count / $queueData['total_served_today']) * 100 }}%"></div>
                    </div>
                    <div class="chart-value">{{ $count }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="report-section">
            <h3>Hourly Traffic</h3>
            <div class="chart-container">
                @foreach($queueData['hourly_data'] as $hour => $count)
                <div class="chart-item">
                    <div class="chart-label">{{ $hour }}</div>
                    <div class="chart-bar">
                        <div class="chart-fill" style="width: {{ ($count / 8) * 100 }}%"></div>
                    </div>
                    <div class="chart-value">{{ $count }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
