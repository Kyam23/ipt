# User-Specific Medical Records Implementation Guide

## Overview

Your Student Medical Record System has been upgraded to ensure complete data isolation and security. Each authenticated user now sees and manages **only their own medical records** through a one-to-many relationship with proper authorization checks.

---

## 🔐 Security Features Implemented

### 1. Database Relationship (One-to-Many)
- ✅ Each user can have many medical records
- ✅ Each medical record belongs to exactly one user
- ✅ User ID is stored in the `medical_records` table
- ✅ Foreign key constraint enforces referential integrity

### 2. Authentication Requirements
- ✅ All medical record routes require authentication (`auth:web` middleware)
- ✅ Constructor in controller applies `$this->middleware('auth:web')`
- ✅ Unauthenticated users cannot access any medical record endpoints

### 3. Authorization Policy (MedicalRecordPolicy)
- ✅ `view()` - User can only view their own records
- ✅ `update()` - User can only edit their own records
- ✅ `delete()` - User can only delete their own records
- ✅ `create()` - All authenticated users can create records
- ✅ Policy automatically prevents cross-user access

### 4. User Filtering in Queries
- ✅ Index method uses `Auth::user()->medicalRecords()` - only user's records
- ✅ Show method uses policy authorization - verifies ownership
- ✅ Create method uses policy authorization - verified user can create
- ✅ Store method creates record with `Auth::user()->medicalRecords()->create()` - automatically assigns user_id
- ✅ Update/delete methods use policy authorization - verified user owns record

---

## 📊 Database Structure

### Medical Records Table
```sql
CREATE TABLE medical_records (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,              -- Links record to owner
    patient_name VARCHAR(255) NOT NULL,
    medical_status VARCHAR(255) NOT NULL,
    remarks TEXT NULLABLE,
    file VARCHAR(255) NULLABLE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

**Key Point:** `user_id` ensures each record belongs to exactly one user. `ON DELETE CASCADE` means if a user is deleted, their records are automatically deleted too.

---

## 💻 Model Relationships

### User Model
```php
/**
 * Get all medical records for this user.
 */
public function medicalRecords()
{
    return $this->hasMany(MedicalRecord::class);
}
```

**Usage:**
```php
// Get current user's records
$records = Auth::user()->medicalRecords()->get();

// Create a new record for current user
Auth::user()->medicalRecords()->create([
    'patient_name' => 'John Doe',
    'medical_status' => 'Fit',
]);

// Count user's records
$count = Auth::user()->medicalRecords()->count();
```

### MedicalRecord Model
```php
/**
 * Get the user who owns this record.
 */
