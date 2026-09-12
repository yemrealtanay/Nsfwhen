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
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tmdb_id')->unique();
            $table->string('title');
            $table->string('original_title')->nullable();
            $table->string('poster_path')->nullable();
            $table->date('release_date')->nullable();
            $table->integer('runtime_minutes')->default(0);
            $table->json('genres')->nullable();
            $table->string('director')->nullable();
            $table->json('cast')->nullable();
            $table->text('overview')->nullable();
            $table->enum('delist_status', ['active', 'delist_candidate', 'editor_delisted'])->default('active');
            $table->integer('clean_votes_count')->default(0);
            $table->foreignId('clean_confirmed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('clean_confirmed_at')->nullable();
            $table->timestamp('last_submission_at')->nullable();
            $table->timestamps();

            $table->index('delist_status');
            $table->index('clean_votes_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
