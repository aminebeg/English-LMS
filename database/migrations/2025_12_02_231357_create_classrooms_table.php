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
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('course_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('slug')->unique();
            $table->string('join_code', 8)->unique();
            $table->integer('max_participants')->default(50);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_public')->default(true);
            $table->dateTime('scheduled_at')->nullable();
            $table->integer('duration_minutes')->nullable();
            $table->enum('status', ['scheduled', 'live', 'ended'])->default('scheduled');
            $table->json('settings')->nullable(); // video/audio defaults, recording settings
            $table->timestamps();
            
            $table->index('teacher_id');
            $table->index('course_id');
            $table->index('status');
            $table->index('join_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
