@extends('layouts.app')

@section('content')
<div class="app-container">

    <!-- Global Stats / Banner -->
    <div style="display: flex; flex-wrap: wrap; align-items: baseline; gap: 14px; padding: 12px 16px; border: 1px solid var(--border-subtle); border-radius: 3px; background: var(--bg-card); margin-bottom: 20px; font-family: var(--font-mono); font-size: 11px; color: var(--text-secondary);">
        <span><b style="color: #e6e8eb;">{{ $totalFilms }}</b> films</span>
        <span style="color: var(--text-dim);">·</span>
        <span><b style="color: #e6e8eb;">{{ $totalMarks }}</b> scene marks</span>
        <span style="color: var(--text-dim);">·</span>
        <span><b style="color: #7cc08a;">{{ $verifiedMarks }}</b> verified</span>
        <span style="color: var(--text-dim);">·</span>
        <span><b style="color: #7cc08a;">{{ $cleanVerifiedFilms }}</b> clean-verified</span>
        <span style="margin-left: auto; color: var(--text-muted);">Text & timestamps only · No explicit imagery</span>
    </div>

    <div style="display: flex; gap: 24px; align-items: flex-start;">
        <!-- Left Filter Rail -->
        <aside style="width: 240px; flex: none; display: flex; flex-direction: column; gap: 20px;">
            <!-- Category Filters -->
            <div>
                <div class="filter-section-title">CONTENT FILTER</div>
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <a href="{{ route('home', array_merge(request()->query(), ['category' => null, 'quick' => null])) }}"
                       class="filter-chip {{ empty($selectedCategory) && empty($filterQuick) ? 'active' : '' }}"
                       style="justify-content: space-between;">
                        <span>{{ __('messages.filter_all') }}</span>
                    </a>
                    <a href="{{ route('home', array_merge(request()->query(), ['category' => 'sex_scene', 'quick' => null])) }}"
                       class="filter-chip {{ $selectedCategory === 'sex_scene' ? 'active' : '' }}"
                       style="justify-content: space-between;">
                        <span style="display: flex; align-items: center; gap: 6px;">
                            <span style="width: 8px; height: 8px; border-radius: 1px; background: var(--color-sex);"></span>
                            {{ __('categories.sex_scene') }}
                        </span>
                        <span style="font-family: var(--font-mono); font-size: 10px; color: var(--text-muted);">{{ $sexCount }}</span>
                    </a>
                    <a href="{{ route('home', array_merge(request()->query(), ['category' => 'nudity', 'quick' => null])) }}"
                       class="filter-chip {{ $selectedCategory === 'nudity' ? 'active' : '' }}"
                       style="justify-content: space-between;">
                        <span style="display: flex; align-items: center; gap: 6px;">
                            <span style="width: 8px; height: 8px; border-radius: 1px; background: var(--color-nudity);"></span>
                            {{ __('categories.nudity') }}
                        </span>
                        <span style="font-family: var(--font-mono); font-size: 10px; color: var(--text-muted);">{{ $nudityCount }}</span>
                    </a>
                    <a href="{{ route('home', array_merge(request()->query(), ['category' => 'suggestive', 'quick' => null])) }}"
                       class="filter-chip {{ $selectedCategory === 'suggestive' ? 'active' : '' }}"
                       style="justify-content: space-between;">
                        <span style="display: flex; align-items: center; gap: 6px;">
                            <span style="width: 8px; height: 8px; border-radius: 1px; background: var(--color-suggestive);"></span>
                            {{ __('categories.suggestive') }}
                        </span>
                        <span style="font-family: var(--font-mono); font-size: 10px; color: var(--text-muted);">{{ $suggestiveCount }}</span>
                    </a>
                    <a href="{{ route('home', array_merge(request()->query(), ['category' => 'clean', 'quick' => 'clean'])) }}"
                       class="filter-chip {{ $filterQuick === 'clean' || $selectedCategory === 'clean' ? 'active' : '' }}"
                       style="justify-content: space-between;">
                        <span style="display: flex; align-items: center; gap: 6px;">
                            <span style="width: 8px; height: 8px; border-radius: 1px; background: var(--color-clean);"></span>
                            {{ __('categories.clean_verified') }}
                        </span>
                        <span style="font-family: var(--font-mono); font-size: 10px; color: var(--text-muted);">{{ $cleanVerifiedFilms }}</span>
                    </a>
                </div>
            </div>

            <!-- Quick Preset Chips -->
            <div>
                <div class="filter-section-title">QUICK PRESETS</div>
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <a href="{{ route('home', array_merge(request()->query(), ['quick' => 'family', 'category' => 'clean'])) }}"
                       class="filter-chip {{ $filterQuick === 'family' ? 'active' : '' }}">
                        <svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M2 13s1-4 6-4 6 4 6 4m-3-9a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ __('messages.filter_family') }}
                    </a>
                    <a href="{{ route('home', array_merge(request()->query(), ['quick' => 'needs_verification', 'category' => null])) }}"
                       class="filter-chip {{ $filterQuick === 'needs_verification' ? 'active' : '' }}">
                        <svg width="12" height="12" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="8" cy="8" r="6"></circle>
                            <path d="M8 5v3l2 2"></path>
                        </svg>
                        {{ __('messages.filter_needs_verification') }}
                    </a>
                </div>
            </div>

            <!-- Genres -->
            <div>
                <div class="filter-section-title">GENRES</div>
                <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                    @foreach($genresList as $g)
                        <a href="{{ route('home', array_merge(request()->query(), ['genre' => $selectedGenre === $g ? null : $g])) }}"
                           class="filter-chip {{ $selectedGenre === $g ? 'active' : '' }}"
                           style="padding: 5px 8px; font-size: 10px;">
                            {{ $g }}
                        </a>
                    @endforeach
                </div>
            </div>
        </aside>

        <!-- Main Movies Area -->
        <main style="flex: 1; min-width: 0;">
            <!-- Bar with search summary and layout modes -->
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
                <div style="font-size: 13px; color: var(--text-secondary);">
                    @if($search)
                        <span>Results for "<b style="color: #e6e8eb;">{{ $search }}</b>"</span>
                    @elseif($selectedGenre)
                        <span>Genre: <b style="color: #e6e8eb;">{{ $selectedGenre }}</b></span>
                    @elseif($filterQuick === 'family')
                        <span>Watching with family · Verified clean</span>
                    @else
                        <span>All indexed films ({{ $films->total() }})</span>
                    @endif
                </div>

                <!-- View Mode Switcher -->
                <div style="display: flex; border: 1px solid var(--border-medium); border-radius: 3px; overflow: hidden; font-size: 10px; font-family: var(--font-mono);">
                    <a href="{{ route('home', array_merge(request()->query(), ['view' => 'grid'])) }}"
                       style="padding: 6px 10px; {{ $viewMode === 'grid' ? 'background: #2c333b; color: #fff;' : 'color: #98a0a8;' }}">
                        GRID
                    </a>
                    <a href="{{ route('home', array_merge(request()->query(), ['view' => 'rows'])) }}"
                       style="padding: 6px 10px; {{ $viewMode === 'rows' ? 'background: #2c333b; color: #fff;' : 'color: #98a0a8;' }}">
                        INDEX ROWS
                    </a>
                    <a href="{{ route('home', array_merge(request()->query(), ['view' => 'cards'])) }}"
                       style="padding: 6px 10px; {{ $viewMode === 'cards' ? 'background: #2c333b; color: #fff;' : 'color: #98a0a8;' }}">
                        VERDICT CARDS
                    </a>
                </div>
            </div>

            @if($films->isEmpty())
                <div style="padding: 48px 24px; text-align: center; background: var(--bg-card); border: 1px solid var(--border-subtle); border-radius: 3px; color: var(--text-muted);">
                    <div style="font-size: 13px; color: #b0b8c1; margin-bottom: 6px;">
                        {{ app()->getLocale() === 'tr' ? 'Arama kriterlerinize uygun film bulunamadı.' : 'No films found matching your search and filter criteria.' }}
                    </div>
                    @if(auth()->check() && auth()->user()->isEditor() && !empty($search))
                        <div style="margin-top: 14px; padding-top: 14px; border-top: 1px solid var(--border-subtle); display: flex; flex-direction: column; align-items: center; gap: 8px;">
                            <span style="font-size: 12px; color: #8a94a0;">
                                {{ app()->getLocale() === 'tr' ? 'Aradığınız film henüz NSFWhen\'de kayıtlı değil mi?' : 'Is the film you are looking for not in NSFWhen yet?' }}
                            </span>
                            <a href="{{ route('editor.dashboard', ['tab' => 'import', 'q' => $search]) }}" class="btn" style="padding: 6px 14px; font-size: 11px; font-weight: 600; background: #162436; border: 1px solid #325880; color: #8ec3f8; text-decoration: none;">
                                🎬 TMDb'den "{{ $search }}" Ara ve Ekle →
                            </a>
                        </div>
                    @endif
                </div>
            @else

                <!-- 1a: Grid View -->
                @if($viewMode === 'grid')
                    <div class="films-grid">
                        @foreach($films as $film)
                            @php
                                $verdict = $film->verdict();
                                $counts = $film->categoryCounts();
                            @endphp
                            <a href="{{ route('films.show', $film) }}" class="film-card">
                                <div class="film-poster-wrap">
                                    <span class="film-poster-bar" style="background: {{ $verdict['color'] }};"></span>
                                    @if($film->posterUrl())
                                        <img src="{{ $film->posterUrl() }}" alt="{{ $film->title }}" loading="lazy">
                                    @else
                                        <div style="display: flex; align-items: flex-end; padding: 8px; height: 100%; font-family: var(--font-mono); font-size: 8px; color: #565e67;">
                                            POSTER / TMDb
                                        </div>
                                    @endif
                                </div>
                                <div class="film-card-body">
                                    <div class="film-card-title">{{ $film->title }}</div>
                                    <div class="film-card-meta">
                                        <span>{{ $film->releaseYear() }}</span>
                                        <span>{{ $film->shortRuntime() }}</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 4px; margin-top: 4px;">
                                        <span style="width: 6px; height: 6px; border-radius: 1px; background: {{ $verdict['color'] }};"></span>
                                        <span style="font-size: 10px; font-weight: 500; color: {{ $verdict['fg'] }};">
                                            {{ $verdict['short'] }}
                                        </span>
                                        <span style="margin-left: auto; font-family: var(--font-mono); font-size: 9px; color: var(--text-muted);">
                                            {{ $counts['total'] }}m
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                <!-- 1b: Index Rows View -->
                @elseif($viewMode === 'rows')
                    <div style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; overflow: hidden;">
                        <div style="display: grid; grid-template-columns: 36px minmax(0, 1.6fr) 80px 100px 70px 70px 70px 100px; align-items: center; gap: 12px; padding: 10px 14px; border-bottom: 1px solid var(--border-medium); font: 500 9px/1 var(--font-mono); color: var(--text-muted); letter-spacing: 0.08em;">
                            <span>#</span>
                            <span>TITLE / DIRECTOR</span>
                            <span>YEAR</span>
                            <span>RUNTIME</span>
                            <span style="color: var(--color-sex);">SEX</span>
                            <span style="color: var(--color-nudity);">NUDITY</span>
                            <span style="color: var(--color-suggestive);">SUGG</span>
                            <span style="text-align: right;">STATUS</span>
                        </div>
                        @foreach($films as $idx => $film)
                            @php
                                $counts = $film->categoryCounts();
                                $verdict = $film->verdict();
                            @endphp
                            <a href="{{ route('films.show', $film) }}"
                               style="display: grid; grid-template-columns: 36px minmax(0, 1.6fr) 80px 100px 70px 70px 70px 100px; align-items: center; gap: 12px; padding: 11px 14px; border-bottom: 1px solid var(--border-subtle); font-size: 12px; transition: background 0.1s ease;"
                               onmouseover="this.style.background='#161b22'" onmouseout="this.style.background='transparent'">
                                <span style="font-family: var(--font-mono); font-size: 10px; color: var(--text-muted);">
                                    {{ str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }}
                                </span>
                                <div style="min-width: 0;">
                                    <div style="font: 600 13px/1.2 var(--font-serif); color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $film->title }}
                                    </div>
                                    <div style="font-size: 10px; color: var(--text-muted);">
                                        {{ $film->director ?? '—' }}
                                    </div>
                                </div>
                                <span style="font-family: var(--font-mono); font-size: 11px; color: var(--text-secondary);">
                                    {{ $film->releaseYear() }}
                                </span>
                                <span style="font-family: var(--font-mono); font-size: 11px; color: var(--text-muted);">
                                    {{ $film->shortRuntime() }}
                                </span>
                                <span style="font-family: var(--font-mono); font-weight: 500; color: {{ $counts['sex_scene'] > 0 ? 'var(--color-sex-fg)' : 'var(--text-dim)' }};">
                                    {{ $counts['sex_scene'] > 0 ? str_pad($counts['sex_scene'], 2, '0', STR_PAD_LEFT) : '—' }}
                                </span>
                                <span style="font-family: var(--font-mono); font-weight: 500; color: {{ $counts['nudity'] > 0 ? 'var(--color-nudity-fg)' : 'var(--text-dim)' }};">
                                    {{ $counts['nudity'] > 0 ? str_pad($counts['nudity'], 2, '0', STR_PAD_LEFT) : '—' }}
                                </span>
                                <span style="font-family: var(--font-mono); font-weight: 500; color: {{ $counts['suggestive'] > 0 ? 'var(--color-suggestive-fg)' : 'var(--text-dim)' }};">
                                    {{ $counts['suggestive'] > 0 ? str_pad($counts['suggestive'], 2, '0', STR_PAD_LEFT) : '—' }}
                                </span>
                                <span style="text-align: right;">
                                    <span style="font-family: var(--font-mono); font-size: 9px; padding: 3px 6px; border: 1px solid {{ $verdict['bd'] }}; border-radius: 2px; background: {{ $verdict['bg'] }}; color: {{ $verdict['fg'] }};">
                                        {{ $verdict['short'] }}
                                    </span>
                                </span>
                            </a>
                        @endforeach
                    </div>

                <!-- 1c: Verdict Cards View -->
                @elseif($viewMode === 'cards')
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        @foreach($films as $film)
                            @php
                                $verdict = $film->verdict();
                                $counts = $film->categoryCounts();
                                $intensity = $film->intensityLevel();
                            @endphp
                            <a href="{{ route('films.show', $film) }}"
                               style="display: flex; align-items: center; gap: 18px; padding: 14px 18px; background: var(--bg-card); border: 1px solid var(--border-default); border-left: 4px solid {{ $verdict['color'] }}; border-radius: 3px;">
                                <div style="flex: 1; min-width: 0;">
                                    <div style="display: flex; align-items: baseline; gap: 10px;">
                                        <div style="font: 700 17px/1.2 var(--font-serif); color: var(--text-primary);">
                                            {{ $film->title }}
                                        </div>
                                        <span style="font-family: var(--font-mono); font-size: 11px; color: var(--text-muted);">
                                            {{ $film->releaseYear() }} · {{ $film->shortRuntime() }}
                                        </span>
                                    </div>
                                    <div style="font-size: 12px; color: var(--text-secondary); margin-top: 4px;">
                                        {{ $verdict['summary'] }}
                                    </div>
                                </div>

                                <!-- Intensity Meter -->
                                <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 4px;">
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
                                    <span style="font-family: var(--font-mono); font-size: 10px; color: var(--text-muted);">
                                        {{ $counts['total'] }} marks recorded
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif

                <!-- Pagination -->
                <div style="margin-top: 24px;">
                    {{ $films->links() }}
                </div>
            @endif
        </main>
    </div>
</div>
@endsection
