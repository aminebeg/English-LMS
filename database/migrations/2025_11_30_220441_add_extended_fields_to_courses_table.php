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
        Schema::table('courses', function (Blueprint $table) {
            // Media
            $table->string('thumbnail')->nullable()->after('title');
            $table->string('preview_video')->nullable()->after('thumbnail');
            
            // Organization
            $table->string('category')->nullable()->after('type');
            $table->json('tags')->nullable()->after('category');
            
            // Course Details
            $table->integer('duration_weeks')->nullable()->after('level');
            $table->integer('estimated_hours')->nullable()->after('duration_weeks');
            $table->json('learning_outcomes')->nullable()->after('description');
            $table->json('prerequisites')->nullable()->after('learning_outcomes');
            $table->text('instructor_bio')->nullable()->after('prerequisites');
            
            // Pricing & Promotions
            $table->decimal('original_price', 8, 2)->nullable()->after('price');
            $table->integer('discount_percentage')->default(0)->after('original_price');
            $table->boolean('has_payment_plan')->default(false)->after('discount_percentage');
            
            // Features
            $table->boolean('is_featured')->default(false)->after('is_published');
            $table->boolean('has_certificate')->default(true)->after('is_featured');
            $table->string('certificate_template')->nullable()->after('has_certificate');
            $table->integer('max_students')->nullable()->after('certificate_template');
            $table->string('language')->default('English')->after('max_students');
            $table->enum('difficulty', ['beginner', 'intermediate', 'advanced', 'expert'])->nullable()->after('language');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn([
                'thumbnail',
                'preview_video',
                'category',
                'tags',
                'duration_weeks',
                'estimated_hours',
                'learning_outcomes',
                'prerequisites',
                'instructor_bio',
                'original_price',
                'discount_percentage',
                'has_payment_plan',
                'is_featured',
                'has_certificate',
                'certificate_template',
                'max_students',
                'language',
                'difficulty'
            ]);
        });
    }
};
