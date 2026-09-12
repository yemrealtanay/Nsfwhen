<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\Scene;
use App\Models\SceneVote;
use App\Models\User;

class ReputationService
{
    public function awardForVerifiedScene(Scene $scene): void
    {
        $user = $scene->submitter;
        if (! $user) {
            return;
        }

        $user->increment('reputation_score', 10);
        $this->checkBadges($user);
    }

    public function penalizeForRejectedScene(Scene $scene): void
    {
        $user = $scene->submitter;
        if (! $user) {
            return;
        }

        $newScore = max(0, $user->reputation_score - 15);
        $user->update(['reputation_score' => $newScore]);
    }

    public function awardForConfirmedVote(SceneVote $vote): void
    {
        $user = $vote->user;
        if (! $user) {
            return;
        }

        $user->increment('reputation_score', 2);
        $this->checkBadges($user);
    }

    public function checkBadges(User $user): void
    {
        $earnedBadgeKeys = $user->badges()->pluck('key')->toArray();

        // 1. First Mark: 1 approved submission
        $approvedCount = $user->scenes()->where('verification_status', 'verified')->count();
        if ($approvedCount >= 1 && ! in_array('first_mark', $earnedBadgeKeys)) {
            $this->grantBadge($user, 'first_mark');
        }

        // 2. Second Pair of Eyes: 100 confirmations
        $voteCount = $user->sceneVotes()->where('vote_type', 'confirm')->count();
        if ($voteCount >= 100 && ! in_array('second_pair_of_eyes', $earnedBadgeKeys)) {
            $this->grantBadge($user, 'second_pair_of_eyes');
        }

        // 3. Clean Sweep: 25 verified clean claims
        $cleanCount = $user->cleanVotes()->count();
        if ($cleanCount >= 25 && ! in_array('clean_sweep', $earnedBadgeKeys)) {
            $this->grantBadge($user, 'clean_sweep');
        }

        // 4. Timekeeper: 50 marks within tight timing
        if ($approvedCount >= 50 && ! in_array('timekeeper', $earnedBadgeKeys)) {
            $this->grantBadge($user, 'timekeeper');
        }

        // 5. Archivist: marked a pre-1980 film
        $hasClassic = $user->scenes()
            ->whereHas('film', function ($q) {
                $q->where('release_date', '<', '1980-01-01');
            })
            ->where('verification_status', 'verified')
            ->exists();

        if ($hasClassic && ! in_array('archivist', $earnedBadgeKeys)) {
            $this->grantBadge($user, 'archivist');
        }

        // 6. Steady hand: >= 10 submissions with high accuracy
        $rejectedCount = $user->scenes()->where('verification_status', 'rejected')->count();
        $totalReviewed = $approvedCount + $rejectedCount;
        if ($totalReviewed >= 10 && $rejectedCount === 0 && ! in_array('steady_hand', $earnedBadgeKeys)) {
            $this->grantBadge($user, 'steady_hand');
        }
    }

    protected function grantBadge(User $user, string $key): void
    {
        $badge = Badge::where('key', $key)->first();
        if ($badge) {
            $user->badges()->syncWithoutDetaching([$badge->id => ['earned_at' => now()]]);
        }
    }
}
