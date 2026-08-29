<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoadmapPhase extends Model
{
    use HasFactory;

    protected $fillable = [
        'roadmap_id',
        'phase_number',
        'title',
        'duration_text',
        'goal_description',
        'milestones',
    ];

    protected $casts = [
        'milestones' => 'array',
    ];

    public function roadmap(): BelongsTo
    {
        return $this->belongsTo(LearningRoadmap::class, 'roadmap_id');
    }
}
