@extends('layouts.app')

@section('title', 'Medicine Reports - Mabini Health Center')
@section('page-title', 'Medicine Inventory Reports')

@section('content')
<div class="reports-detail">
    <div class="page-header">
        <div class="header-actions">
            <a href="{{ route('reports.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to Reports
            </a>
            <button class="btn btn-primary" onclick="generateReport('medicines')">
                <i class="fas fa-download"></i>
                Generate Report
            </button>
        </div>
    </div>

    <!-- Medicine Statistics -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-pills"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $medicineData['total_medicines'] }}</h3>
                <p>Total Medicines</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $medicineData['low_stock_items'] }}</h3>
                <p>Low Stock Items</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-peso-sign"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $medicineData['total_value'] }}</h3>
                <p>Total Value</p>
            </div>
        </div>
    </div>

    <!-- Medicine Analytics -->
    <div class="reports-grid">
        <div class="report-section">
            <h3>Top Dispensed Medicines</h3>
            <div class="chart-container">
                @foreach($medicineData['top_dispensed'] as $medicine => $count)
                <div class="chart-item">
                    <div class="chart-label">{{ $medicine }}</div>
                    <div class="chart-bar">
                        <div class="chart-fill" style="width: {{ ($count / 89) * 100 }}%"></div>
                    </div>
                    <div class="chart-value">{{ $count }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="report-section">
            <h3>Stock Level Distribution</h3>
            <div class="chart-container">
                @foreach($medicineData['stock_levels'] as $level => $count)
                <div class="chart-item">
                    <div class="chart-label">{{ $level }}</div>
                    <div class="chart-bar">
                        <div class="chart-fill stock-{{ strtolower(explode(' ', $level)[0]) }}" style="width: {{ ($count / $medicineData['total_medicines']) * 100 }}%"></div>
                    </div>
                    <div class="chart-value">{{ $count }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="report-section">
            <h3>Expiry Alerts</h3>
            <div class="chart-container">
                @foreach($medicineData['expiry_alerts'] as $period => $count)
                <div class="chart-item">
                    <div class="chart-label">{{ $period }}</div>
                    <div class="chart-bar">
                        <div class="chart-fill expiry-alert" style="width: {{ ($count / 25) * 100 }}%"></div>
                    </div>
                    <div class="chart-value">{{ $count }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
