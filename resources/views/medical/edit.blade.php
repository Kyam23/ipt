@extends('layouts.app')

@section('title', 'Edit Medical Record')

@section('content')

<div class="page-header">
    <div class="page-header-content">
        <h1>Edit Medical Record</h1>
        <p class="page-subtitle">Update information for {{ $medical_record->patient_name }}</p>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-error">
        <div class="alert-icon"><i class="fas fa-exclamation-circle"></i></div>
        <div>
            <strong>Please fix the following errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="card" style="max-width: 700px; margin: 0 auto;">
    <form method="POST" action="{{ route('medical-records.update', $medical_record->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="patient_name" class="form-label">
                <i class="fas fa-user-md" style="margin-right: 6px;"></i>Patient Name <span style="color: #ef4444;">*</span>
            </label>
            <input type="text" id="patient_name" name="patient_name" class="form-input" value="{{ old('patient_name', $medical_record->patient_name) }}" required>
        </div>

        <div class="form-group">
            <label for="medical_status" class="form-label">
                <i class="fas fa-clipboard-check" style="margin-right: 6px;"></i>Medical Status <span style="color: #ef4444;">*</span>
            </label>
            <select id="medical_status" name="medical_status" class="form-select" required>
                <option value="">-- Select Status --</option>
                <option value="Fit" {{ old('medical_status', $medical_record->medical_status) === 'Fit' ? 'selected' : '' }}>✅ Fit</option>
                <option value="Not Fit" {{ old('medical_status', $medical_record->medical_status) === 'Not Fit' ? 'selected' : '' }}>⚠️ Not Fit</option>
            </select>
        </div>

        <div class="form-group">
            <label for="remarks" class="form-label">
                <i class="fas fa-sticky-note" style="margin-right: 6px;"></i>Remarks & Notes
            </label>
            <textarea id="remarks" name="remarks" class="form-textarea" placeholder="Add any relevant medical remarks...">{{ old('remarks', $medical_record->remarks) }}</textarea>
        </div>

        <div class="form-group">
            <label for="file" class="form-label">
                <i class="fas fa-file-upload" style="margin-right: 6px;"></i>Update Medical Document
            </label>
            <input type="file" id="file" name="file" class="form-input" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
            <small style="color: #6b7280; display: block; margin-top: 8px;">
                <i class="fas fa-info-circle" style="margin-right: 4px;"></i>Leave blank to keep current file. Max 5MB
            </small>
        </div>

        @if ($medical_record->file)
            <div class="file-preview">
                <strong><i class="fas fa-file"></i> Current Document:</strong>
                <a href="{{ asset('storage/'.$medical_record->file) }}" target="_blank" rel="noopener">
                    <i class="fas fa-download"></i> View or Download
                </a>
            </div>
        @endif

        <div class="button-group">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Record
            </button>
            <a href="{{ route('medical-records.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Cancel
            </a>
        </div>
    </form>
</div>

@endsection
