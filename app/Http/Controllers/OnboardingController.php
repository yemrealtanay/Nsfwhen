<?php

namespace App\Http\Controllers;

use App\Services\TmdbService;
use Illuminate\Http\Request;

class OnboardingController
{
    public function index(TmdbService $tmdbService)
    {
        $genres = $tmdbService->getGenres(app()->getLocale());
        $userGenres = auth()->check() ? (auth()->user()->preferred_genres ?? []) : [];

        return view('onboarding.index', compact('genres', 'userGenres'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'genres' => ['array'],
            'genres.*' => ['string'],
        ]);

        if (auth()->check()) {
            auth()->user()->update([
                'preferred_genres' => $validated['genres'] ?? [],
            ]);
        }

        return redirect()->route('home')->with('success', 'Preferences saved.');
    }
}
