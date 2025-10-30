@extends('layouts.app')

@section('title', 'Patients - Mabini Health Center')
@section('page-title', 'Patients')

@section('content')
<div class="page-header">
    <div class="header-actions">
        <a href="{{ route('patients.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Add New Patient
        </a>
    </div>
</div>

<div class="data-table-container">
    <table class="data-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Registered</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($patients as $patient)
            <tr>
                <td>
                    <div class="patient-name">
                        <i class="fas fa-user-circle"></i>
                        {{ $patient->full_name }}
                    </div>
                </td>
                <td>{{ $patient->age }}</td>
                <td>{{ ucfirst($patient->gender) }}</td>
                <td>{{ $patient->contact }}</td>
                <td>{{ $patient->address }}</td>
                <td>{{ $patient->created_at->format('M d, Y') }}</td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" action="{{ route('patients.destroy', $patient->id) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 2rem; color: #718096;">
                    No patients found. <a href="{{ route('patients.create') }}">Add the first patient</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($patients->hasPages())
<div style="margin-top: 2rem;">
    {{ $patients->links() }}
</div>
@endif
@endsection
