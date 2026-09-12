@extends('layouts.app')

@section('title', __('welcome.meta_title'))
@section('meta_description', __('welcome.meta_description'))

@section('content')
<div class="welcome-container" style="max-width: 1280px; margin: 0 auto; font-family: var(--font-sans); color: var(--text-primary);">

    <!-- HERO SECTION (Screen 1i) -->
    <section class="welcome-hero welcome-section" style="padding: 64px 40px 52px; border-bottom: 1px solid var(--border-subtle); display: flex; gap: 56px; align-items: flex-start; flex-wrap: wrap;">
        
        <!-- Hero Left Column -->
        <div class="welcome-hero-left" style="flex: 1; min-width: 0; max-width: 660px; display: flex; flex-direction: column; gap: 20px;">
            <div style="font: 500 10px/1 var(--font-mono); color: var(--text-muted); letter-spacing: 0.14em; text-transform: uppercase;">
                {{ __('welcome.hero_eyebrow') }}
            </div>

            <!-- Big Brand Logo in Hero -->
            <div style="display: inline-flex; flex-direction: column; width: fit-content; margin-top: 2px; margin-bottom: 2px;">
                <div class="welcome-hero-logo" style="font: 700 64px/0.92 var(--font-sans); letter-spacing: -0.04em; color: #f2f4f6; display: flex; align-items: baseline;">
                    <span>NSFW</span><span style="color: var(--color-coral);">hen</span>
                    <span style="font: 500 11px/1 var(--font-mono); color: var(--text-muted); letter-spacing: 0.1em; margin-left: 14px; padding: 3px 6px; border: 1px solid var(--border-medium); border-radius: 2px; background: var(--bg-surface); align-self: flex-start;">.COM</span>
                </div>
                <!-- Enlarged timeline scrubber motif -->
                <div style="position: relative; height: 10px; width: 100%; margin-top: 8px;">
                    <span style="position: absolute; top: 4px; left: 0; right: 0; height: 3px; background: #303740; border-radius: 2px;"></span>
                    <span style="position: absolute; top: 0; left: 56.5%; width: 11px; height: 11px; border-radius: 50%; background: var(--color-coral); box-shadow: 0 0 12px rgba(255, 77, 109, 0.65);"></span>
                </div>
            </div>

            <!-- Slogan (Under the logo) -->
            <h1 class="welcome-hero-title" style="margin: 0; font: 700 38px/1.18 var(--font-serif); color: #f6f7f8; letter-spacing: -0.02em; text-wrap: pretty;">
                {{ __('welcome.hero_title_line1') }} <i style="font-style: italic; color: #d6dbe0;">{{ __('welcome.hero_title_line2') }}</i>
            </h1>

            <p style="margin: 0; font: 400 15px/1.65 var(--font-sans); color: #b4bcc4; max-width: 540px; text-wrap: pretty;">
                {{ __('welcome.hero_subtitle') }}
            </p>

            <!-- Big Search Form -->
            <form action="{{ route('home') }}" method="GET" style="display: flex; align-items: center; gap: 10px; max-width: 560px; background: var(--bg-card-alt); border: 1px solid var(--border-strong); border-radius: 3px; padding: 10px 14px; margin-top: 4px;">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="#98a0a8" stroke-width="1.5" style="flex: none;">
                    <circle cx="7" cy="7" r="4.5"></circle>
                    <path d="M10.5 10.5L14 14"></path>
                </svg>
                <input 
                    type="text" 
                    name="q" 
                    placeholder="{{ __('welcome.hero_search_placeholder') }}"
                    style="flex: 1; background: transparent; border: none; outline: none; font-size: 14px; color: var(--text-primary);"
                >
                <button type="submit" class="btn btn-primary" style="padding: 7px 14px; font-size: 12px; font-weight: 600; flex: none;">
                    {{ app()->getLocale() === 'tr' ? 'Sorgula' : 'Look up' }}
                </button>
            </form>

            <!-- TRY: suggestions -->
            <div style="display: flex; flex-wrap: wrap; gap: 6px; align-items: center;">
                <span style="font: 400 10px/1 var(--font-mono); color: var(--text-muted); margin-right: 2px;">
                    {{ __('welcome.hero_search_try_label') }}
                </span>
                @php
                    $samples = $tryFilms && $tryFilms->isNotEmpty() ? $tryFilms : [
                        (object)['title' => 'Poor Things', 'id' => 1],
                        (object)['title' => 'The Favourite', 'id' => 2],
                        (object)['title' => 'Babylon', 'id' => 3],
                        (object)['title' => 'Portrait of a Lady on Fire', 'id' => 4],
                    ];
                @endphp
                @foreach($samples as $sample)
                    <a href="{{ isset($sample->id) && $sample->id ? route('films.show', $sample->id) : route('home', ['q' => $sample->title]) }}" 
                       style="font: 400 11px/1 var(--font-sans); padding: 5px 9px; border: 1px solid var(--border-subtle); border-radius: 2px; background: var(--bg-surface); color: var(--text-secondary); transition: border-color 0.1s ease;">
                        {{ $sample->title }}
                    </a>
                @endforeach
            </div>

            <!-- Disclaimer note -->
            <div style="display: flex; align-items: center; gap: 8px; margin-top: 4px;">
                <svg width="13" height="13" viewBox="0 0 16 16" fill="none" stroke="#6a737c" stroke-width="1.4" style="flex: none;">
                    <circle cx="8" cy="8" r="6.3"></circle>
                    <path d="M8 7.3v4M8 4.7v.9"></path>
                </svg>
                <span style="font: 400 11px/1.6 var(--font-sans); color: var(--text-muted);">
                    {{ __('welcome.hero_disclaimer') }}
                </span>
            </div>
        </div>

        <!-- Hero Right Column: What an answer looks like (Preview Card) -->
        <div class="welcome-preview-card" style="width: 420px; flex: none; max-width: 100%; border: 1px solid var(--border-default); border-radius: 3px; background: var(--bg-card); padding: 20px;">
            <div style="display: flex; align-items: baseline; gap: 9px; margin-bottom: 14px;">
                <span style="font: 600 12px/1 var(--font-sans); color: var(--text-primary);">
                    {{ __('welcome.example_label') }}
                </span>
                <span style="margin-left: auto; font: 400 9px/1 var(--font-mono); color: var(--text-muted); letter-spacing: 0.05em;">
                    POOR THINGS · 2:21:00
                </span>
            </div>

            <!-- Mini Timeline Scrubber Bar -->
            <div style="position: relative; height: 34px; background: var(--bg-surface); border: 1px solid var(--border-default); border-radius: 2px; overflow: hidden;">
                <!-- Grid Lines (Every 15 min / 141 min total) -->
                @foreach([10.6, 21.3, 31.9, 42.5, 53.2, 63.8, 74.5, 85.1, 95.7] as $leftPct)
                    <span style="position: absolute; top: 0; bottom: 0; width: 1px; background: #22262c; left: {{ $leftPct }}%;"></span>
                @endforeach

                <!-- Timeline Segments -->
                <span style="position: absolute; top: 0; bottom: 0; left: 13.2%; width: 1.2%; background: var(--color-suggestive); border-radius: 1px;" title="00:18:40 – 00:19:25 Suggestive"></span>
                <span style="position: absolute; top: 0; bottom: 0; left: 22.1%; width: 1.8%; background: var(--color-nudity); border-radius: 1px;" title="00:31:10 – 00:33:05 Nudity"></span>
                <span style="position: absolute; top: 0; bottom: 0; left: 33.6%; width: 2.2%; background: var(--color-sex); border-radius: 1px;" title="00:47:22 – 00:49:58 Sex scene"></span>
                <span style="position: absolute; top: 0; bottom: 0; left: 41.2%; width: 1.2%; background: transparent; border: 1px dashed var(--color-nudity); border-radius: 1px;" title="00:58:05 – 00:59:12 Nudity (Community)"></span>
                <span style="position: absolute; top: 0; bottom: 0; left: 44.1%; width: 2.1%; background: var(--color-sex); border-radius: 1px;" title="01:02:14 – 01:04:48 Sex scene"></span>
                <span style="position: absolute; top: 0; bottom: 0; left: 53.5%; width: 1.1%; background: transparent; border: 1px dashed var(--color-suggestive); border-radius: 1px;" title="01:15:30 – 01:16:44 Suggestive"></span>
                <span style="position: absolute; top: 0; bottom: 0; left: 71.7%; width: 1.9%; background: var(--color-sex); border-radius: 1px;" title="01:41:08 – 01:43:20 Sex scene"></span>
            </div>

            <!-- Ticks under bar -->
            <div style="position: relative; height: 18px; margin-bottom: 10px;">
                <span style="position: absolute; top: 4px; left: 0%; font: 400 8px/1 var(--font-mono); color: #565e67;">0:00</span>
                <span style="position: absolute; top: 4px; left: 21.3%; transform: translateX(-50%); font: 400 8px/1 var(--font-mono); color: #565e67;">0:30</span>
                <span style="position: absolute; top: 4px; left: 42.5%; transform: translateX(-50%); font: 400 8px/1 var(--font-mono); color: #565e67;">1:00</span>
                <span style="position: absolute; top: 4px; left: 63.8%; transform: translateX(-50%); font: 400 8px/1 var(--font-mono); color: #565e67;">1:30</span>
                <span style="position: absolute; top: 4px; left: 85.1%; transform: translateX(-50%); font: 400 8px/1 var(--font-mono); color: #565e67;">2:00</span>
                <span style="position: absolute; top: 4px; right: 0%; font: 400 8px/1 var(--font-mono); color: #565e67;">2:21</span>
            </div>

            <!-- Preview Marks List -->
            <div style="display: flex; flex-direction: column; gap: 1px; border-top: 1px solid var(--border-subtle);">
                <div style="display: flex; align-items: center; gap: 10px; padding: 7px 0; border-bottom: 1px solid var(--border-subtle);">
                    <span style="width: 3px; height: 15px; flex: none; background: var(--color-suggestive); border-radius: 1px;"></span>
                    <span style="font: 500 12px/1 var(--font-mono); color: var(--text-primary);">00:18:40 – 00:19:25</span>
                    <span style="font: 500 10px/1 var(--font-sans); color: var(--color-suggestive);">{{ __('categories.suggestive') }}</span>
                    <span style="margin-left: auto; font: 500 9px/1 var(--font-mono); letter-spacing: 0.04em; padding: 3px 6px; border: 1px solid #2e4a36; border-radius: 2px; background: #16211a; color: #7cc08a;">
                        VERIFIED
                    </span>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; padding: 7px 0; border-bottom: 1px solid var(--border-subtle);">
                    <span style="width: 3px; height: 15px; flex: none; background: var(--color-nudity); border-radius: 1px;"></span>
                    <span style="font: 500 12px/1 var(--font-mono); color: var(--text-primary);">00:31:10 – 00:33:05</span>
                    <span style="font: 500 10px/1 var(--font-sans); color: var(--color-nudity);">{{ __('categories.nudity') }}</span>
                    <span style="margin-left: auto; font: 500 9px/1 var(--font-mono); letter-spacing: 0.04em; padding: 3px 6px; border: 1px solid #2e4a36; border-radius: 2px; background: #16211a; color: #7cc08a;">
                        VERIFIED
                    </span>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; padding: 7px 0; border-bottom: 1px solid var(--border-subtle);">
                    <span style="width: 3px; height: 15px; flex: none; background: var(--color-sex); border-radius: 1px;"></span>
                    <span style="font: 500 12px/1 var(--font-mono); color: var(--text-primary);">00:47:22 – 00:49:58</span>
                    <span style="font: 500 10px/1 var(--font-sans); color: var(--color-sex);">{{ __('categories.sex_scene') }}</span>
                    <span style="margin-left: auto; font: 500 9px/1 var(--font-mono); letter-spacing: 0.04em; padding: 3px 6px; border: 1px solid #2e4a36; border-radius: 2px; background: #16211a; color: #7cc08a;">
                        VERIFIED
                    </span>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; padding: 7px 0; border-bottom: 1px solid var(--border-subtle);">
                    <span style="width: 3px; height: 15px; flex: none; background: var(--color-nudity); border-radius: 1px;"></span>
                    <span style="font: 500 12px/1 var(--font-mono); color: var(--text-primary);">00:58:05 – 00:59:12</span>
                    <span style="font: 500 10px/1 var(--font-sans); color: var(--color-nudity);">{{ __('categories.nudity') }}</span>
                    <span style="margin-left: auto; font: 500 9px/1 var(--font-mono); letter-spacing: 0.04em; padding: 3px 6px; border: 1px solid #303740; border-radius: 2px; background: #1b1f24; color: #98a0a8;">
                        COMMUNITY
                    </span>
                </div>
            </div>

            <div style="font: 400 10px/1.6 var(--font-sans); color: var(--text-muted); padding-top: 10px;">
                {{ __('welcome.example_legend') }}
            </div>
        </div>
    </section>

    <!-- 5 METRIC STATS ROW (Screen 1i) -->
    <section class="welcome-stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); border-bottom: 1px solid var(--border-subtle);">
        <div class="welcome-stats-item" style="padding: 22px 36px; border-right: 1px solid var(--border-subtle); display: flex; flex-direction: column; gap: 5px;">
            <span style="font: 500 26px/1 var(--font-mono); color: #f2f4f6; letter-spacing: -0.02em;">
                {{ number_format($totalFilms, 0, ',', ' ') }}
            </span>
            <span style="font: 400 11px/1.4 var(--font-sans); color: var(--text-muted);">
                {{ __('welcome.stats_films_label') }}
            </span>
        </div>

        <div class="welcome-stats-item" style="padding: 22px 36px; border-right: 1px solid var(--border-subtle); display: flex; flex-direction: column; gap: 5px;">
            <span style="font: 500 26px/1 var(--font-mono); color: #f2f4f6; letter-spacing: -0.02em;">
                {{ number_format($totalMarks, 0, ',', ' ') }}
            </span>
            <span style="font: 400 11px/1.4 var(--font-sans); color: var(--text-muted);">
                {{ __('welcome.stats_marks_label') }}
            </span>
        </div>

        <div class="welcome-stats-item" style="padding: 22px 36px; border-right: 1px solid var(--border-subtle); display: flex; flex-direction: column; gap: 5px;">
            <span style="font: 500 26px/1 var(--font-mono); color: #f2f4f6; letter-spacing: -0.02em;">
                {{ number_format($verifiedMarks, 0, ',', ' ') }}
            </span>
            <span style="font: 400 11px/1.4 var(--font-sans); color: var(--text-muted);">
                {{ __('welcome.stats_verified_label') }}
            </span>
        </div>

        <div class="welcome-stats-item" style="padding: 22px 36px; border-right: 1px solid var(--border-subtle); display: flex; flex-direction: column; gap: 5px;">
            <span style="font: 500 26px/1 var(--font-mono); color: #f2f4f6; letter-spacing: -0.02em;">
                {{ number_format($cleanVerifiedFilms, 0, ',', ' ') }}
            </span>
            <span style="font: 400 11px/1.4 var(--font-sans); color: var(--text-muted);">
                {{ __('welcome.stats_clean_label') }}
            </span>
        </div>

        <div class="welcome-stats-item" style="padding: 22px 36px; display: flex; flex-direction: column; gap: 5px;">
            <span style="font: 500 26px/1 var(--font-mono); color: #f2f4f6; letter-spacing: -0.02em;">
                {{ $avgReviewTime ?? '—' }}
            </span>
            <span style="font: 400 11px/1.4 var(--font-sans); color: var(--text-muted);">
                {{ __('welcome.stats_review_time_label') }}
            </span>
        </div>
    </section>

    <!-- HOW IT WORKS (Screen 1i) -->
    <section id="how-it-works" class="welcome-section" style="padding: 48px 40px; border-bottom: 1px solid var(--border-subtle);">
        <div style="font: 500 10px/1 var(--font-mono); color: var(--text-muted); letter-spacing: 0.14em; margin-bottom: 26px; text-transform: uppercase;">
            {{ __('welcome.how_it_works_title') }}
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 40px;">
            <!-- Step 01 -->
            <div style="display: flex; flex-direction: column; gap: 9px; padding-top: 14px; border-top: 1px solid var(--border-medium);">
                <span style="font: 500 11px/1 var(--font-mono); color: var(--color-sex); letter-spacing: 0.08em;">
                    01
                </span>
                <span style="font: 600 19px/1.25 var(--font-serif); color: #f2f4f6;">
                    {{ __('welcome.how_it_works_step1_title') }}
                </span>
                <span style="font: 400 13px/1.7 var(--font-sans); color: #98a0a8; text-wrap: pretty;">
                    {{ __('welcome.how_it_works_step1_desc') }}
                </span>
            </div>

            <!-- Step 02 -->
            <div style="display: flex; flex-direction: column; gap: 9px; padding-top: 14px; border-top: 1px solid var(--border-medium);">
                <span style="font: 500 11px/1 var(--font-mono); color: var(--color-sex); letter-spacing: 0.08em;">
                    02
                </span>
                <span style="font: 600 19px/1.25 var(--font-serif); color: #f2f4f6;">
                    {{ __('welcome.how_it_works_step2_title') }}
                </span>
                <span style="font: 400 13px/1.7 var(--font-sans); color: #98a0a8; text-wrap: pretty;">
                    {{ __('welcome.how_it_works_step2_desc') }}
                </span>
            </div>

            <!-- Step 03 -->
            <div style="display: flex; flex-direction: column; gap: 9px; padding-top: 14px; border-top: 1px solid var(--border-medium);">
                <span style="font: 500 11px/1 var(--font-mono); color: var(--color-sex); letter-spacing: 0.08em;">
                    03
                </span>
                <span style="font: 600 19px/1.25 var(--font-serif); color: #f2f4f6;">
                    {{ __('welcome.how_it_works_step3_title') }}
                </span>
                <span style="font: 400 13px/1.7 var(--font-sans); color: #98a0a8; text-wrap: pretty;">
                    {{ __('welcome.how_it_works_step3_desc') }}
                </span>
            </div>
        </div>
    </section>

    <!-- WHAT WE WILL NEVER DO (Screen 1i Manifesto) -->
    <section class="welcome-section" style="padding: 48px 40px; border-bottom: 1px solid var(--border-subtle); display: flex; gap: 56px; align-items: flex-start; flex-wrap: wrap;">
        <div style="max-width: 300px; width: 100%; flex: none; display: flex; flex-direction: column; gap: 10px;">
            <span style="font: 500 10px/1 var(--font-mono); color: var(--text-muted); letter-spacing: 0.14em; text-transform: uppercase;">
                {{ __('welcome.never_do_title') }}
            </span>
            <span style="font: 600 24px/1.25 var(--font-serif); color: #f2f4f6; text-wrap: pretty;">
                {{ __('welcome.never_do_subtitle') }}
            </span>
        </div>

        <div style="flex: 1; min-width: 0; display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px 36px;">
            <div style="display: flex; gap: 11px;">
                <span style="width: 14px; height: 14px; flex: none; margin-top: 3px; border: 1px solid #4a3033; border-radius: 2px; background: #231a1b; position: relative;">
                    <span style="position: absolute; top: 6px; left: 3px; width: 8px; height: 1.5px; background: #e8938e;"></span>
                </span>
                <span style="font: 400 13px/1.6 var(--font-sans); color: #b4bcc4;">
                    {{ __('welcome.never_do_item1') }}
                </span>
            </div>

            <div style="display: flex; gap: 11px;">
                <span style="width: 14px; height: 14px; flex: none; margin-top: 3px; border: 1px solid #4a3033; border-radius: 2px; background: #231a1b; position: relative;">
                    <span style="position: absolute; top: 6px; left: 3px; width: 8px; height: 1.5px; background: #e8938e;"></span>
                </span>
                <span style="font: 400 13px/1.6 var(--font-sans); color: #b4bcc4;">
                    {{ __('welcome.never_do_item2') }}
                </span>
            </div>

            <div style="display: flex; gap: 11px;">
                <span style="width: 14px; height: 14px; flex: none; margin-top: 3px; border: 1px solid #4a3033; border-radius: 2px; background: #231a1b; position: relative;">
                    <span style="position: absolute; top: 6px; left: 3px; width: 8px; height: 1.5px; background: #e8938e;"></span>
                </span>
                <span style="font: 400 13px/1.6 var(--font-sans); color: #b4bcc4;">
                    {{ __('welcome.never_do_item3') }}
                </span>
            </div>

            <div style="display: flex; gap: 11px;">
                <span style="width: 14px; height: 14px; flex: none; margin-top: 3px; border: 1px solid #4a3033; border-radius: 2px; background: #231a1b; position: relative;">
                    <span style="position: absolute; top: 6px; left: 3px; width: 8px; height: 1.5px; background: #e8938e;"></span>
                </span>
                <span style="font: 400 13px/1.6 var(--font-sans); color: #b4bcc4;">
                    {{ __('welcome.never_do_item4') }}
                </span>
            </div>

            <div style="display: flex; gap: 11px;">
                <span style="width: 14px; height: 14px; flex: none; margin-top: 3px; border: 1px solid #2e4a36; border-radius: 2px; background: #16211a; display: flex; align-items: center; justify-content: center;">
                    <svg width="9" height="9" viewBox="0 0 10 10" fill="none" stroke="#7cc08a" stroke-width="2">
                        <path d="M1.6 5.2 3.9 7.5 8.4 2.5"></path>
                    </svg>
                </span>
                <span style="font: 400 13px/1.6 var(--font-sans); color: #b4bcc4;">
                    {{ __('welcome.never_do_item5') }}
                </span>
            </div>

            <div style="display: flex; gap: 11px;">
                <span style="width: 14px; height: 14px; flex: none; margin-top: 3px; border: 1px solid #2e4a36; border-radius: 2px; background: #16211a; display: flex; align-items: center; justify-content: center;">
                    <svg width="9" height="9" viewBox="0 0 10 10" fill="none" stroke="#7cc08a" stroke-width="2">
                        <path d="M1.6 5.2 3.9 7.5 8.4 2.5"></path>
                    </svg>
                </span>
                <span style="font: 400 13px/1.6 var(--font-sans); color: #b4bcc4;">
                    {{ __('welcome.never_do_item6') }}
                </span>
            </div>
        </div>
    </section>

    <!-- CLEAN-VERIFIED SHELF (Screen 1i) -->
    <section class="welcome-shelf-section welcome-section" style="padding: 40px 40px 44px; border-bottom: 1px solid var(--border-subtle);">
        <div style="display: flex; align-items: baseline; gap: 12px; margin-bottom: 18px; flex-wrap: wrap;">
            <span style="font: 600 14px/1 var(--font-sans); color: var(--text-primary);">
                {{ __('welcome.clean_shelf_title') }}
            </span>
            <span style="font: 400 10px/1 var(--font-mono); color: var(--text-muted); letter-spacing: 0.04em;">
                {{ __('welcome.clean_shelf_subtitle') }}
            </span>
            <a href="{{ $cleanVerifiedFilms > 0 ? route('home', ['category' => 'clean']) : route('home') }}" style="margin-left: auto; font: 500 11px/1 var(--font-sans); color: var(--color-blue-link);">
                {{ __('welcome.clean_shelf_cta', ['count' => number_format($cleanVerifiedFilms > 0 ? $cleanVerifiedFilms : $totalFilms, 0, ',', ' ')]) }}
            </a>
        </div>

        <!-- 8-Film Grid -->
        <div class="welcome-shelf-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 16px;">
            @php
                $cleanShelf = $cleanFilms && $cleanFilms->isNotEmpty() ? $cleanFilms : collect([
                    (object)['title' => 'Arrival', 'release_date' => '2016-11-11', 'poster_url' => 'https://image.tmdb.org/t/p/w500/x2FJsf1ElAgr63Y3PNPtJrcmpoe.jpg', 'id' => null],
                    (object)['title' => 'Dune: Part Two', 'release_date' => '2024-03-01', 'poster_url' => 'https://image.tmdb.org/t/p/w500/1pdfLvkbY9ohJlCjQH2CZjjYVvJ.jpg', 'id' => null],
                    (object)['title' => 'Past Lives', 'release_date' => '2023-06-02', 'poster_url' => 'https://image.tmdb.org/t/p/w500/k3waqVXSnvCZWfJYNtdamTgTtTA.jpg', 'id' => null],
                    (object)['title' => 'Sicario', 'release_date' => '2015-10-02', 'poster_url' => 'https://image.tmdb.org/t/p/w500/m67smI195Vi04IrjiCS52z99iHf.jpg', 'id' => null],
                    (object)['title' => 'The Zone of Interest', 'release_date' => '2023-12-15', 'poster_url' => 'https://image.tmdb.org/t/p/w500/hUu9zyZmDD8VZAvQ2apEH4GQgaO.jpg', 'id' => null],
                    (object)['title' => 'Aftersun', 'release_date' => '2022-10-21', 'poster_url' => 'https://image.tmdb.org/t/p/w500/mpBLXj92M76mK4b9b9BvK4Q93QG.jpg', 'id' => null],
                    (object)['title' => 'Prisoners', 'release_date' => '2013-09-20', 'poster_url' => 'https://image.tmdb.org/t/p/w500/jsW60WbB11Lw26Y4wM4980yvYmR.jpg', 'id' => null],
                    (object)['title' => 'Paddington 2', 'release_date' => '2017-11-10', 'poster_url' => 'https://image.tmdb.org/t/p/w500/go0K8s2kP905e4iB391295y5e4Q.jpg', 'id' => null],
                ]);
            @endphp
            @foreach($cleanShelf->take(8) as $film)
                <a href="{{ isset($film->id) && $film->id ? route('films.show', $film->id) : route('home', ['q' => $film->title]) }}" 
                   style="display: flex; flex-direction: column; gap: 7px; text-decoration: none;">
                    <div style="position: relative; aspect-ratio: 2/3; background: repeating-linear-gradient(135deg,#1b1f24 0 5px,#171b20 5px 10px); border: 1px solid var(--border-default); border-radius: 2px; overflow: hidden;">
                        @php
                            $poster = method_exists($film, 'posterUrl') ? $film->posterUrl() : ($film->poster_url ?? null);
                        @endphp
                        @if(!empty($poster))
                            <img src="{{ $poster }}" alt="{{ $film->title }}" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy">
                        @else
                            <div style="display: flex; align-items: center; justify-content: center; height: 100%; font: 500 10px/1.2 var(--font-mono); color: var(--text-muted); text-align: center; padding: 8px;">
                                {{ $film->title }}
                            </div>
                        @endif
                        <span style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--color-clean);"></span>
                    </div>
                    <div style="font: 600 12px/1.25 var(--font-serif); color: #d6dbe0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ $film->title }}
                    </div>
                    <div style="font: 400 9px/1 var(--font-mono); color: var(--text-muted);">
                        {{ $film->release_date ? substr($film->release_date, 0, 4) : '—' }}
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- TWO-FIELD CONTRIBUTION BANNER (Screen 1i) -->
    <section class="welcome-section" style="padding: 48px 40px; display: flex; align-items: flex-end; gap: 40px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 0;">
            <div style="font: 600 28px/1.25 var(--font-serif); color: #f2f4f6; max-width: 520px; text-wrap: pretty; margin-bottom: 10px;">
                {{ __('welcome.cta_title') }}
            </div>
            <div style="font: 400 13px/1.7 var(--font-sans); color: #98a0a8; max-width: 480px;">
                {{ __('welcome.cta_subtitle') }}
            </div>
        </div>

        <div style="flex: none; display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 12px 20px; font-size: 13px; font-weight: 600;">
                {{ __('welcome.cta_register') }}
            </a>
            <a href="{{ route('guidelines') }}" class="btn btn-secondary" style="padding: 12px 20px; font-size: 13px; font-weight: 500;">
                {{ __('welcome.cta_guidelines') }}
            </a>
        </div>
    </section>

    <!-- TMDB ATTRIBUTION & SCENE DATA NOTICE BAND (Screen 1i) -->
    <section class="welcome-section" style="display: flex; gap: 40px; align-items: flex-start; padding: 26px 40px; border-top: 1px solid var(--border-subtle); background: #101317; flex-wrap: wrap;">
        <div style="display: flex; gap: 16px; align-items: flex-start; max-width: 620px;">
            <div style="width: 92px; height: 26px; flex: none; border: 1px dashed #3a424a; border-radius: 3px; display: flex; align-items: center; justify-content: center;">
                <span style="font: 500 8px/1 var(--font-mono); color: #5c646d; letter-spacing: 0.08em;">TMDB LOGO</span>
            </div>
            <div style="display: flex; flex-direction: column; gap: 6px;">
                <span style="font: 400 12px/1.7 var(--font-sans); color: #b4bcc4;">
                    {{ __('welcome.footer_tmdb_line1') }}
                </span>
                <span style="font: 400 11px/1.7 var(--font-sans); color: var(--text-muted);">
                    {{ __('welcome.footer_tmdb_line2') }}
                </span>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 6px; max-width: 320px;">
            <span style="font: 500 9px/1 var(--font-mono); color: var(--text-muted); letter-spacing: 0.1em; text-transform: uppercase;">
                {{ __('welcome.footer_scene_data_title') }}
            </span>
            <span style="font: 400 11px/1.7 var(--font-sans); color: #98a0a8;">
                {{ __('welcome.footer_scene_data_body') }}
            </span>
            <div style="display: flex; gap: 10px; margin-top: 4px; font-size: 11px;">
                <a href="{{ route('terms') }}" style="color: var(--color-blue-link); text-decoration: none;">{{ __('messages.terms_of_service') }}</a>
                <span style="color: var(--border-medium);">·</span>
                <a href="{{ route('privacy') }}" style="color: var(--color-blue-link); text-decoration: none;">{{ __('messages.privacy_policy') }}</a>
            </div>
        </div>
    </section>

</div>
@endsection
