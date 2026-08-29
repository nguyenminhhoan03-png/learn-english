<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Dictation Topics
        Schema::create('dictation_topics', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('level', ['beginner', 'intermediate', 'advanced'])->default('intermediate');
            $table->string('category', 100)->default('IELTS Listening');
            $table->string('audio_url');
            $table->integer('duration_seconds')->default(0);
            $table->string('thumbnail')->nullable();
            $table->integer('total_sentences')->default(0);
            $table->timestamps();
        });

        // 2. Sentences with Timestamps
        Schema::create('dictation_sentences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained('dictation_topics')->cascadeOnDelete();
            $table->integer('sentence_order');
            $table->decimal('audio_start_time', 6, 2);
            $table->decimal('audio_end_time', 6, 2);
            $table->text('original_text');
            $table->text('translation_vi')->nullable();
            $table->text('phonetic_notes')->nullable();
            $table->timestamps();

            $table->index(['topic_id', 'sentence_order']);
        });

        // 3. User Dictation Progress
        Schema::create('user_dictation_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('topic_id')->constrained('dictation_topics')->cascadeOnDelete();
            $table->integer('completed_sentences')->default(0);
            $table->decimal('accuracy_percentage', 5, 2)->default(0.0);
            $table->boolean('is_finished')->default(false);
            $table->timestamps();

            $table->unique(['user_id', 'topic_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_dictation_progress');
        Schema::dropIfExists('dictation_sentences');
        Schema::dropIfExists('dictation_topics');
    }
};
