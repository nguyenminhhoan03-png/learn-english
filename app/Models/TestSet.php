<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestSet extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'thumbnail',
        'description',
        'is_free',
        'total_tests',
    ];

    protected function casts(): array
    {
        return [
            'is_free' => 'boolean',
            'total_tests' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TestCategory::class, 'category_id');
    }

    public function tests(): HasMany
    {
        return $this->hasMany(Test::class, 'test_set_id')->orderBy('id', 'asc');
    }
}
