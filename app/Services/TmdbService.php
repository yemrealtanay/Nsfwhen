<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TmdbService
{
    protected string $baseUrl;

    protected string $apiKey;

    protected string $readToken;

    public function __construct()
    {
        $this->baseUrl = config('tmdb.base_url', 'https://api.themoviedb.org/3');
        $this->apiKey = config('tmdb.api_key', '');
        $this->readToken = config('tmdb.read_token', '');
    }

    protected function client()
    {
        $client = Http::baseUrl($this->baseUrl)->timeout(6);

        if (! empty($this->readToken)) {
            $client->withToken($this->readToken);
        }

        return $client;
    }

    protected function queryParams(array $params = []): array
    {
        if (empty($this->readToken) && ! empty($this->apiKey)) {
            $params['api_key'] = $this->apiKey;
        }

        return $params;
    }

    public function search(string $query, int $page = 1, string $language = 'en-US'): array
    {
        $cacheKey = 'tmdb_search_'.md5("{$query}_{$page}_{$language}");

        return Cache::remember($cacheKey, 3600, function () use ($query, $page, $language) {
            try {
                $response = $this->client()->get('/search/movie', $this->queryParams([
                    'query' => $query,
                    'page' => $page,
                    'language' => $language,
                    'include_adult' => false,
                ]));

                if ($response->successful()) {
                    return $response->json();
                }
            } catch (\Throwable $e) {
                Log::warning('TMDb search failed: '.$e->getMessage());
            }

            return ['results' => [], 'total_results' => 0];
        });
    }

    public function searchPerson(string $query, int $page = 1, string $language = 'en-US'): array
    {
        $cacheKey = 'tmdb_person_'.md5("{$query}_{$page}_{$language}");

        return Cache::remember($cacheKey, 3600, function () use ($query, $page, $language) {
            try {
                $response = $this->client()->get('/search/person', $this->queryParams([
                    'query' => $query,
                    'page' => $page,
                    'language' => $language,
                    'include_adult' => false,
                ]));

                if ($response->successful()) {
                    return $response->json();
                }
            } catch (\Throwable $e) {
                Log::warning('TMDb person search failed: '.$e->getMessage());
            }

            return ['results' => [], 'total_results' => 0];
        });
    }

    public function getMovie(int $tmdbId, string $language = 'en-US'): ?array
    {
        $cacheKey = "tmdb_movie_{$tmdbId}_{$language}";

        return Cache::remember($cacheKey, config('tmdb.cache_ttl', 86400), function () use ($tmdbId, $language) {
            try {
                $response = $this->client()->get("/movie/{$tmdbId}", $this->queryParams([
                    'language' => $language,
                    'append_to_response' => 'credits,release_dates',
                ]));

                if ($response->successful()) {
                    return $response->json();
                }
            } catch (\Throwable $e) {
                Log::warning("TMDb getMovie failed for ID {$tmdbId}: ".$e->getMessage());
            }

            return null;
        });
    }

    public function getGenres(string $language = 'en'): array
    {
        $cacheKey = "tmdb_genres_{$language}";

        return Cache::remember($cacheKey, 604800, function () use ($language) {
            try {
                $response = $this->client()->get('/genre/movie/list', $this->queryParams([
                    'language' => $language,
                ]));

                if ($response->successful()) {
                    return $response->json('genres') ?? [];
                }
            } catch (\Throwable $e) {
                Log::warning('TMDb getGenres failed: '.$e->getMessage());
            }

            // Fallback list of standard genres
            return [
                ['id' => 18, 'name' => 'Drama'],
                ['id' => 53, 'name' => 'Thriller'],
                ['id' => 878, 'name' => 'Sci-Fi'],
                ['id' => 35, 'name' => 'Comedy'],
                ['id' => 10749, 'name' => 'Romance'],
                ['id' => 27, 'name' => 'Horror'],
                ['id' => 80, 'name' => 'Crime'],
                ['id' => 99, 'name' => 'Documentary'],
                ['id' => 16, 'name' => 'Animation'],
                ['id' => 36, 'name' => 'History'],
                ['id' => 28, 'name' => 'Action'],
                ['id' => 9648, 'name' => 'Mystery'],
            ];
        });
    }

    public function discoverPopular(int $year, int $page = 1, int $minVoteCount = 100): array
    {
        try {
            $response = $this->client()->get('/discover/movie', $this->queryParams([
                'primary_release_year' => $year,
                'sort_by' => 'popularity.desc',
                'vote_count.gte' => $minVoteCount,
                'include_adult' => false,
                'include_video' => false,
                'page' => $page,
                'language' => 'en-US',
            ]));

            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Throwable $e) {
            Log::warning("TMDb discoverPopular failed for year {$year}: ".$e->getMessage());
        }

        return ['results' => [], 'total_pages' => 0];
    }
}
