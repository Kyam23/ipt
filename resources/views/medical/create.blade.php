@extends('layouts.app')

@section('title', 'Add Medical Record')

@section('content')

<div class="page-header">
    <div class="page-header-content">
        <h1>Add Medical Record</h1>
        <p class="page-subtitle">Create a new student medical record</p>
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
    <form method="POST" action="{{ route('medical-records.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="patient_name" class="form-label">
                <i class="fas fa-user-md" style="margin-right: 6px;"></i>Patient Name <span style="color: #ef4444;">*</span>
            </label>
            <input type="text" id="patient_name" name="patient_name" class="form-input" value="{{ old('patient_name') }}" placeholder="Enter patient name" required>
        </div>

        <div class="form-group">
            <label for="medical_status" class="form-label">
                <i class="fas fa-clipboard-check" style="margin-right: 6px;"></i>Medical Status <span style="color: #ef4444;">*</span>
            </label>
            <select id="medical_status" name="medical_status" class="form-select" required>
                <option value="">-- Select Status --</option>
                <option value="Fit" {{ old('medical_status') === 'Fit' ? 'selected' : '' }}>✅ Fit</option>
                <option value="Not Fit" {{ old('medical_status') === 'Not Fit' ? 'selected' : '' }}>⚠️ Not Fit</option>
            </select>
        </div>

        <div class="form-group">
            <label for="remarks" class="form-label">
                <i class="fas fa-sticky-note" style="margin-right: 6px;"></i>Remarks & Notes
            </label>
            <textarea id="remarks" name="remarks" class="form-textarea" placeholder="Add any relevant medical remarks, observations, or notes...">{{ old('remarks') }}</textarea>
        </div>

        <div class="form-group">
            <label for="file" class="form-label">
                <i class="fas fa-file-upload" style="margin-right: 6px;"></i>Upload Medical Document
            </label>
            <input type="file" id="file" name="file" class="form-input" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
            <small style="color: #6b7280; display: block; margin-top: 8px;">
                <i class="fas fa-info-circle" style="margin-right: 4px;"></i>Max file size: 5MB • Formats: PDF, JPG, PNG, DOC, DOCX
            </small>
        </div>

        <div class="button-group">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Record
            </button>
            <a href="{{ route('medical-records.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Cancel
            </a>
        </div>
    </form>
</div>

@endsection
