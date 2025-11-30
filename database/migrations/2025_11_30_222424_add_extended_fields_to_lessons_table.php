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
        Schema::table('lessons', function (Blueprint $table) {
            // Media & Content
            $table->string('video_url')->nullable()->after('content');
            $table->text('summary')->nullable()->after('video_url');
            $table->json('objectives')->nullable()->after('summary');
            $table->text('notes')->nullable()->after('objectives');
            
            // Time & Difficulty
            $table->integer('duration_minutes')->nullable()->after('notes');
            $table->enum('difficulty', ['beginner', 'intermediate', 'advanced'])->nullable()->after('duration_minutes');
            
            // Interactive Elements
            $table->json('key_points')->nullable()->after('difficulty');
            $table->json('vocabulary')->nullable()->after('key_points');
            $table->json('exercises')->nullable()->after('vocabulary');
            
            // Resources
            $table->json('resources')->nullable()->after('exercises'); // Links, PDFs, etc.
            $table->json('downloads')->nullable()->after('resources'); // File paths for downloadable content
            
            // Status
            $table->boolean('is_published')->default(true)->after('downloads');
            $table->timestamp('published_at')->nullable()->after('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn([
                'video_url',
                'summary',
                'objectives',
                'notes',
                'duration_minutes',
                'difficulty',
                'key_points',
                'vocabulary',
                'exercises',
                'resources',
                'downloads',
                'is_published',
                'published_at'
            ]);
        });
    }
};
