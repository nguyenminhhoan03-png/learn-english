<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDictationProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'topic_id',
        'completed_sentences',
        'accuracy_percentage',
        'is_finished',
    ];

    protected function casts(): array
    {
        return [
            'completed_sentences' => 'integer',
            'accuracy_percentage' => 'decimal:2',
            'is_finished' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(DictationTopic::class, 'topic_id');
    }
}
