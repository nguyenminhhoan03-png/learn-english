<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Writing Samples
        Schema::create('writing_samples', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('task_type', ['task1_academic', 'task1_general', 'task2']);
            $table->string('chart_or_essay_type', 100);
            $table->text('prompt');
            $table->string('image_url')->nullable();
            $table->longText('outline_linearthinking');
            $table->longText('sample_essay');
            $table->decimal('band_score', 2, 1)->default(8.0);
            $table->longText('translation_vi')->nullable();
            $table->json('key_vocab_list')->nullable();
            $table->timestamps();
        });

        // 2. Speaking Samples
        Schema::create('speaking_samples', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('part', ['part1', 'part2', 'part3']);
            $table->string('topic');
            $table->decimal('band_score', 2, 1)->default(8.0);
            $table->text('cue_card_prompt')->nullable();
            $table->string('audio_url')->nullable();
            $table->longText('sample_transcript');
            $table->longText('linearthinking_notes')->nullable();
            $table->json('useful_phrases')->nullable();
            $table->timestamps();
        });

        // 3. AI Writing Evaluations
        Schema::create('ai_writing_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('task_type', ['task1', 'task2']);
            $table->text('prompt');
            $table->longText('user_essay');
            $table->decimal('overall_band', 2, 1);
            $table->decimal('band_task_response', 2, 1);
            $table->decimal('band_coherence', 2, 1);
            $table->decimal('band_lexical', 2, 1);
            $table->decimal('band_grammar', 2, 1);
            $table->longText('detailed_feedback');
            $table->longText('revised_essay')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
        });

        // 4. User Study Logs (for streak and study time analytics)
        Schema::create('user_study_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('activity_type', ['test', 'dictation', 'flashcard', 'writing_ai']);
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->integer('duration_minutes')->default(5);
            $table->date('study_date');
            $table->timestamps();

            $table->index(['user_id', 'study_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_study_logs');
        Schema::dropIfExists('ai_writing_evaluations');
        Schema::dropIfExists('speaking_samples');
        Schema::dropIfExists('writing_samples');
    }
};
