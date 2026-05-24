@extends('layouts.app')

@section('title', 'Medical Record Details')

@section('content')

<div class="page-header">
    <div class="page-header-content">
        <h1>Medical Record Details</h1>
        <p class="page-subtitle">Complete information for <strong>{{ $medical_record->patient_name }}</strong></p>
    </div>
    <div class="page-header-action">
        <a href="{{ route('medical-records.edit', $medical_record->id) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit Record
        </a>
    </div>
</div>

<div class="card" style="max-width: 900px; margin: 0 auto;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; margin-bottom: 40px;">
        <!-- Left Column -->
        <div>
            <div class="detail-section">
                <div class="detail-label"><i class="fas fa-user-md" style="margin-right: 6px;"></i>Patient Name</div>
                <div class="detail-value">{{ $medical_record->patient_name }}</div>
            </div>

            <div class="detail-section">
                <div class="detail-label"><i class="fas fa-id-card" style="margin-right: 6px;"></i>Record ID</div>
                <div class="detail-value" style="font-family: 'Courier New', monospace; color: #0099cc;">#{{ $medical_record->id }}</div>
            </div>

            <div class="detail-section">
                <div class="detail-label"><i class="fas fa-clipboard-check" style="margin-right: 6px;"></i>Medical Status</div>
                <div style="margin-top: 8px;">
                    <span class="status-badge @if($medical_record->medical_status === 'Fit') status-fit @else status-not-fit @endif">
                        @if($medical_record->medical_status === 'Fit')
                            <i class="fas fa-check-circle"></i> {{ $medical_record->medical_status }}
                        @else
                            <i class="fas fa-exclamation-circle"></i> {{ $medical_record->medical_status }}
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div>
            <div class="detail-section">
                <div class="detail-label"><i class="fas fa-calendar-alt" style="margin-right: 6px;"></i>Created Date</div>
                <div class="detail-value">{{ $medical_record->created_at->format('M d, Y') }}</div>
            </div>

            <div class="detail-section">
                <div class="detail-label"><i class="fas fa-sync-alt" style="margin-right: 6px;"></i>Last Updated</div>
                <div class="detail-value">{{ $medical_record->updated_at->format('M d, Y • h:i A') }}</div>
            </div>

            @if($medical_record->user)
                <div class="detail-section">
                    <div class="detail-label"><i class="fas fa-user" style="margin-right: 6px;"></i>Created By</div>
                    <div class="detail-value">{{ $medical_record->user->name }}</div>
                </div>
            @endif
        </div>
    </div>

    <!-- Remarks Section -->
    @if($medical_record->remarks)
        <div style="margin-top: 30px; padding-top: 30px; border-top: 1px solid #e5e7eb;">
            <div class="detail-label"><i class="fas fa-sticky-note" style="margin-right: 6px;"></i>Remarks & Notes</div>
            <div class="detail-value" style="margin-top: 12px; line-height: 1.8; color: #374151;">
                {{ $medical_record->remarks }}
            </div>
        </div>
    @endif

    <!-- File Section -->
    @if($medical_record->file)
        <div style="margin-top: 30px; padding-top: 30px; border-top: 1px solid #e5e7eb;">
            <div class="detail-label"><i class="fas fa-file-medical" style="margin-right: 6px;"></i>Medical Document</div>
            <div class="file-preview" style="margin-top: 12px;">
                <i class="fas fa-file-pdf" style="margin-right: 8px;"></i>
                <a href="{{ asset('storage/'.$medical_record->file) }}" target="_blank" rel="noopener">
                    <i class="fas fa-download"></i> Download or View File
                </a>
            </div>
        </div>
    @endif

    <!-- Action Buttons -->
    <div class="button-group" style="margin-top: 40px;">
        <a href="{{ route('medical-records.edit', $medical_record->id) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit Record
        </a>
        <a href="{{ route('medical-records.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>
</div>

@endsection
