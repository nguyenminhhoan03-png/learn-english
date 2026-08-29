<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpeakingSample extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'part',
        'topic',
        'cue_card_prompt',
        'audio_url',
        'sample_transcript',
        'linearthinking_notes',
        'useful_phrases',
    ];

    protected function casts(): array
    {
        return [
            'useful_phrases' => 'array',
        ];
    }
}