public function user()
{
    return $this->belongsTo(User::class);
}
```

**Usage:**
```php
$record = MedicalRecord::find(1);
$owner = $record->user;  // Get the owning user
echo $record->user->name;  // Access user properties
```

---

## 🔑 Authorization Policy (MedicalRecordPolicy)

### File Location
```
app/Policies/MedicalRecordPolicy.php
```

### Policy Methods

#### 1. View Authorization
```php
public function view(User $user, MedicalRecord $medicalRecord): bool
{
    return $user->id === $medicalRecord->user_id;
}
```
- **Checks:** Does the record belong to this user?
- **Used in:** `Controller@show()` method
- **Triggers:** 403 error if unauthorized

#### 2. Update Authorization
```php
public function update(User $user, MedicalRecord $medicalRecord): bool
{
    return $user->id === $medicalRecord->user_id;
}
```
- **Checks:** Does the record belong to this user?
- **Used in:** `Controller@edit()` and `Controller@update()` methods
- **Triggers:** 403 error if unauthorized

#### 3. Delete Authorization
```php
public function delete(User $user, MedicalRecord $medicalRecord): bool
{
    return $user->id === $medicalRecord->user_id;
}
```
- **Checks:** Does the record belong to this user?
- **Used in:** `Controller@destroy()` method
- **Triggers:** 403 error if unauthorized

#### 4. Create Authorization
```php
public function create(User $user): bool
{
    return true; // All authenticated users can create
}
```
- **Checks:** Is the user authenticated?
- **Used in:** `Controller@create()` and `Controller@store()` methods
- **Result:** All logged-in users can create records

---

## 🎮 Controller Implementation

### File Location
```
app/Http/Controllers/MedicalRecordController.php
```

### Constructor (Authentication)
```php
public function __construct()
{
    // Require authentication for all methods
    $this->middleware('auth:web');
}
```
- Applies authentication to every controller method
- Redirects unauthenticated users to login

### Index Method (List Records)
```php
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
```

**Key Points:**
- Uses `Auth::user()->medicalRecords()` instead of `MedicalRecord::all()`
- Users only see their own records
- Search works only within user's records
- Latest records appear first

### Show Method (View Record)
```php
public function show(MedicalRecord $medical_record)
{
    // Authorize: User can only view their own records
    $this->authorize('view', $medical_record);

    return view('medical.show', compact('medical_record'));
}
```

**Security:**
- Policy verifies record ownership before displaying
- Returns 403 Forbidden if user doesn't own record
- Route model binding auto-retrieves record by ID

### Create Method (Display Form)
```php
public function create()
{
    // Authorize: User can create records
    $this->authorize('create', MedicalRecord::class);

    return view('medical.create');
}
```

**Security:**
- Policy verifies user is authenticated
- All logged-in users can see the form

### Store Method (Save Record)
```php
public function store(Request $request)
{
    // Authorize: User can create records
    $this->authorize('create', MedicalRecord::class);

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
```

**Key Points:**
- Authorization checked before validation
- `Auth::user()->medicalRecords()->create()` automatically sets user_id
- File stored in user-accessible storage directory
- Success message displayed after creation

### Edit & Update Methods
```php
public function edit(MedicalRecord $medical_record)
{
    // Authorize: User can only edit their own records
    $this->authorize('update', $medical_record);

    return view('medical.edit', compact('medical_record'));
}

public function update(Request $request, MedicalRecord $medical_record)
{
    // Authorize: User can only update their own records
    $this->authorize('update', $medical_record);

    // ... validation and update logic ...

    $medical_record->update([
        'patient_name' => $request->patient_name,
        'medical_status' => $request->medical_status,
        'remarks' => $request->remarks,
        'file' => $medical_record->file,
    ]);

    return redirect()->route('medical-records.index')->with('success', 'Medical record updated successfully.');
}
```

**Security:**
- Policy verifies user owns the record before editing
- Only authenticated owner can see/edit form
- File replacement with deletion of old file
- Success message confirms update

### Delete Method
```php
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
```

**Security:**
- Policy verifies user owns the record before deletion
- File cleaned up before record deletion
- Only authenticated owner can delete
- Success message confirms deletion

---

## 🔄 Data Flow Example

### Scenario: User Adds a Medical Record

```
1. User clicks "Add New Record" button
   ↓
2. GET /medical-records/create
   - MedicalRecordController@create() called
   - $this->middleware('auth:web') checks: Authenticated? ✓
   - $this->authorize('create', MedicalRecord::class) checks: Can user create? ✓
   - Form displayed
   ↓
3. User fills form and submits
   ↓
4. POST /medical-records
   - MedicalRecordController@store() called
   - $this->middleware('auth:web') checks: Authenticated? ✓
   - $this->authorize('create', MedicalRecord::class) checks: Can user create? ✓
   - Request validation: Name, Status required, File optional
   - File uploaded and stored in storage/app/public/medical-records/
   - Record created: Auth::user()->medicalRecords()->create([...])
     * user_id automatically set to Auth::id()
     * patient_name, medical_status, remarks, file stored
   - Redirect to medical-records.index with success message
```

### Scenario: User Tries to View Another User's Record (Unauthorized)

```
1. User A (ID: 1) URL-hacks: /medical-records/999
   (Record 999 belongs to User B, ID: 2)
   ↓
2. GET /medical-records/999
   - MedicalRecordController@show() called
   - $this->middleware('auth:web') checks: Authenticated? ✓
   - Route model binding retrieves Record 999
   - $this->authorize('view', $record) checks:
     * Is Auth::user()->id (1) === $record->user_id (2)? ✗
   - Laravel throws AuthorizationException
   - User gets 403 Forbidden error page
   ↓
3. Record NOT displayed, User NOT able to see data
```

---

## 📝 View Updates

### Index View (medical/index.blade.php)

**Changes Made:**
- Header now shows: "Your Medical Dashboard"
- Subtitle displays: "Logged in as: [User Name] ([Email])"
- Metrics now show "Your Records" instead of "Total Records"
- Search placeholder: "Search your records by name..."
- Empty state message: "You haven't added any medical records yet"
- Table title: "Your Personal Medical Records"

**Code:**
```blade
<div class="page-header-content">
    <h1>Your Medical Dashboard</h1>
    <p class="page-subtitle">
        Logged in as: <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->email }})
    </p>
    <p class="page-subtitle" style="font-size: 13px; color: #6b7280;">
        View and manage your own medical records
    </p>
