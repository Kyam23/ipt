<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('patient_name');
            $table->string('medical_status');
            $table->text('remarks')->nullable();

            $table->string('file')->nullable();

            $table->timestamps();
        });
        
    }

   
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
