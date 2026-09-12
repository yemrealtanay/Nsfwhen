<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'reputation_score',
        'is_editor',
        'preferred_genres',
        'locale',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_editor' => 'boolean',
            'preferred_genres' => 'array',
            'reputation_score' => 'integer',
        ];
    }

    public function scenes(): HasMany
    {
        return $this->hasMany(Scene::class, 'submitted_by');
    }

    public function reviewedScenes(): HasMany
    {
        return $this->hasMany(Scene::class, 'reviewed_by');
    }

    public function sceneVotes(): HasMany
    {
        return $this->hasMany(SceneVote::class);
    }

    public function cleanVotes(): HasMany
    {
        return $this->hasMany(CleanVote::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    public function watchedFilms(): HasMany
    {
        return $this->hasMany(WatchedFilm::class);
    }

    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
            ->withPivot('earned_at')
            ->withTimestamps();
    }

    public function isEditor(): bool
    {
        return (bool) $this->is_editor;
    }

    public function isTrusted(): bool
    {
        return $this->is_editor || $this->reputation_score >= 100;
    }

    public function reputationLevel(): int
    {
        $score = $this->reputation_score;
        if ($score >= 3000) {
            return 5;
        }
        if ($score >= 2000) {
            return 4;
        }
        if ($score >= 1000) {
            return 3;
        }
        if ($score >= 100) {
            return 2;
        }

        return 1;
    }

    public function reputationLevelTitle(): string
    {
        $level = $this->reputationLevel();

        return match ($level) {
            5 => __('messages.level_5_title'),
            4 => __('messages.level_4_title'),
            3 => __('messages.level_3_title'),
            2 => __('messages.level_2_title'),
            default => __('messages.level_1_title'),
        };
    }

    public function nextLevelThreshold(): int
    {
        $score = $this->reputation_score;
        if ($score >= 3000) {
            return 5000;
        }
        if ($score >= 2000) {
            return 3000;
        }
        if ($score >= 1000) {
            return 2000;
        }
        if ($score >= 100) {
            return 1000;
        }

        return 100;
    }
}
