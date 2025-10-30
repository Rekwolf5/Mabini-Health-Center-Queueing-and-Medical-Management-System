@extends('layouts.app')

@section('title', 'Medicine Inventory - Mabini Health Center')
@section('page-title', 'Medicine Inventory')

@section('content')
<div class="page-header">
    <div class="header-actions">
        <a href="{{ route('medicines.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Add Medicine
        </a>
    </div>
</div>

<div class="medicines-grid">
    @foreach($medicines as $medicine)
    <div class="medicine-card status-{{ strtolower(str_replace(' ', '-', $medicine['status'])) }}">
        <div class="medicine-header">
            <h4>{{ $medicine['name'] }}</h4>
            <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $medicine['status'])) }}">
                {{ $medicine['status'] }}
            </span>
        </div>
        
        <div class="medicine-details">
            <div class="detail-item">
                <i class="fas fa-boxes"></i>
                <span>Stock: {{ $medicine['stock'] }}</span>
            </div>
            <div class="detail-item">
                <i class="fas fa-calendar-alt"></i>
                <span>Expires: {{ $medicine['expiry_date'] }}</span>
            </div>
        </div>

        <div class="medicine-actions">
            <button class="btn btn-sm btn-info">
                <i class="fas fa-eye"></i>
            </button>
            <button class="btn btn-sm btn-warning">
                <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i>
                Restock
            </button>
        </div>
    </div>
    @endforeach
</div>
@endsection
