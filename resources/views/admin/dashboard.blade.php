@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="display-5 fw-bold">📊 Admin Dashboard</h1>
            <p class="text-muted">System overview and management</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #0d6efd;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted text-uppercase fw-bold mb-2" style="font-size: 0.75rem;">Total Users</h6>
                            <h2 class="fw-bold text-primary mb-0">{{ $totalUsers }}</h2>
                        </div>
                        <span style="font-size: 2.5rem; opacity: 0.2;">👥</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #198754;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted text-uppercase fw-bold mb-2" style="font-size: 0.75rem;">Medical Records</h6>
                            <h2 class="fw-bold text-success mb-0">{{ $totalRecords }}</h2>
                        </div>
                        <span style="font-size: 2.5rem; opacity: 0.2;">📋</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #ffc107;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="text-muted text-uppercase fw-bold mb-2" style="font-size: 0.75rem;">Admin Users</h6>
                            <h2 class="fw-bold text-warning mb-0">{{ $totalAdmins }}</h2>
                        </div>
                        <span style="font-size: 2.5rem; opacity: 0.2;">👨‍💼</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h5 class="fw-bold mb-3">Quick Actions</h5>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('admin.users') }}" class="card text-decoration-none border-0 shadow-sm transition" style="cursor: pointer;">
                <div class="card-body text-center py-4">
                    <div style="font-size: 2.5rem; margin-bottom: 10px;">👥</div>
                    <h5 class="card-title fw-bold mb-1">Manage Users</h5>
                    <p class="text-muted small">View and manage all users</p>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('admin.records') }}" class="card text-decoration-none border-0 shadow-sm transition" style="cursor: pointer;">
                <div class="card-body text-center py-4">
                    <div style="font-size: 2.5rem; margin-bottom: 10px;">📋</div>
                    <h5 class="card-title fw-bold mb-1">Medical Records</h5>
                    <p class="text-muted small">View all records system-wide</p>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('admin.activities') }}" class="card text-decoration-none border-0 shadow-sm transition" style="cursor: pointer;">
                <div class="card-body text-center py-4">
                    <div style="font-size: 2.5rem; margin-bottom: 10px;">📝</div>
                    <h5 class="card-title fw-bold mb-1">Activity Logs</h5>
                    <p class="text-muted small">Track system activities</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="card-title mb-0 fw-bold">📌 Recent Activities</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="fw-bold">User</th>
                                    <th class="fw-bold">Action</th>
                                    <th class="fw-bold">Model</th>
                                    <th class="fw-bold">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentActivities as $activity)
                                    <tr>
                                        <td><strong>{{ $activity->user?->name ?? 'System' }}</strong></td>
                                        <td>
                                            @php
                                                $badgeClass = match($activity->action) {
                                                    'created' => 'bg-success',
                                                    'updated' => 'bg-info',
                                                    'deleted' => 'bg-danger',
                                                    default => 'bg-secondary'
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ ucfirst($activity->action) }}</span>
                                        </td>
                                        <td>{{ $activity->model_type }} #{{ $activity->model_id }}</td>
                                        <td><small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">No activities recorded yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.transition { transition: all 0.3s ease; }
.card:hover { transform: translateY(-2px); box-shadow: 0 8px 16px rgba(0,0,0,0.1) !important; }
</style>
@endsection
