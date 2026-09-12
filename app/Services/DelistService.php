<?php

namespace App\Services;

use App\Models\CleanVote;
use App\Models\Film;
use App\Models\User;

class DelistService
{
    public const CLEAN_THRESHOLD = 5;

    public function recordCleanVote(Film $film, User $user): array
    {
        $existing = CleanVote::where('film_id', $film->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            return [
                'success' => false,
                'already_voted' => true,
                'message' => __('messages.clean_vote_already_recorded'),
            ];
        }

        CleanVote::create([
            'film_id' => $film->id,
            'user_id' => $user->id,
        ]);

        $film->increment('clean_votes_count');
        $film->refresh();

        // Check if positive threshold is reached and film has no verified scenes
        if ($film->clean_votes_count >= self::CLEAN_THRESHOLD && $film->delist_status === 'active') {
            $hasVerifiedScenes = $film->scenes()->where('verification_status', 'verified')->exists();
            if (! $hasVerifiedScenes) {
                $film->update(['delist_status' => 'delist_candidate']);
            }
        }

        return [
            'success' => true,
            'clean_votes_count' => $film->clean_votes_count,
            'message' => __('messages.clean_vote_success'),
        ];
    }

    public function confirmDelist(Film $film, User $editor): void
    {
        $film->update([
            'delist_status' => 'editor_delisted',
            'clean_confirmed_by' => $editor->id,
            'clean_confirmed_at' => now(),
        ]);
    }

    public function rejectDelist(Film $film): void
    {
        $film->update([
            'delist_status' => 'active',
        ]);
    }
}
