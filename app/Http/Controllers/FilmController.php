<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\WatchedFilm;
use App\Services\DelistService;
use Illuminate\Http\Request;

class FilmController
{
    public function show(Film $film)
    {
        $film->load([
            'scenes' => function ($q) {
                $q->where('verification_status', '!=', 'rejected')
                    ->orderBy('start_time_seconds', 'asc');
            },
            'scenes.submitter',
            'scenes.votes',
        ]);

        $userId = auth()->id();
        $isWatched = $userId ? WatchedFilm::where('user_id', $userId)->where('film_id', $film->id)->exists() : false;
        $hasCleanVoted = $userId ? $film->cleanVotes()->where('user_id', $userId)->exists() : false;

        $runtimeMinutes = max(1, $film->runtime_minutes);
        $runtimeSeconds = $runtimeMinutes * 60;

        // Generate ticks every 15 minutes
        $tickMinutes = [];
        for ($m = 0; $m <= $runtimeMinutes; $m += 15) {
            $tickMinutes[] = $m;
        }

        $ticks = array_map(function ($m) use ($runtimeMinutes) {
            $h = intdiv($m, 60);
            $remM = $m % 60;

            return [
                'left' => round(($m / $runtimeMinutes) * 100, 2).'%',
                'label' => sprintf('%d:%02d', $h, $remM),
            ];
        }, $tickMinutes);

        // Add exact film end tick
        $endH = intdiv($runtimeMinutes, 60);
        $endM = $runtimeMinutes % 60;
        $ticks[] = [
            'left' => '100%',
            'label' => sprintf('%d:%02d', $endH, $endM),
        ];

        $gridLines = array_map(function ($m) use ($runtimeMinutes) {
            return [
                'left' => round(($m / $runtimeMinutes) * 100, 2).'%',
            ];
        }, array_slice($tickMinutes, 1));

        // Prepare scene data for Vue timeline component
        $scenesData = $film->scenes->map(function ($scene) use ($userId, $runtimeSeconds) {
            $data = $scene->toTimelineData($userId);
            $start = $scene->start_time_seconds;
            $duration = $scene->durationSeconds();

            $data['left'] = round(($start / $runtimeSeconds) * 100, 2).'%';
            $data['width'] = max(0.8, round(($duration / $runtimeSeconds) * 100, 2)).'%';
            $data['submitter_name'] = $scene->submitter?->name ?? 'anonymous';

            return $data;
        })->values()->toArray();

        // Facts grid matching design screen 1d
        $facts = [
            ['label' => 'DIRECTOR', 'value' => $film->director ?? '—'],
            ['label' => 'RUNTIME', 'value' => $film->formattedRuntime()],
            ['label' => 'GENRE', 'value' => ! empty($film->genres) ? implode(' · ', $film->genres) : '—'],
            ['label' => 'RELEASE', 'value' => $film->releaseYear()],
            ['label' => 'CAST', 'value' => ! empty($film->cast) ? implode(', ', $film->cast) : '—'],
            ['label' => 'CLEAN VOTES', 'value' => (string) $film->clean_votes_count],
            ['label' => 'DELIST STATUS', 'value' => strtoupper($film->delist_status)],
            ['label' => 'TMDB ID', 'value' => "ID {$film->tmdb_id}"],
        ];

        // Similar films
        $similar = Film::active()
            ->where('id', '!=', $film->id)
            ->limit(4)
            ->get();

        return view('films.show', compact(
            'film',
            'isWatched',
            'hasCleanVoted',
            'facts',
            'ticks',
            'gridLines',
            'scenesData',
            'runtimeSeconds',
            'similar'
        ));
    }

    public function cleanVote(Request $request, Film $film, DelistService $delistService)
    {
        if (! auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => __('messages.login_required'),
            ], 401);
        }

        $result = $delistService->recordCleanVote($film, auth()->user());

        if ($request->wantsJson()) {
            return response()->json($result);
        }

        return back()->with($result['success'] ? 'success' : 'error', $result['message']);
    }

    public function toggleWatched(Request $request, Film $film)
    {
        if (! auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => __('messages.login_required'),
            ], 401);
        }

        $userId = auth()->id();
        $existing = WatchedFilm::where('user_id', $userId)->where('film_id', $film->id)->first();

        if ($existing) {
            $existing->delete();
            $watched = false;
        } else {
            WatchedFilm::create([
                'user_id' => $userId,
                'film_id' => $film->id,
            ]);
            $watched = true;
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'watched' => $watched,
            ]);
        }

        return back()->with('success', $watched ? __('messages.marked_watched') : __('messages.unmarked_watched'));
    }
}
