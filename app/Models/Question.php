<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'question_number',
        'content',
        'correct_answer',
        'options',
        'evidence_paragraph',
        'linearthinking_structure',
        'linearthinking_logic',
        'paraphrase_table',
    ];

    protected function casts(): array
    {
        return [
            'question_number' => 'integer',
            'options' => 'array',
            'paraphrase_table' => 'array',
        ];
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(QuestionGroup::class, 'group_id');
    }

    public function userAnswers(): HasMany
    {
        return $this->hasMany(UserAnswer::class, 'question_id');
    }
}
