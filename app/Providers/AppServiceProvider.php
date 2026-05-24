<?php

namespace App\Providers;

use App\Models\MedicalRecord;
use App\Policies\MedicalRecordPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register policy
        Gate::policy(MedicalRecord::class, MedicalRecordPolicy::class);
    }
}