</div>
```

**User Confirmation:**
- User sees their own name and email at the top
- Clear indication they're viewing personal records
- Cannot accidentally think they're viewing all records

---

## 🧪 Testing User Isolation

### Test 1: User Sees Only Their Records

**Steps:**
1. Register User A (alice@example.com)
2. Log in as User A
3. Add 3 medical records (Alice's records)
4. Go to medical-records index
5. **Expected:** See 3 records, all listed as "Your Records" (metric shows 3)

**Code to Test:**
```php
// In controller - verify only user's records returned
$records = Auth::user()->medicalRecords()->get();
// Result: Should be 3 records
```

### Test 2: Different User Sees Different Records

**Steps:**
1. Register User B (bob@example.com)
2. Log in as User B
3. Go to medical-records index
4. **Expected:** See 0 records (empty state), not Alice's 3 records

**Code to Test:**
```php
// In controller - verify only Bob's records returned
$records = Auth::user()->medicalRecords()->get();
// Result: Should be 0 records (empty collection)
```

### Test 3: User Cannot View Another's Record

**Steps:**
1. As User A, view record details: /medical-records/1 (Alice's record)
2. **Expected:** See details ✓
3. Log out and log in as User B
4. Try to access: /medical-records/1 (Alice's record)
5. **Expected:** Get 403 Forbidden error ✓

**Code to Test:**
```php
// In policy - verify ownership check
$this->authorize('view', $record);
// If $record->user_id !== Auth::id(), throws AuthorizationException
```

### Test 4: User Cannot Edit Another's Record

**Steps:**
1. As User A, view edit form: /medical-records/1/edit
2. **Expected:** Form displayed ✓
3. Log out and log in as User B
4. Try to access: /medical-records/1/edit
5. **Expected:** Get 403 Forbidden error ✓

### Test 5: User Cannot Delete Another's Record

**Steps:**
1. Count records: User A has 3, User B has 0
2. Manually craft DELETE request as User B to delete User A's record
3. **Expected:** 403 Forbidden ✓
4. Count again: User A still has 3 ✓

---

## 🛡️ Security Best Practices Implemented

### 1. Defense in Depth
- ✅ Middleware layer: Requires authentication
- ✅ Controller layer: Verifies authorization
- ✅ Policy layer: Checks record ownership
- ✅ Query layer: Filters by user_id

**Result:** Multiple security layers prevent unauthorized access

### 2. Database Constraints
- ✅ Foreign key: `FOREIGN KEY (user_id) REFERENCES users(id)`
- ✅ Cascade delete: Records deleted when user deleted
- ✅ NOT NULL: user_id always has value

**Result:** Data integrity maintained at database level

### 3. Authorization Over Access Control
- ✅ Uses Laravel Policy for granular authorization
- ✅ `$this->authorize()` called explicitly
- ✅ Not relying on route naming conventions

**Result:** Clear, explicit security logic

### 4. User Context Preserved
- ✅ `Auth::user()->medicalRecords()` uses authenticated user
- ✅ No manual user_id passing by user
- ✅ Cannot be manipulated by form tampering

**Result:** User cannot assign records to other users

---

## 🚀 Usage Examples

### Example 1: Create a Record via Code

```php
// Create a medical record for the authenticated user
Auth::user()->medicalRecords()->create([
    'patient_name' => 'Jane Smith',
    'medical_status' => 'Fit',
    'remarks' => 'Annual checkup passed',
]);
```

### Example 2: Get All User's Records

```php
$user = Auth::user();
$records = $user->medicalRecords()->get();

foreach ($records as $record) {
    echo $record->patient_name . ': ' . $record->medical_status;
}
```

### Example 3: Get Records with Specific Status

```php
$fitRecords = Auth::user()
    ->medicalRecords()
    ->where('medical_status', 'Fit')
    ->get();
