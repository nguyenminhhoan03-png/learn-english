<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WritingSample extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'task_type',
        'chart_or_essay_type',
        'prompt',
        'image_url',
        'outline_linearthinking',
        'sample_essay',
        'band_score',
        'translation_vi',
        'key_vocab_list',
    ];

    protected function casts(): array
    {
        return [
            'band_score' => 'decimal:1',
            'key_vocab_list' => 'array',
        ];
    }
}
