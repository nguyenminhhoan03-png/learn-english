<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role',
        'target_band',
        'streak_count',
        'last_study_date',
        'xp_points',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_study_date' => 'date',
            'target_band' => 'decimal:1',
            'streak_count' => 'integer',
            'xp_points' => 'integer',
            'password' => 'hashed',
        ];
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(TestSubmission::class);
    }

    public function flashcards(): HasMany
    {
        return $this->hasMany(UserFlashcard::class);
    }

    public function dictationProgress(): HasMany
    {
        return $this->hasMany(UserDictationProgress::class);
    }

    public function studyLogs(): HasMany
    {
        return $this->hasMany(UserStudyLog::class);
    }

    public function aiEvaluations(): HasMany
    {
        return $this->hasMany(AiWritingEvaluation::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
