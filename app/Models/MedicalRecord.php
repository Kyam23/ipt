<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'patient_name',
        'medical_status',
        'remarks',
        'file',
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Boot method to handle model events
     */
    protected static function boot()
    {
        parent::boot();

        // Log when created (only if authenticated and not in CLI)
        static::created(function ($model) {
            try {
                if (auth()->check() && !app()->runningInConsole()) {
                    ActivityLog::log('created', $model);
                }
            } catch (\Exception $e) {
                // Silently fail to prevent login issues
            }
        });

        // Log when updated (only if authenticated and not in CLI)
        static::updated(function ($model) {
            try {
                if (auth()->check() && !app()->runningInConsole()) {
                    ActivityLog::log('updated', $model);
                }
            } catch (\Exception $e) {
                // Silently fail to prevent login issues
            }
        });

        // Log when deleted (only if authenticated and not in CLI)
        static::deleted(function ($model) {
            try {
                if (auth()->check() && !app()->runningInConsole()) {
                    ActivityLog::log('deleted', $model);
                }
            } catch (\Exception $e) {
                // Silently fail to prevent login issues
            }
        });
    }
}
