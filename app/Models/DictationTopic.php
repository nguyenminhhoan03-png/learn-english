<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DictationTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'level',
        'category',
        'audio_url',
        'duration_seconds',
        'thumbnail',
        'total_sentences',
    ];

    protected function casts(): array
    {
        return [
            'duration_seconds' => 'integer',
            'total_sentences' => 'integer',
        ];
    }

    public function sentences(): HasMany
    {
        return $this->hasMany(DictationSentence::class, 'topic_id')->orderBy('sentence_order', 'asc');
    }

    public function userProgress(): HasMany
    {
        return $this->hasMany(UserDictationProgress::class, 'topic_id');
    }
}
