@extends('layouts.app')

@section('title', 'Medical Records Dashboard')

@section('content')

<div class="page-header">
    <div class="page-header-content">
        <h1>Your Medical Dashboard</h1>
        <p class="page-subtitle">Logged in as: <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->email }})</p>
        <p class="page-subtitle" style="font-size: 13px; color: #6b7280; margin-top: 4px;">View and manage your own medical records</p>
    </div>
    <div class="page-header-action">
        <a href="{{ route('medical-records.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Record
        </a>
    </div>
</div>

<!-- Metrics Section -->
<div class="metric-container">
    <div class="metric-card info">
        <div class="metric-header">
            <div class="metric-label">Your Records</div>
            <div class="metric-icon">📊</div>
        </div>
        <div class="metric-value">{{ $records->count() }}</div>
        <div class="metric-subtitle">Personal medical records</div>
    </div>

    <div class="metric-card fit">
        <div class="metric-header">
            <div class="metric-label">Fit Status</div>
            <div class="metric-icon">✅</div>
        </div>
        <div class="metric-value">{{ $records->where('medical_status', 'Fit')->count() }}</div>
        <div class="metric-subtitle">{{ number_format(($records->where('medical_status', 'Fit')->count() / max($records->count(), 1)) * 100, 0) }}% of your records</div>
    </div>

    <div class="metric-card warning">
        <div class="metric-header">
            <div class="metric-label">Attention Needed</div>
            <div class="metric-icon">⚠️</div>
        </div>
        <div class="metric-value">{{ $records->where('medical_status', 'Not Fit')->count() }}</div>
        <div class="metric-subtitle">Requires follow-up</div>
    </div>

    <div class="metric-card">
        <div class="metric-header">
            <div class="metric-label">Documented</div>
            <div class="metric-icon">📁</div>
        </div>
        <div class="metric-value">{{ $records->whereNotNull('file')->count() }}</div>
        <div class="metric-subtitle">With attached files</div>
    </div>
</div>

<!-- Main Records Card -->
<div class="card">
    <div class="card-title">
        <span class="card-title-icon">📋</span>
        Your Personal Medical Records
    </div>

    <!-- Search Section -->
    <div class="search-bar">
        <form method="GET" style="display: flex; gap: 12px; flex: 1;">
            <input type="text" name="search" value="{{ old('search', $search ?? '') }}" placeholder="🔍 Search your records by name..." style="flex: 1; min-width: 250px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Search
            </button>
            @if($search)
                <a href="{{ route('medical-records.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Clear
                </a>
            @endif
        </form>
    </div>

    @if ($records->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">📭</div>
            <p class="empty-text">You haven't added any medical records yet</p>
            <a href="{{ route('medical-records.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Your First Record
            </a>
        </div>
    @else
        <div style="overflow-x: auto;">
            <table class="records-table">
                <thead>
                    <tr>
                        <th style="width: 25%;">Patient Name</th>
                        <th style="width: 18%;">Medical Status</th>
                        <th style="width: 30%;">Remarks</th>
                        <th style="width: 12%;">Document</th>
                        <th style="width: 15%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($records as $record)
                        <tr>
                            <td>
                                <strong style="color: #0f3460;">{{ $record->patient_name }}</strong>
                                <br>
                                <span style="color: #9ca3af; font-size: 12px;">ID: #{{ $record->id }}</span>
                            </td>
                            <td>
                                <span class="status-badge @if($record->medical_status === 'Fit') status-fit @else status-not-fit @endif">
                                    @if($record->medical_status === 'Fit')
                                        <i class="fas fa-check-circle"></i> {{ $record->medical_status }}
                                    @else
                                        <i class="fas fa-exclamation-circle"></i> {{ $record->medical_status }}
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span style="color: #6b7280; font-size: 13px;">
                                    {{ $record->remarks ? Str::limit($record->remarks, 60) : '—' }}
                                </span>
                            </td>
                            <td>
                                @if($record->file)
                                    <a href="{{ asset('storage/'.$record->file) }}" target="_blank" rel="noopener" style="color: #0099cc; text-decoration: none; font-weight: 600; font-size: 13px;">
                                        <i class="fas fa-file-download"></i> View File
                                    </a>
                                @else
                                    <span style="color: #d1d5db; font-size: 13px;">No file</span>
                                @endif
                            </td>
                            <td>
                                <div class="actions-cell">
                                    <a href="{{ route('medical-records.show', $record->id) }}" class="action-link action-edit" title="View">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="{{ route('medical-records.edit', $record->id) }}" class="action-link action-edit" title="Edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('medical-records.destroy', $record->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-link action-delete" title="Delete">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
