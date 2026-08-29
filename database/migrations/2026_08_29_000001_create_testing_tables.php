<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Categories
        Schema::create('test_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 2. Test Sets
        Schema::create('test_sets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('test_categories')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('thumbnail')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_free')->default(true);
            $table->integer('total_tests')->default(4);
            $table->timestamps();
        });

        // 3. Tests
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_set_id')->constrained('test_sets')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('type', ['reading', 'listening', 'full_test']);
            $table->integer('duration_minutes')->default(60);
            $table->integer('total_questions')->default(40);
            $table->unsignedInteger('views_count')->default(0);
            $table->timestamps();
        });

        // 4. Test Sections (Passages / Audio Parts)
        Schema::create('test_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_id')->constrained('tests')->cascadeOnDelete();
            $table->integer('section_number');
            $table->string('title');
            $table->longText('passage_text')->nullable();
            $table->string('audio_url')->nullable();
            $table->longText('transcript')->nullable();
            $table->longText('translation_vi')->nullable();
            $table->timestamps();

            $table->index(['test_id', 'section_number']);
        });

        // 5. Question Groups
        Schema::create('question_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('test_sections')->cascadeOnDelete();
            $table->text('instruction');
            $table->string('question_type', 50);
            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        // 6. Questions & Linearthinking Data
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('question_groups')->cascadeOnDelete();
            $table->integer('question_number');
            $table->text('content');
            $table->text('correct_answer');
            $table->json('options')->nullable();
            $table->string('evidence_paragraph', 100)->nullable();
            $table->text('linearthinking_structure')->nullable();
            $table->text('linearthinking_logic')->nullable();
            $table->json('paraphrase_table')->nullable();
            $table->timestamps();

            $table->index(['group_id', 'question_number']);
        });

        // 7. Submissions
        Schema::create('test_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('test_id')->constrained('tests')->cascadeOnDelete();
            $table->string('mode', 20)->default('full_test');
            $table->integer('score_raw')->default(0);
            $table->decimal('band_score', 2, 1)->default(0.0);
            $table->integer('time_spent_seconds')->default(0);
            $table->string('status', 20)->default('completed');
            $table->timestamps();

            $table->index(['user_id', 'test_id']);
        });

        // 8. User Answers
        Schema::create('user_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('test_submissions')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->text('user_answer')->nullable();
            $table->boolean('is_correct')->default(false);
            $table->timestamps();

            $table->index(['submission_id', 'question_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_answers');
        Schema::dropIfExists('test_submissions');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('question_groups');
        Schema::dropIfExists('test_sections');
        Schema::dropIfExists('tests');
        Schema::dropIfExists('test_sets');
        Schema::dropIfExists('test_categories');
    }
};
