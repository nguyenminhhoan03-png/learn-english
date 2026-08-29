<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Vocabulary Lexicon
        Schema::create('vocabulary', function (Blueprint $table) {
            $table->id();
            $table->string('word', 100)->unique();
            $table->string('phonetic_us', 100)->nullable();
            $table->string('phonetic_uk', 100)->nullable();
            $table->string('audio_us')->nullable();
            $table->string('audio_uk')->nullable();
            $table->string('part_of_speech', 50)->nullable();
            $table->text('definition_vi');
            $table->text('definition_en')->nullable();
            $table->text('example_sentence')->nullable();
            $table->json('word_family')->nullable();
            $table->json('collocations')->nullable();
            $table->timestamps();
        });

        // 2. User Flashcards (SuperMemo SM-2)
        Schema::create('user_flashcards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('vocab_id')->constrained('vocabulary')->cascadeOnDelete();
            $table->text('custom_note')->nullable();
            $table->text('context_sentence')->nullable();
            $table->unsignedInteger('repetitions')->default(0);
            $table->decimal('ease_factor', 4, 2)->default(2.50);
            $table->unsignedInteger('interval_days')->default(1);
            $table->date('next_review_at');
            $table->timestamps();

            $table->unique(['user_id', 'vocab_id']);
            $table->index(['user_id', 'next_review_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_flashcards');
        Schema::dropIfExists('vocabulary');
    }
};
