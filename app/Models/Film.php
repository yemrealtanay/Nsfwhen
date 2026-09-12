<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Film extends Model
{
    use HasFactory;

    protected $fillable = [
        'tmdb_id',
        'title',
        'original_title',
        'poster_path',
        'release_date',
        'runtime_minutes',
        'genres',
        'director',
        'cast',
        'overview',
        'delist_status',
        'clean_votes_count',
        'clean_confirmed_by',
        'clean_confirmed_at',
        'last_submission_at',
    ];

    protected function casts(): array
    {
        return [
            'release_date' => 'date',
            'genres' => 'array',
            'cast' => 'array',
            'runtime_minutes' => 'integer',
            'clean_votes_count' => 'integer',
            'clean_confirmed_at' => 'datetime',
            'last_submission_at' => 'datetime',
        ];
    }

    public function scenes(): HasMany
    {
        return $this->hasMany(Scene::class);
    }

    public function verifiedScenes(): HasMany
    {
        return $this->hasMany(Scene::class)->where('verification_status', 'verified');
    }

    public function cleanVotes(): HasMany
    {
        return $this->hasMany(CleanVote::class);
    }

    public function cleanConfirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'clean_confirmed_by');
    }

    public function watchedBy(): HasMany
    {
        return $this->hasMany(WatchedFilm::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('delist_status', '!=', 'editor_delisted');
    }

    public function scopeDelistCandidates(Builder $query): Builder
    {
        return $query->where('delist_status', 'delist_candidate');
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (blank($term)) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
                ->orWhere('original_title', 'like', "%{$term}%")
                ->orWhere('director', 'like', "%{$term}%");
        });
    }

    public function releaseYear(): string
    {
        return $this->release_date ? $this->release_date->format('Y') : '—';
    }

    public function formattedRuntime(): string
    {
        $mins = $this->runtime_minutes;
        if ($mins <= 0) {
            return '—';
        }
        $h = intdiv($mins, 60);
        $m = $mins % 60;

        return "{$h}h ".str_pad($m, 2, '0', STR_PAD_LEFT)."m ({$mins} min)";
    }

    public function shortRuntime(): string
    {
        $mins = $this->runtime_minutes;
        if ($mins <= 0) {
            return '—';
        }
        $h = intdiv($mins, 60);
        $m = $mins % 60;

        return "{$h}h".str_pad($m, 2, '0', STR_PAD_LEFT);
    }

    public function posterUrl(): ?string
    {
        if ($this->poster_path) {
            if (str_starts_with($this->poster_path, 'http')) {
                return $this->poster_path;
            }
            $base = config('tmdb.image_base_url', 'https://image.tmdb.org/t/p');

            return "{$base}/w500{$this->poster_path}";
        }

        return null;
    }

    public function getPosterUrlAttribute(): ?string
    {
        return $this->posterUrl();
    }

    public function categoryCounts(): array
    {
        $counts = [
            'sex_scene' => 0,
            'nudity' => 0,
            'suggestive' => 0,
            'total' => 0,
            'verified' => 0,
            'unverified' => 0,
        ];

        foreach ($this->scenes as $scene) {
            if ($scene->verification_status === 'rejected') {
                continue;
            }
            $counts[$scene->category] = ($counts[$scene->category] ?? 0) + 1;
            $counts['total']++;
            if ($scene->verification_status === 'verified') {
                $counts['verified']++;
            } else {
                $counts['unverified']++;
            }
        }

        return $counts;
    }

    public function intensityLevel(): int
    {
        $counts = $this->categoryCounts();
        if ($counts['sex_scene'] >= 3 || $counts['total'] >= 6) {
            return 3; // HEAVY
        }
        if ($counts['sex_scene'] >= 1 || $counts['nudity'] >= 2 || $counts['total'] >= 3) {
            return 2; // MOD
        }
        if ($counts['total'] >= 1) {
            return 1; // LIGHT
        }

        return 0; // NONE
    }

    public function intensityLabel(): string
    {
        return match ($this->intensityLevel()) {
            3 => 'HEAVY',
            2 => 'MOD',
            1 => 'LIGHT',
            default => '—',
        };
    }

    public function verdict(): array
    {
        $counts = $this->categoryCounts();

        if ($this->clean_confirmed_at !== null || ($counts['total'] === 0 && $this->clean_votes_count >= 5)) {
            return [
                'type' => 'clean',
                'label' => __('categories.clean_verified'),
                'short' => 'Clean-verified',
                'summary' => __('messages.verdict_clean_summary'),
                'color' => '#5aa469',
                'bd' => '#2e4a36',
                'bg' => '#16211a',
                'fg' => '#7cc08a',
            ];
        }

        if ($counts['sex_scene'] > 0) {
            return [
                'type' => 'sex_scene',
                'label' => __('categories.sex_scenes_present'),
                'short' => 'Sex scenes',
                'summary' => trans_choice('messages.verdict_sex_summary', $counts['sex_scene'], ['count' => $counts['sex_scene'], 'nudity' => $counts['nudity']]),
                'color' => '#e05a5a',
                'bd' => '#4a3033',
                'bg' => '#231a1b',
                'fg' => '#e8938e',
            ];
        }

        if ($counts['nudity'] > 0) {
            return [
                'type' => 'nudity',
                'label' => __('categories.nudity_present'),
                'short' => 'Nudity',
                'summary' => trans_choice('messages.verdict_nudity_summary', $counts['nudity'], ['count' => $counts['nudity']]),
                'color' => '#d98a4a',
                'bd' => '#4a3a2c',
                'bg' => '#221c18',
                'fg' => '#e0a878',
            ];
        }

        if ($counts['suggestive'] > 0) {
            return [
                'type' => 'suggestive',
                'label' => __('categories.suggestive_present'),
                'short' => 'Suggestive',
                'summary' => trans_choice('messages.verdict_suggestive_summary', $counts['suggestive'], ['count' => $counts['suggestive']]),
                'color' => '#d9a441',
                'bd' => '#4a4130',
                'bg' => '#221f1a',
                'fg' => '#e0c078',
            ];
        }

        return [
            'type' => 'unmarked',
            'label' => __('categories.unmarked'),
            'short' => 'Unmarked',
            'summary' => __('messages.verdict_unmarked_summary'),
            'color' => '#6a737c',
            'bd' => '#303740',
            'bg' => '#1b1f24',
            'fg' => '#98a0a8',
        ];
    }

    public function verdictSummary(): string
    {
        return $this->verdict()['summary'] ?? '';
    }
}
