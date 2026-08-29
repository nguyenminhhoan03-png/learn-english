<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_set_id',
        'title',
        'slug',
        'type',
        'duration_minutes',
        'total_questions',
        'views_count',
    ];

    protected function casts(): array
    {
        return [
            'duration_minutes' => 'integer',
            'total_questions' => 'integer',
            'views_count' => 'integer',
        ];
    }

    public function testSet(): BelongsTo
    {
        return $this->belongsTo(TestSet::class, 'test_set_id');
    }

    public function sections(): HasMany
    {
        return $this->hasMany(TestSection::class, 'test_id')->orderBy('section_number', 'asc');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(TestSubmission::class, 'test_id');
    }
}
