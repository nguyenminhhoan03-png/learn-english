<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiWritingEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'task_type',
        'prompt',
        'user_essay',
        'overall_band',
        'band_task_response',
        'band_coherence',
        'band_lexical',
        'band_grammar',
        'detailed_feedback',
        'revised_essay',
    ];

    protected function casts(): array
    {
        return [
            'overall_band' => 'decimal:1',
            'band_task_response' => 'decimal:1',
            'band_coherence' => 'decimal:1',
            'band_lexical' => 'decimal:1',
            'band_grammar' => 'decimal:1',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
