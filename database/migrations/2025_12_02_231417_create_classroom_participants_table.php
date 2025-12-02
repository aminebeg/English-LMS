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
        Schema::create('classroom_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classroom_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('role', ['teacher', 'student'])->default('student');
            $table->dateTime('joined_at');
            $table->dateTime('left_at')->nullable();
            $table->boolean('is_active')->default(false); // Currently in session
            $table->timestamps();
            
            $table->index(['classroom_id', 'user_id']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classroom_participants');
    }
};
