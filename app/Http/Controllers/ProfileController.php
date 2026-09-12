<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\User;

class ProfileController
{
    public function show(User $user)
    {
        $user->load(['badges', 'watchedFilms.film']);

        $scenesCount = $user->scenes()->count();
        $approvedCount = $user->scenes()->where('verification_status', 'verified')->count();
        $rejectedCount = $user->scenes()->where('verification_status', 'rejected')->count();
        $pendingCount = $user->scenes()->where('verification_status', 'unverified')->count();

        $reviewedTotal = $approvedCount + $rejectedCount;
        $accuracyRate = $reviewedTotal > 0 ? round(($approvedCount / $reviewedTotal) * 100) : 100;

        $allBadges = Badge::all();
        $earnedBadgeIds = $user->badges->pluck('id')->toArray();

        $stats = [
            ['value' => (string) $scenesCount, 'label' => __('messages.scenes_marked'), 'color' => '#e6e8eb'],
            ['value' => (string) $approvedCount, 'label' => __('messages.approved'), 'color' => '#7cc08a'],
            ['value' => (string) $rejectedCount, 'label' => __('messages.rejected'), 'color' => '#e8938e'],
            ['value' => (string) $pendingCount, 'label' => __('messages.pending_review'), 'color' => '#e0c078'],
            ['value' => "{$accuracyRate}%", 'label' => __('messages.accuracy_rate'), 'color' => '#a9cdf0'],
        ];

        // Watched films list
        $watchedFilms = $user->watchedFilms()
            ->with('film')
            ->latest('watched_at')
            ->limit(18)
            ->get();

        // Recent mark history
        $recentScenes = $user->scenes()
            ->with('film')
            ->latest()
            ->limit(10)
            ->get();

        return view('profile.show', compact(
            'user',
            'stats',
            'allBadges',
            'earnedBadgeIds',
            'watchedFilms',
            'recentScenes'
        ));
    }
}
