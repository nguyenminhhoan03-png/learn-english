<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserFlashcard extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vocab_id',
        'custom_note',
        'context_sentence',
        'repetitions',
        'ease_factor',
        'interval_days',
        'next_review_at',
    ];

    protected function casts(): array
    {
        return [
            'repetitions' => 'integer',
            'ease_factor' => 'decimal:2',
            'interval_days' => 'integer',
            'next_review_at' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vocabulary(): BelongsTo
    {
        return $this->belongsTo(Vocabulary::class, 'vocab_id');
    }
}
