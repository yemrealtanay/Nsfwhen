@extends('layouts.app')

@section('content')
<div class="app-container" style="max-width: 680px; padding-top: 36px;">

    <div style="border: 1px solid var(--border-medium); border-radius: 4px; background: var(--bg-card); overflow: hidden;">
        <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 18px; border-bottom: 1px solid var(--border-default); background: var(--bg-surface);">
            <span style="font: 500 9px/1 var(--font-mono); color: var(--text-muted); letter-spacing: .09em;">
                STEP 1 OF 2 — TASTE PICKER
            </span>
            <a href="{{ route('home') }}" style="font-size: 11px; color: var(--color-blue-link);">
                {{ __('messages.skip') }} →
            </a>
        </div>

        <form action="{{ route('onboarding.update') }}" method="POST" style="padding: 24px; display: flex; flex-direction: column; gap: 20px;">
            @csrf

            <div>
                <h1 style="font: 700 24px/1.2 var(--font-serif); color: #f2f4f6; margin-bottom: 6px;">
                    {{ __('messages.onboarding_title') }}
                </h1>
                <p style="font-size: 12px; color: var(--text-secondary); line-height: 1.6;">
                    {{ __('messages.onboarding_subtitle') }}
                </p>
            </div>

            <div id="genre-selector">
                <div style="font: 500 9px/1 var(--font-mono); color: var(--text-muted); letter-spacing: .09em; margin-bottom: 12px;">
                    GENRES
                </div>

                <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                    @foreach($genres as $genre)
                        @php
                            $genreName = is_array($genre) ? $genre['name'] : $genre;
                            $isSelected = in_array($genreName, $userGenres);
                        @endphp
                        <label style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 12px; border: 1px solid {{ $isSelected ? 'var(--color-blue)' : 'var(--border-subtle)' }}; border-radius: 3px; background: {{ $isSelected ? 'var(--color-blue-bg)' : '#161b22' }}; color: {{ $isSelected ? 'var(--color-blue-fg)' : 'var(--text-secondary)' }}; font-size: 12px; font-weight: 500; cursor: pointer;">
                            <input type="checkbox" name="genres[]" value="{{ $genreName }}" {{ $isSelected ? 'checked' : '' }}
                                   style="accent-color: var(--color-blue);" onchange="this.parentElement.style.borderColor = this.checked ? '#4a72a0' : '#22262c'; this.parentElement.style.background = this.checked ? '#1c2b3c' : '#161b22'; this.parentElement.style.color = this.checked ? '#a9cdf0' : '#98a0a8';">
                            <span>{{ $genreName }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px;">
                <button type="submit" class="btn btn-primary" style="padding: 10px 18px; font-size: 12px;">
                    {{ __('messages.save_and_continue') }}
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
