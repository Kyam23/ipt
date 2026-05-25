<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MedicalRecord;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Constructor - require authentication and admin role
     */
    public function __construct()
    {
        $this->middleware('auth:web');
        $this->middleware('check.admin');
    }

    /**
     * Display admin dashboard with statistics
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalRecords = MedicalRecord::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('totalUsers', 'totalRecords', 'totalAdmins', 'recentActivities'));
    }

    /**
     * Display all users
     */
    public function users(Request $request)
    {
        $search = $request->query('search');
        
        $users = User::when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(15);

        return view('admin.users', compact('users', 'search'));
    }

    /**
     * Display all medical records
     */
    public function records(Request $request)
    {
        $search = $request->query('search');
        
        $records = MedicalRecord::with('user')
            ->when($search, function ($query, $search) {
                $query->where('patient_name', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
            })
            ->latest()
            ->paginate(15);

        return view('admin.records', compact('records', 'search'));
    }

    /**
     * Display activity logs
     */
    public function activities(Request $request)
    {
        $modelType = $request->query('model_type');
        $action = $request->query('action');
        
        $activities = ActivityLog::with('user')
            ->when($modelType, function ($query, $modelType) {
                $query->where('model_type', $modelType);
            })
            ->when($action, function ($query, $action) {
                $query->where('action', $action);
            })
            ->latest()
            ->paginate(20);

        return view('admin.activities', compact('activities', 'modelType', 'action'));
    }

    /**
     * Make a user admin
     */
    public function makeAdmin(User $user)
    {
        $user->update(['role' => 'admin']);
        
        return redirect()->route('admin.users')->with('success', $user->name . ' is now an admin.');
    }

    /**
     * Remove admin from user
     */
    public function removeAdmin(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'You cannot remove your own admin role.');
        }

        $user->update(['role' => 'user']);
        
        return redirect()->route('admin.users')->with('success', $user->name . ' is no longer an admin.');
    }

    /**
     * View user details
     */
    public function viewUser(User $user)
    {
        $records = $user->medicalRecords()->latest()->get();
        $activities = ActivityLog::where('user_id', $user->id)->latest()->limit(20)->get();

        return view('admin.view-user', compact('user', 'records', 'activities'));
    }

    /**
     * Delete medical record (admin)
     */
    public function deleteRecord(MedicalRecord $record)
    {
        $record->delete();

        return redirect()->route('admin.records')->with('success', 'Medical record permanently deleted.');
    }
}
