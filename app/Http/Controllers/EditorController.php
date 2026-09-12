<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Report;
use App\Models\Scene;
use App\Models\User;
use App\Services\DelistService;
use App\Services\ReputationService;
use Illuminate\Http\Request;

class EditorController
{
    public function index(Request $request)
    {
        $currentTab = $request->query('tab', 'pending'); // pending, reported_content, reported_users, delist_candidates

        // 1. Pending Queue: unverified scenes ordered by confirm votes descending, then created_at
        $pendingScenes = Scene::where('verification_status', 'unverified')
            ->with(['film', 'submitter', 'votes'])
            ->withCount(['votes as confirm_votes_count' => function ($q) {
                $q->where('vote_type', 'confirm');
            }])
            ->orderByDesc('confirm_votes_count')
            ->orderBy('created_at', 'asc')
            ->paginate(15, ['*'], 'pending_page');

        // 2. Reported Content Queue
        $reportedContent = Report::where('status', 'pending')
            ->where('reportable_type', Scene::class)
            ->with(['reportable.film', 'reporter'])
            ->latest()
            ->paginate(15, ['*'], 'reported_content_page');

        // 3. Reported Users Queue
        $reportedUsers = Report::where('status', 'pending')
            ->where('reportable_type', User::class)
            ->with(['reportable', 'reporter'])
            ->latest()
            ->paginate(15, ['*'], 'reported_users_page');

        // 4. Delist Candidates Queue
        $delistCandidates = Film::delistCandidates()
            ->withCount('cleanVotes')
            ->latest('updated_at')
            ->paginate(15, ['*'], 'delist_page');

        // Queue counts for sidebar
        $pendingCount = Scene::where('verification_status', 'unverified')->count();
        $reportedContentCount = Report::where('status', 'pending')->where('reportable_type', Scene::class)->count();
        $reportedUsersCount = Report::where('status', 'pending')->where('reportable_type', User::class)->count();
        $delistCandidatesCount = Film::delistCandidates()->count();

        return view('editor.dashboard', compact(
            'currentTab',
            'pendingScenes',
            'reportedContent',
            'reportedUsers',
            'delistCandidates',
            'pendingCount',
            'reportedContentCount',
            'reportedUsersCount',
            'delistCandidatesCount'
        ));
    }

    public function approveScene(Scene $scene, ReputationService $reputationService)
    {
        $scene->update([
            'verification_status' => 'verified',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        $reputationService->awardForVerifiedScene($scene);

        return back()->with('success', __('editor.mark_verified_success'));
    }

    public function rejectScene(Scene $scene, ReputationService $reputationService)
    {
        $scene->update([
            'verification_status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        $reputationService->penalizeForRejectedScene($scene);

        return back()->with('success', __('editor.mark_rejected_success'));
    }

    public function updateScene(Request $request, Scene $scene)
    {
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

        if ($endSeconds <= $startSeconds) {
            return back()->with('error', 'End time must be greater than start time.');
        }

        $scene->update([
            'start_time_seconds' => $startSeconds,
            'end_time_seconds' => $endSeconds,
            'category' => $validated['category'],
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Scene mark updated successfully.');
    }

    public function resolveReport(Request $request, Report $report)
    {
        $action = $request->input('action', 'resolve'); // resolve or dismiss

        $report->update([
            'status' => $action === 'resolve' ? 'resolved' : 'dismissed',
            'resolved_by' => auth()->id(),
            'resolved_at' => now(),
        ]);

        return back()->with('success', 'Report status updated.');
    }

    public function confirmDelist(Film $film, DelistService $delistService)
    {
        $delistService->confirmDelist($film, auth()->user());

        return back()->with('success', __('editor.film_delisted_success'));
    }

    public function rejectDelist(Film $film, DelistService $delistService)
    {
        $delistService->rejectDelist($film);

        return back()->with('success', 'Delist candidate rejected. Film remains active.');
    }
}
