<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'instruction',
        'question_type',
        'image_url',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(TestSection::class, 'section_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'group_id')->orderBy('question_number', 'asc');
    }
}
