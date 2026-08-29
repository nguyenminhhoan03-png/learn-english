<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vocabulary extends Model
{
    use HasFactory;

    protected $table = 'vocabulary';

    protected $fillable = [
        'word',
        'phonetic_us',
        'phonetic_uk',
        'audio_us',
        'audio_uk',
        'part_of_speech',
        'definition_vi',
        'definition_en',
        'example_sentence',
        'word_family',
        'collocations',
    ];

    protected function casts(): array
    {
        return [
            'word_family' => 'array',
            'collocations' => 'array',
        ];
    }

    public function userFlashcards(): HasMany
    {
        return $this->hasMany(UserFlashcard::class, 'vocab_id');
    }
}
