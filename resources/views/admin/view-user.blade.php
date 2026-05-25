@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-5 fw-bold">👤 User Profile</h1>
            <p class="text-muted">View user details and activity</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">← Back to Users</a>
        </div>
    </div>

    <!-- User Info Card -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid #0d6efd;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="fw-bold mb-2">{{ $user->name }}</h4>
                            <p class="mb-2"><code class="text-muted">{{ $user->email }}</code></p>
                            <p class="mb-0">
                                @if($user->isAdmin())
                                    <span class="badge bg-danger"><i class="fas fa-shield-alt"></i> Admin User</span>
                                @else
                                    <span class="badge bg-secondary"><i class="fas fa-user"></i> Regular User</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 text-end">
                            @if($user->isAdmin())
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.remove-admin', $user) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-warning" onclick="return confirm('Remove admin privileges?')"><i class="fas fa-times"></i> Remove Admin</button>
                                    </form>
                                @else
                                    <span class="badge bg-success py-2 px-3"><i class="fas fa-check"></i> You Are Here</span>
                                @endif
                            @else
                                <form method="POST" action="{{ route('admin.make-admin', $user) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success"><i class="fas fa-star"></i> Make Admin</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <div style="font-size: 2rem; margin-bottom: 10px;">📋</div>
                    <h6 class="text-muted text-uppercase fw-bold mb-2" style="font-size: 0.75rem;">Medical Records</h6>
                    <h2 class="fw-bold text-primary">{{ $records->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <div style="font-size: 2rem; margin-bottom: 10px;">📝</div>
                    <h6 class="text-muted text-uppercase fw-bold mb-2" style="font-size: 0.75rem;">Activities</h6>
                    <h2 class="fw-bold text-success">{{ $activities->count() }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <div style="font-size: 2rem; margin-bottom: 10px;">⏰</div>
                    <h6 class="text-muted text-uppercase fw-bold mb-2" style="font-size: 0.75rem;">Member Since</h6>
                    <p class="mb-0"><strong>{{ $user->created_at->format('M d, Y') }}</strong></p>
                </div>
            </div>
        </div>
    </div>

    <!-- User's Medical Records -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="card-title mb-0 fw-bold">📋 Medical Records ({{ $records->count() }})</h5>
                </div>
                <div class="card-body p-0">
                    @if($records->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-bold">Patient Name</th>
                                        <th class="fw-bold">Medical Status</th>
                                        <th class="fw-bold">Created</th>
                                        <th class="fw-bold text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($records as $record)
                                        <tr>
                                            <td><strong>{{ $record->patient_name }}</strong></td>
                                            <td><span class="badge bg-info">{{ $record->medical_status }}</span></td>
                                            <td><small class="text-muted">{{ $record->created_at->format('M d, Y H:i') }}</small></td>
                                            <td class="text-center">
                                                <a href="{{ route('medical-records.show', $record) }}" class="btn btn-sm btn-outline-primary" title="View"><i class="fas fa-eye"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-4 text-center text-muted">
                            <p class="mb-0"><i class="fas fa-inbox"></i> This user has no medical records</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- User's Activity Log -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="card-title mb-0 fw-bold">📝 Recent Activities (Last 20)</h5>
                </div>
                <div class="card-body p-0">
                    @if($activities->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-bold">Action</th>
                                        <th class="fw-bold">Model</th>
                                        <th class="fw-bold">Timestamp</th>
                                        <th class="fw-bold">IP Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activities as $activity)
                                        <tr>
                                            <td>
                                                @php
                                                    $badgeClass = match($activity->action) {
                                                        'created' => 'bg-success',
                                                        'updated' => 'bg-info',
                                                        'deleted' => 'bg-danger',
                                                        default => 'bg-dark'
                                                    };
                                                    $icon = match($activity->action) {
                                                        'created' => 'fa-plus',
                                                        'updated' => 'fa-edit',
                                                        'deleted' => 'fa-trash',
                                                        default => 'fa-circle'
                                                    };
                                                @endphp
                                                <span class="badge {{ $badgeClass }}"><i class="fas {{ $icon }}"></i> {{ ucfirst($activity->action) }}</span>
                                            </td>
                                            <td><code class="text-dark">{{ $activity->model_type }}</code> #{{ $activity->model_id }}</td>
                                            <td><small class="text-muted">{{ $activity->created_at->format('M d, Y H:i:s') }}</small></td>
                                            <td><small class="text-monospace text-muted">{{ $activity->ip_address ?? 'N/A' }}</small></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-4 text-center text-muted">
                            <p class="mb-0"><i class="fas fa-inbox"></i> No activities recorded</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
