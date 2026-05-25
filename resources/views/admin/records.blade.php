@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-5 fw-bold">📋 All Medical Records</h1>
            <p class="text-muted">View and manage medical records across the system</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">← Back to Dashboard</a>
        </div>
    </div>

    <!-- Search Form -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.records') }}" class="row g-3">
                <div class="col-md-8">
                    <input type="text" name="search" class="form-control" placeholder="Search by patient name or user..." value="{{ $search }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Search</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Records Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light border-bottom">
            <h5 class="card-title mb-0 fw-bold">System Medical Records ({{ $records->total() }})</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="fw-bold">Patient Name</th>
                        <th class="fw-bold">Created By</th>
                        <th class="fw-bold">Status</th>
                        <th class="fw-bold">Created Date</th>
                        <th class="fw-bold text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $record)
                        <tr>
                            <td><strong>{{ $record->patient_name }}</strong></td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $record->user->name }}</span>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $record->medical_status }}</span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $record->created_at->format('M d, Y H:i') }}</small>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('medical-records.show', $record) }}" class="btn btn-sm btn-outline-primary me-2" title="View"><i class="fas fa-eye"></i></a>
                                <form method="POST" action="{{ route('admin.delete-record', $record) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Permanently delete this record? This cannot be undone.')" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($records->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $records->links() }}
    </div>
    @endif
</div>
@endsection
