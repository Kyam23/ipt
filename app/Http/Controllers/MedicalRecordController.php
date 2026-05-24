<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class MedicalRecordController extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        // Require authentication for all methods
        $this->middleware('auth:web');
    }

    /**
     * Display a listing of the authenticated user's medical records.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        // Only get records belonging to the authenticated user
        $records = Auth::user()->medicalRecords()
            ->when($search, function ($query, $search) {
                $query->where('patient_name', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        return view('medical.index', compact('records', 'search'));
    }

    /**
     * Show a specific medical record.
     */
    public function show(MedicalRecord $medical_record)
    {
        // Authorize: User can only view their own records
        Gate::authorize('view', $medical_record);

        return view('medical.show', compact('medical_record'));
    }

    /**
     * Show the form for creating a new medical record.
     */
    public function create()
    {
        // Authorize: User can create records
        Gate::authorize('create', MedicalRecord::class);

        return view('medical.create');
    }

    /**
     * Store a newly created medical record.
     */
    public function store(Request $request)
    {
        // Authorize: User can create records
        Gate::authorize('create', MedicalRecord::class);

        $request->validate([
            'patient_name' => 'required|string|max:255',
            'medical_status' => 'required|string|max:255',
            'remarks' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        $fileName = $request->file('file')?->store('medical-records', 'public');

        // Create record associated with authenticated user
        Auth::user()->medicalRecords()->create([
            'patient_name' => $request->patient_name,
            'medical_status' => $request->medical_status,
            'remarks' => $request->remarks,
            'file' => $fileName,
        ]);

        return redirect()->route('medical-records.index')->with('success', 'Medical record created successfully.');
    }

    /**
     * Show the form for editing a medical record.
     */
    public function edit(MedicalRecord $medical_record)
    {
        // Authorize: User can only edit their own records
        $this->authorize('update', $medical_record);

        return view('medical.edit', compact('medical_record'));
    }

    /**
     * Update a medical record.
     */
    public function update(Request $request, MedicalRecord $medical_record)
    {
        // Authorize: User can only update their own records
        $this->authorize('update', $medical_record);

        $request->validate([
            'patient_name' => 'required|string|max:255',
            'medical_status' => 'required|string|max:255',
            'remarks' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        if ($request->hasFile('file')) {
            if ($medical_record->file && Storage::disk('public')->exists($medical_record->file)) {
                Storage::disk('public')->delete($medical_record->file);
            }
            $medical_record->file = $request->file('file')->store('medical-records', 'public');
        }

        $medical_record->update([
            'patient_name' => $request->patient_name,
            'medical_status' => $request->medical_status,
            'remarks' => $request->remarks,
            'file' => $medical_record->file,
        ]);

        return redirect()->route('medical-records.index')->with('success', 'Medical record updated successfully.');
    }

    /**
     * Delete a medical record.
     */
    public function destroy(MedicalRecord $medical_record)
    {
        // Authorize: User can only delete their own records
        $this->authorize('delete', $medical_record);

        if ($medical_record->file && Storage::disk('public')->exists($medical_record->file)) {
            Storage::disk('public')->delete($medical_record->file);
        }

        $medical_record->delete();

        return redirect()->route('medical-records.index')->with('success', 'Medical record deleted successfully.');
    }
}
