<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'test_id',
        'mode',
        'score_raw',
        'band_score',
        'time_spent_seconds',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'score_raw' => 'integer',
            'band_score' => 'decimal:1',
            'time_spent_seconds' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(UserAnswer::class, 'submission_id');
    }
}
