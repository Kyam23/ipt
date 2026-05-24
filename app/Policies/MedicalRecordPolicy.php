<?php

namespace App\Policies;

use App\Models\MedicalRecord;
use App\Models\User;

class MedicalRecordPolicy
{
    /**
     * Determine if the user can view the model.
     */
    public function view(User $user, MedicalRecord $medicalRecord): bool
    {
        return $user->id === $medicalRecord->user_id;
    }

    /**
     * Determine if the user can update the model.
     */
    public function update(User $user, MedicalRecord $medicalRecord): bool
    {
        return $user->id === $medicalRecord->user_id;
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $user, MedicalRecord $medicalRecord): bool
    {
        return $user->id === $medicalRecord->user_id;
    }

    /**
     * Determine if the user can create medical records.
     */
    public function create(User $user): bool
    {
        return true; // All authenticated users can create records
    }

    /**
     * Determine if the user can restore the model.
     */
    public function restore(User $user, MedicalRecord $medicalRecord): bool
    {
        return $user->id === $medicalRecord->user_id;
    }

    /**
     * Determine if the user can permanently delete the model.
     */
    public function forceDelete(User $user, MedicalRecord $medicalRecord): bool
    {
        return $user->id === $medicalRecord->user_id;
    }
}
