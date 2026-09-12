<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Scene;
use Illuminate\Http\Request;

class HomeController
{
    public function index(Request $request)
    {
        $search = $request->query('q');
        $selectedCategory = $request->query('category');
        $selectedGenre = $request->query('genre');
        $viewMode = $request->query('view', 'grid'); // grid (1a), rows (1b), cards (1c)
        $filterQuick = $request->query('quick'); // family, clean, needs_verification

        $query = Film::active()
            ->with(['scenes' => function ($q) {
                $q->where('verification_status', '!=', 'rejected');
            }]);

        if ($search) {
            $query->search($search);
        }

        if ($selectedGenre) {
            $query->whereJsonContains('genres', $selectedGenre);
        }

        if ($filterQuick === 'family' || $filterQuick === 'clean' || $selectedCategory === 'clean') {
            $query->where(function ($q) {
                $q->whereNotNull('clean_confirmed_at')
                    ->orWhere(function ($sub) {
                        $sub->where('clean_votes_count', '>=', 5)
                            ->whereDoesntHave('scenes', function ($sq) {
                                $sq->where('verification_status', 'verified');
                            });
                    });
            });
        } elseif ($selectedCategory && in_array($selectedCategory, ['sex_scene', 'nudity', 'suggestive'])) {
            $query->whereHas('scenes', function ($q) use ($selectedCategory) {
                $q->where('category', $selectedCategory)
                    ->where('verification_status', '!=', 'rejected');
            });
        }

        if ($filterQuick === 'needs_verification') {
            $query->whereHas('scenes', function ($q) {
                $q->where('verification_status', 'unverified');
            });
        }

        $films = $query->latest('release_date')->paginate(18)->withQueryString();

        // Personalized re-ranking if user has preferred genres and no search term
        if (auth()->check() && ! empty(auth()->user()->preferred_genres) && ! $search) {
            $preferred = auth()->user()->preferred_genres;
            $items = $films->getCollection()->sortByDesc(function ($film) use ($preferred) {
                $filmGenres = $film->genres ?? [];

                return count(array_intersect($preferred, $filmGenres));
            })->values();
            $films->setCollection($items);
        }

        // Global metrics for header & welcome
        $totalFilms = Film::count();
        $totalMarks = Scene::where('verification_status', '!=', 'rejected')->count();
        $verifiedMarks = Scene::where('verification_status', 'verified')->count();
        $cleanVerifiedFilms = Film::whereNotNull('clean_confirmed_at')->count();

        // Category counts
        $sexCount = Scene::where('category', 'sex_scene')->where('verification_status', '!=', 'rejected')->count();
        $nudityCount = Scene::where('category', 'nudity')->where('verification_status', '!=', 'rejected')->count();
        $suggestiveCount = Scene::where('category', 'suggestive')->where('verification_status', '!=', 'rejected')->count();

        $genresList = [
            'Drama', 'Thriller', 'Sci-Fi', 'Comedy', 'Romance',
            'Horror', 'Crime', 'Documentary', 'Animation', 'History',
            'Action', 'Mystery',
        ];

        return view('home.index', compact(
            'films',
            'search',
            'selectedCategory',
            'selectedGenre',
            'viewMode',
            'filterQuick',
            'totalFilms',
            'totalMarks',
            'verifiedMarks',
            'cleanVerifiedFilms',
            'sexCount',
            'nudityCount',
            'suggestiveCount',
            'genresList'
        ));
    }

    public function welcome(Request $request)
    {
        if ($request->hasAny(['q', 'category', 'genre', 'view', 'quick', 'page'])) {
            return $this->index($request);
        }

        $totalFilms = Film::count();
        $totalMarks = Scene::where('verification_status', '!=', 'rejected')->count();
        $verifiedMarks = Scene::where('verification_status', 'verified')->count();
        $cleanVerifiedFilms = Film::whereNotNull('clean_confirmed_at')->count();

        // Sample clean films for the shelf (8 films)
        $cleanFilms = Film::active()
            ->whereNotNull('clean_confirmed_at')
            ->limit(8)
            ->get();

        if ($cleanFilms->count() < 8) {
            $additional = Film::active()
                ->whereNotIn('id', $cleanFilms->pluck('id'))
                ->where('clean_votes_count', '>=', 1)
                ->limit(8 - $cleanFilms->count())
                ->get();
            $cleanFilms = $cleanFilms->merge($additional);
        }

        if ($cleanFilms->count() < 8) {
            $more = Film::active()
                ->whereNotIn('id', $cleanFilms->pluck('id'))
                ->limit(8 - $cleanFilms->count())
                ->get();
            $cleanFilms = $cleanFilms->merge($more);
        }

        // Preview film (Poor Things with scenes)
        $previewFilm = Film::where('title', 'Poor Things')->with(['scenes' => function ($q) {
            $q->where('verification_status', '!=', 'rejected')->orderBy('start_time_seconds');
        }])->first();

        // Sample quick search links (TRY chips)
        $tryFilms = Film::active()
            ->whereIn('title', ['Poor Things', 'The Favourite', 'Babylon', 'Portrait of a Lady on Fire', 'Arrival', 'Past Lives'])
            ->limit(4)
            ->get();

        return view('welcome', compact(
            'totalFilms',
            'totalMarks',
            'verifiedMarks',
            'cleanVerifiedFilms',
            'cleanFilms',
            'previewFilm',
            'tryFilms'
        ));
    }
}
