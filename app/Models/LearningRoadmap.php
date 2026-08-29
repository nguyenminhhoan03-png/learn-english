<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LearningRoadmap extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'target_level',
        'duration_weeks',
        'color_theme',
        'badge_title',
        'description',
        'thumbnail',
        'sort_order',
    ];

    public function phases(): HasMany
    {
        return $this->hasMany(RoadmapPhase::class, 'roadmap_id')->orderBy('phase_number', 'asc');
    }
}