```

### Example 4: Check if User Owns Record

```php
$record = MedicalRecord::find(1);

if (Auth::user()->id === $record->user_id) {
    echo "You own this record";
} else {
    echo "This record belongs to someone else";
}

// Or use policy directly:
if (Auth::user()->can('view', $record)) {
    echo "You can view this record";
}
```

### Example 5: Soft Delete (Optional Future Enhancement)

```php
// If you want to restore deleted records in future:
public function restore(User $user, MedicalRecord $medicalRecord): bool
{
    return $user->id === $medicalRecord->user_id;
}
```

---

## ⚠️ Common Issues and Solutions

### Issue: "This action is unauthorized" Error

**Cause:** User trying to access record they don't own

**Solution:** Check that:
1. User is logged in: `Auth::check()`
2. Record user_id matches authenticated user: `$record->user_id === Auth::id()`
3. Policy authorization returns true

**Debug Code:**
```php
dd([
    'auth_id' => Auth::id(),
    'record_user_id' => $record->user_id,
    'owns_record' => Auth::id() === $record->user_id,
]);
```

### Issue: User Sees All Records, Not Just Theirs

**Cause:** Controller still using old `MedicalRecord::all()` query

**Solution:** Change to:
```php
// WRONG ❌
$records = MedicalRecord::all();

// CORRECT ✓
$records = Auth::user()->medicalRecords()->get();
```

### Issue: Records Created Without user_id

**Cause:** Manual `MedicalRecord::create()` without user_id

**Solution:** Use relationship:
```php
// WRONG ❌
MedicalRecord::create([
    'patient_name' => 'John',
    'medical_status' => 'Fit',
]);

// CORRECT ✓
Auth::user()->medicalRecords()->create([
    'patient_name' => 'John',
    'medical_status' => 'Fit',
]);
```

---

## 📚 File Locations Reference

```
app/
├── Models/
│   ├── User.php (has medicalRecords() relationship)
│   └── MedicalRecord.php (has user() relationship)
├── Policies/
│   └── MedicalRecordPolicy.php (authorization checks)
└── Http/Controllers/
    └── MedicalRecordController.php (user-filtered CRUD)

database/
└── migrations/
    └── 2026_05_22_145052_create_medical_records_table.php
        (user_id foreign key)

resources/views/medical/
├── index.blade.php (user-specific dashboard)
├── show.blade.php
├── create.blade.php
└── edit.blade.php
```

---

## ✅ Implementation Checklist

- [x] User model has `medicalRecords()` relationship
- [x] MedicalRecord model has `user()` relationship
- [x] MedicalRecordPolicy created with authorization methods
- [x] Controller constructor adds `auth:web` middleware
- [x] index() method filters by `Auth::user()->medicalRecords()`
- [x] show() method uses `$this->authorize('view', $record)`
- [x] create() method uses `$this->authorize('create', MedicalRecord::class)`
- [x] store() method uses `Auth::user()->medicalRecords()->create()`
- [x] edit() method uses `$this->authorize('update', $record)`
- [x] update() method uses `$this->authorize('update', $record)`
- [x] destroy() method uses `$this->authorize('delete', $record)`
- [x] Views updated to show user context
- [x] Success messages added to redirects
- [x] User email/name displayed in dashboard header

---

## 🎯 Next Steps

1. **Test thoroughly** using the Testing section above
2. **Verify** all authorization checks work
3. **Check logs** for any authorization exceptions
4. **Run migrations** if starting fresh: `php artisan migrate`
5. **Clear cache** if policies not applying: `php artisan cache:clear`
6. **Test with multiple users** to confirm isolation

---

## 📞 Troubleshooting Commands

```bash
# Clear application cache
php artisan cache:clear

# Clear all caches
php artisan optimize:clear

# Run migrations (if database not updated)
php artisan migrate

# Check routes
php artisan route:list

# Test policy directly (in tinker)
php artisan tinker
# Then: $user->can('view', $record)

# View authorization attempts
tail -f storage/logs/laravel.log
```

---

**Status:** ✅ Implementation Complete  
**Date:** May 25, 2026  
**Version:** 1.0.0  

Each user now has complete isolation and security for their medical records!
