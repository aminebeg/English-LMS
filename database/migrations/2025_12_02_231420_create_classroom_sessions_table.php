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
        Schema::create('classroom_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classroom_id')->constrained()->cascadeOnDelete();
            $table->dateTime('started_at');
            $table->dateTime('ended_at')->nullable();
            $table->integer('duration_minutes')->nullable(); // Calculated
            $table->string('recording_url')->nullable();
            $table->integer('participants_count')->default(0);
            $table->json('analytics')->nullable(); // Session stats
            $table->timestamps();
            
            $table->index('classroom_id');
            $table->index('started_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classroom_sessions');
    }
};
