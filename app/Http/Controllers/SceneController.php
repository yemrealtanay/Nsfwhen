<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Scene;
use App\Models\SceneVote;
use App\Services\ReputationService;
use Illuminate\Http\Request;

class SceneController
{
    public function store(Request $request, Film $film)
    {
        if (! auth()->check()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        // Strict validation: start time, end time, category only. No comment or description.
        $validated = $request->validate([
            'start_time' => ['required'],
            'end_time' => ['required'],
            'category' => ['required', 'in:sex_scene,nudity,suggestive'],
        ]);

        $startSeconds = is_numeric($validated['start_time'])
            ? (int) $validated['start_time']
            : Scene::parseTimestamp($validated['start_time']);

        $endSeconds = is_numeric($validated['end_time'])
            ? (int) $validated['end_time']
            : Scene::parseTimestamp($validated['end_time']);

        if ($startSeconds < 0) {
            return response()->json(['message' => 'Start time must be positive.'], 422);
        }

        if ($endSeconds <= $startSeconds) {
            return response()->json(['message' => 'End time must be greater than start time.'], 422);
        }

        $filmRuntimeSeconds = $film->runtime_minutes * 60;
        if ($filmRuntimeSeconds > 0 && $startSeconds > $filmRuntimeSeconds) {
            return response()->json(['message' => 'Timestamp cannot exceed movie runtime.'], 422);
        }

        $scene = Scene::create([
            'film_id' => $film->id,
            'start_time_seconds' => $startSeconds,
            'end_time_seconds' => $endSeconds,
            'category' => $validated['category'],
            'submitted_by' => auth()->id(),
            'verification_status' => 'unverified',
        ]);

        $film->update(['last_submission_at' => now()]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('messages.scene_added_success'),
                'scene' => $scene->toTimelineData(auth()->id()),
            ], 201);
        }

        return back()->with('success', __('messages.scene_added_success'));
    }

    public function vote(Request $request, Scene $scene, ReputationService $reputationService)
    {
        if (! auth()->check()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $validated = $request->validate([
            'vote_type' => ['required', 'in:confirm,dispute'],
        ]);

        $voteType = $validated['vote_type'];
        $userId = auth()->id();

        $existing = SceneVote::where('scene_id', $scene->id)
            ->where('user_id', $userId)
            ->first();

        if ($existing) {
            if ($existing->vote_type === $voteType) {
                // Toggle off
                $existing->delete();
                $currentVote = null;
            } else {
                $existing->update(['vote_type' => $voteType]);
                $currentVote = $voteType;
            }
        } else {
            $newVote = SceneVote::create([
                'scene_id' => $scene->id,
                'user_id' => $userId,
                'vote_type' => $voteType,
            ]);
            $currentVote = $voteType;

            // If scene is verified and vote is confirm, award reputation
            if ($scene->verification_status === 'verified' && $voteType === 'confirm') {
                $reputationService->awardForConfirmedVote($newVote);
            }
        }

        $confirmCount = $scene->confirmVotesCount();
        $disputeCount = $scene->disputeVotesCount();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'user_vote' => $currentVote,
                'confirm_votes' => $confirmCount,
                'dispute_votes' => $disputeCount,
            ]);
        }

        return back()->with('success', __('messages.vote_recorded'));
    }
}
