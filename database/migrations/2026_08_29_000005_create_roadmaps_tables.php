<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('learning_roadmaps', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('ielts'); // ielts, toeic, communication, vstep
            $table->string('target_level');
            $table->integer('duration_weeks')->default(12);
            $table->string('color_theme')->default('rose'); // rose, indigo, amber, emerald, purple
            $table->string('badge_title')->nullable();
            $table->text('description');
            $table->string('thumbnail')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('roadmap_phases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('roadmap_id')->constrained('learning_roadmaps')->cascadeOnDelete();
            $table->integer('phase_number')->default(1);
            $table->string('title');
            $table->string('duration_text'); // e.g. "Tuần 1 - Tuần 4"
            $table->text('goal_description');
            $table->json('milestones')->nullable(); // Array of action items with routes & tools
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roadmap_phases');
        Schema::dropIfExists('learning_roadmaps');
    }
};
