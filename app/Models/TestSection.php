<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_id',
        'section_number',
        'title',
        'passage_text',
        'audio_url',
        'transcript',
        'translation_vi',
    ];

    protected function casts(): array
    {
        return [
            'section_number' => 'integer',
        ];
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function questionGroups(): HasMany
    {
        return $this->hasMany(QuestionGroup::class, 'section_id')->orderBy('id', 'asc');
    }
}
