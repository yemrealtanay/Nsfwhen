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
        Schema::create('scenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('film_id')->constrained('films')->cascadeOnDelete();
            $table->integer('start_time_seconds');
            $table->integer('end_time_seconds');
            $table->enum('category', ['sex_scene', 'nudity', 'suggestive']);
            $table->foreignId('submitted_by')->constrained('users')->cascadeOnDelete();
            $table->enum('verification_status', ['unverified', 'verified', 'rejected'])->default('unverified');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->index(['film_id', 'verification_status']);
            $table->index('verification_status');
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scenes');
    }
};
