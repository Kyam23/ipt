@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-5 fw-bold">👥 Manage Users</h1>
            <p class="text-muted">View and manage all users in the system</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">← Back to Dashboard</a>
        </div>
    </div>

    <!-- Search Form -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users') }}" class="row g-3">
                <div class="col-md-8">
                    <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ $search }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Search</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-light border-bottom">
            <h5 class="card-title mb-0 fw-bold">System Users ({{ $users->total() }})</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="fw-bold">Name</th>
                        <th class="fw-bold">Email</th>
                        <th class="fw-bold">Role</th>
                        <th class="fw-bold text-center">Records</th>
                        <th class="fw-bold text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td><code class="text-muted">{{ $user->email }}</code></td>
                            <td>
                                @if($user->isAdmin())
                                    <span class="badge bg-danger"><i class="fas fa-shield-alt"></i> Admin</span>
                                @else
                                    <span class="badge bg-secondary">User</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info">{{ $user->medicalRecords()->count() }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.view-user', $user) }}" class="btn btn-sm btn-outline-primary me-2"><i class="fas fa-eye"></i> View</a>
                                @if($user->isAdmin())
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.remove-admin', $user) }}" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-warning" onclick="return confirm('Remove admin privileges?')"><i class="fas fa-times"></i></button>
                                        </form>
                                    @else
                                        <span class="badge bg-success">Current User</span>
                                    @endif
                                @else
                                    <form method="POST" action="{{ route('admin.make-admin', $user) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Make Admin"><i class="fas fa-check"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
