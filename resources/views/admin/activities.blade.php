@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-5 fw-bold">📝 Activity Logs</h1>
            <p class="text-muted">Track all system activities and changes</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">← Back to Dashboard</a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.activities') }}" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label fw-bold">Model Type</label>
                    <select name="model_type" class="form-select">
                        <option value="">All Models</option>
                        <option value="MedicalRecord" {{ $modelType === 'MedicalRecord' ? 'selected' : '' }}>Medical Records</option>
                        <option value="User" {{ $modelType === 'User' ? 'selected' : '' }}>Users</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-bold">Action Type</label>
                    <select name="action" class="form-select">
                        <option value="">All Actions</option>
                        <option value="created" {{ $action === 'created' ? 'selected' : '' }}>Created</option>
                        <option value="updated" {{ $action === 'updated' ? 'selected' : '' }}>Updated</option>
                        <option value="deleted" {{ $action === 'deleted' ? 'selected' : '' }}>Deleted</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i> Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Activities Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light border-bottom">
            <h5 class="card-title mb-0 fw-bold">System Activities ({{ $activities->total() }})</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="fw-bold">User</th>
                        <th class="fw-bold">Action</th>
                        <th class="fw-bold">Model</th>
                        <th class="fw-bold text-center">ID</th>
                        <th class="fw-bold">IP Address</th>
                        <th class="fw-bold">Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $activity)
                        <tr>
                            <td><strong>{{ $activity->user?->name ?? 'System' }}</strong></td>
                            <td>
                                @php
                                    $badgeClass = match($activity->action) {
                                        'created' => 'bg-success',
                                        'updated' => 'bg-info',
                                        'deleted' => 'bg-danger',
                                        'viewed' => 'bg-secondary',
                                        default => 'bg-dark'
                                    };
                                    $icon = match($activity->action) {
                                        'created' => 'fa-plus',
                                        'updated' => 'fa-edit',
                                        'deleted' => 'fa-trash',
                                        'viewed' => 'fa-eye',
                                        default => 'fa-circle'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}"><i class="fas {{ $icon }}"></i> {{ ucfirst($activity->action) }}</span>
                            </td>
                            <td><code class="text-dark">{{ $activity->model_type }}</code></td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark">#{{ $activity->model_id }}</span>
                            </td>
                            <td><small class="text-monospace">{{ $activity->ip_address ?? 'N/A' }}</small></td>
                            <td>
                                <small class="text-muted" title="{{ $activity->created_at->format('Y-m-d H:i:s') }}">{{ $activity->created_at->format('M d, Y H:i') }}</small>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No activities found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($activities->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $activities->links() }}
    </div>
    @endif
</div>
@endsection
