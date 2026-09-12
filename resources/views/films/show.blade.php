@extends('layouts.app')

@section('title', $film->title . ' (' . ($film->releaseYear() ?: '—') . ')')
@section('meta_description', $film->title . ' content advisory: ' . $film->verdictSummary() . '. Minute-by-minute timeline of sexual content, nudity, and suggestive scenes.')
@if($film->poster_url)
    @section('og_image', $film->poster_url)
@endif
@section('og_type', 'video.movie')

@section('content')
<div class="app-container" style="padding-top: 12px;">

    <!-- Breadcrumb bar -->
    <div style="padding: 8px 0; font: 400 12px/1 var(--font-mono); color: var(--text-muted); border-bottom: 1px solid var(--border-subtle); margin-bottom: 18px;">
        <span>BROWSE</span> /
        <span>{{ !empty($film->genres) ? strtoupper($film->genres[0]) : 'FILM' }}</span> /
        <span style="color: var(--text-secondary);">{{ strtoupper($film->title) }} ({{ $film->releaseYear() }})</span>
    </div>

    <!-- Film Overview & Facts Header -->
    <div class="film-header-layout" style="padding-bottom: 22px; border-bottom: 1px solid var(--border-subtle); margin-bottom: 24px;">
        <!-- Poster -->
        <div class="film-poster-container">
            @if($film->posterUrl())
                <img src="{{ $film->posterUrl() }}" alt="{{ $film->title }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <div style="display: flex; align-items: flex-end; padding: 8px; height: 100%; font: 400 10px/1.2 var(--font-mono); color: #565e67;">
                    POSTER / TMDb
                </div>
            @endif
        </div>

        <!-- Facts & Actions Area -->
        <div style="flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 14px; width: 100%;">
            @php
                $verdict = $film->verdict();
                $intensity = $film->intensityLevel();
                $counts = $film->categoryCounts();
            @endphp

            <!-- Title & Verdict Badges -->
            <div style="display: flex; align-items: baseline; gap: 12px; flex-wrap: wrap;">
                <h1 style="margin: 0; font: 700 32px/1.05 var(--font-serif); color: #f2f4f6; letter-spacing: -0.01em;">
                    {{ $film->title }}
                </h1>
                <span style="font: 400 22px/1.05 var(--font-serif); color: var(--text-secondary);">
                    {{ $film->releaseYear() }}
                </span>

                <span class="badge-verdict" style="border: 1px solid {{ $verdict['bd'] }}; background: {{ $verdict['bg'] }}; color: {{ $verdict['fg'] }};">
                    <span style="width: 8px; height: 8px; border-radius: 1px; background: {{ $verdict['color'] }};"></span>
                    {{ $verdict['label'] }}
                </span>

                <div class="badge-intensity">
                    <span>INTENSITY</span>
                    <div class="intensity-bars">
                        <span class="intensity-bar {{ $intensity >= 1 ? 'active' : '' }}"></span>
                        <span class="intensity-bar {{ $intensity >= 2 ? 'active' : '' }}"></span>
                        <span class="intensity-bar {{ $intensity >= 3 ? 'active' : '' }}"></span>
                    </div>
                    <span style="font-weight: 600; color: {{ $intensity > 0 ? 'var(--color-sex-fg)' : 'var(--text-muted)' }};">
                        {{ $film->intensityLabel() }}
                    </span>
                </div>
            </div>

            <!-- Facts Grid matching design screen 1d -->
            <div class="film-facts-grid">
                @foreach($facts as $fact)
                    <div style="display: flex; flex-direction: column; gap: 3px;">
                        <span style="font: 500 11px/1 var(--font-mono); color: var(--text-muted); letter-spacing: .08em;">
                            {{ $fact['label'] }}
                        </span>
                        <span style="font: 400 13.5px/1.4 var(--font-sans); color: #d6dbe0;">
                            {{ $fact['value'] }}
                        </span>
                    </div>
                @endforeach
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 10px; margin-top: 4px;">
                <form action="{{ route('films.clean-vote', $film) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-clean" {{ $hasCleanVoted ? 'disabled' : '' }} style="opacity: {{ $hasCleanVoted ? '0.6' : '1' }};">
                        <svg width="12" height="12" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M2.4 7.3 5.6 10.5 11.6 3.7"></path>
                        </svg>
                        {{ $hasCleanVoted ? 'Clean vote recorded' : __('messages.no_scenes_button') }}
                    </button>
                </form>

                <form action="{{ route('films.watched', $film) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-secondary">
                        <svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M1 8s3-5 7-5 7 5 7 5-3 5-7 5-7-5-7-5z"></path>
                            <circle cx="8" cy="8" r="2.5"></circle>
                        </svg>
                        {{ $isWatched ? __('messages.watched') : __('messages.mark_as_watched') }}
                    </button>
                </form>

                <div style="margin-left: auto; font: 400 12px/1.5 var(--font-mono); color: var(--text-muted);">
                    {{ __('messages.last_editor_review', ['date' => $film->clean_confirmed_at ? $film->clean_confirmed_at->format('Y-m-d') : 'PENDING']) }}
                    · {{ $counts['total'] }} MARKS · {{ $counts['verified'] }} VERIFIED
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline & Similar Films Area -->
    <div class="film-details-body">
        <!-- Left: Vue Scrubber & Marks Component Mount -->
        <div style="flex: 1; min-width: 0; width: 100%;">
            <div id="timeline-mount"></div>
        </div>

        <!-- Right: People Also Checked Sidebar -->
        <aside class="film-similar-sidebar">
            <div style="font: 600 13.5px/1 var(--font-sans); color: var(--text-primary); margin-bottom: 12px;">
                People also checked
            </div>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                @foreach($similar as $s)
                    @php $sVerdict = $s->verdict(); @endphp
                    <a href="{{ route('films.show', $s) }}" style="display: flex; align-items: center; gap: 10px; transition: opacity 0.1s ease;">
                        <div style="width: 28px; flex: none; aspect-ratio: 2/3; background: repeating-linear-gradient(135deg, #1b1f24 0 5px, #171b20 5px 10px); border: 1px solid var(--border-subtle); border-radius: 2px; overflow: hidden;">
                            @if($s->posterUrl())
                                <img src="{{ $s->posterUrl() }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @endif
                        </div>
                        <span style="font: 600 13.5px/1.2 var(--font-serif); color: #d6dbe0; min-width: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $s->title }}
                        </span>
                        <span style="margin-left: auto; flex: none; width: 7px; height: 7px; border-radius: 1px; background: {{ $sVerdict['color'] }};"></span>
                    </a>
                @endforeach
            </div>
        </aside>
    </div>

</div>

@push('scripts')
<script src="{{ asset('js/components/timeline.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.initTimeline) {
            window.initTimeline('#timeline-mount', {
                film: @json($film),
                scenes: @json($scenesData),
                runtimeSeconds: {{ $runtimeSeconds }},
                ticks: @json($ticks),
                gridLines: @json($gridLines),
                csrfToken: '{{ csrf_token() }}',
                isAuthenticated: {{ auth()->check() ? 'true' : 'false' }}
            });
        }
    });
</script>
@endpush
@endsection
