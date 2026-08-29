<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DictationSentence extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'sentence_order',
        'audio_start_time',
        'audio_end_time',
        'original_text',
        'translation_vi',
        'phonetic_notes',
    ];

    protected function casts(): array
    {
        return [
            'sentence_order' => 'integer',
            'audio_start_time' => 'decimal:2',
            'audio_end_time' => 'decimal:2',
        ];
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(DictationTopic::class, 'topic_id');
    }
}
