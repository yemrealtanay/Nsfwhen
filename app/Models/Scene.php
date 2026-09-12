<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Scene extends Model
{
    use HasFactory;

    protected $fillable = [
        'film_id',
        'start_time_seconds',
        'end_time_seconds',
        'category',
        'submitted_by',
        'verification_status',
        'reviewed_by',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'start_time_seconds' => 'integer',
            'end_time_seconds' => 'integer',
            'reviewed_at' => 'datetime',
        ];
    }

    public function film(): BelongsTo
    {
        return $this->belongsTo(Film::class);
    }

    public function submitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(SceneVote::class);
    }

    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function durationSeconds(): int
    {
        return max(1, $this->end_time_seconds - $this->start_time_seconds);
    }

    public static function formatTimestamp(int $seconds): string
    {
        $h = intdiv($seconds, 3600);
        $m = intdiv($seconds % 3600, 60);
        $s = $seconds % 60;

        return sprintf('%02d:%02d:%02d', $h, $m, $s);
    }

    public static function parseTimestamp(string $input): int
    {
        $parts = array_map('intval', explode(':', trim($input)));
        if (count($parts) === 3) {
            return ($parts[0] * 3600) + ($parts[1] * 60) + $parts[2];
        }
        if (count($parts) === 2) {
            return ($parts[0] * 60) + $parts[1];
        }
        if (count($parts) === 1) {
            return $parts[0];
        }

        return 0;
    }

    public function startFormatted(): string
    {
        return self::formatTimestamp($this->start_time_seconds);
    }

    public function endFormatted(): string
    {
        return self::formatTimestamp($this->end_time_seconds);
    }

    public function rangeFormatted(): string
    {
        return "{$this->startFormatted()} – {$this->endFormatted()}";
    }

    public function durationFormatted(): string
    {
        $dur = $this->durationSeconds();
        $m = intdiv($dur, 60);
        $s = $dur % 60;

        return $m > 0 ? "{$m}m ".sprintf('%02d', $s).'s' : "{$s}s";
    }

    public function categoryLabel(): string
    {
        return match ($this->category) {
            'sex_scene' => __('categories.sex_scene'),
            'nudity' => __('categories.nudity'),
            'suggestive' => __('categories.suggestive'),
            default => $this->category,
        };
    }

    public function categoryColor(): string
    {
        return match ($this->category) {
            'sex_scene' => '#e05a5a',
            'nudity' => '#d98a4a',
            'suggestive' => '#d9a441',
            default => '#6a737c',
        };
    }

    public function confirmVotesCount(): int
    {
        return $this->votes()->where('vote_type', 'confirm')->count();
    }

    public function disputeVotesCount(): int
    {
        return $this->votes()->where('vote_type', 'dispute')->count();
    }

    public function toTimelineData(?int $currentUserId = null): array
    {
        $confirmCount = $this->confirmVotesCount();
        $disputeCount = $this->disputeVotesCount();
        $userVote = $currentUserId ? $this->votes()->where('user_id', $currentUserId)->value('vote_type') : null;

        return [
            'id' => $this->id,
            'film_id' => $this->film_id,
            'start_seconds' => $this->start_time_seconds,
            'end_seconds' => $this->end_time_seconds,
            'start_formatted' => $this->startFormatted(),
            'end_formatted' => $this->endFormatted(),
            'range' => $this->rangeFormatted(),
            'duration' => $this->durationFormatted(),
            'duration_seconds' => $this->durationSeconds(),
            'category' => $this->category,
            'category_label' => $this->categoryLabel(),
            'color' => $this->categoryColor(),
            'status' => $this->verification_status,
            'is_verified' => $this->verification_status === 'verified',
            'confirm_votes' => $confirmCount,
            'dispute_votes' => $disputeCount,
            'user_vote' => $userVote,
        ];
    }
}
