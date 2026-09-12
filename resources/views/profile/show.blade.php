@extends('layouts.app')

@section('content')
<div class="app-container" style="padding-top: 16px;">

    <!-- Profile Header -->
    <div style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 4px; padding: 20px; margin-bottom: 20px;">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px; flex-wrap: wrap;">
            <!-- Avatar -->
            <div style="width: 48px; height: 48px; border-radius: 4px; background: #1c2b3c; border: 1px solid var(--color-blue); display: flex; align-items: center; justify-content: center; font: 700 20px/1 var(--font-mono); color: var(--color-blue-fg);">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <div>
                <h1 style="margin: 0; font: 700 24px/1 var(--font-serif); color: #f2f4f6;">
                    {{ $user->name }}
                </h1>
                <div style="font-family: var(--font-mono); font-size: 12.5px; color: var(--text-muted); margin-top: 4px;">
                    Member since {{ $user->created_at->format('M Y') }}
                </div>
            </div>

            <!-- Reputation Pill & Level -->
            <div style="margin-left: auto; display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                <span style="display: inline-flex; align-items: baseline; gap: 6px; padding: 6px 12px; border: 1px solid #4a72a0; border-radius: 2px; background: #1c2b3c;">
                    <span style="font: 600 11px/1 var(--font-mono); color: #8fb8e0; letter-spacing: .08em;">{{ __('messages.reputation') }}</span>
                    <span style="font: 600 16px/1 var(--font-mono); color: #a9cdf0;">{{ number_format($user->reputation_score) }}</span>
                </span>

                <span style="font: 500 12.5px/1 var(--font-sans); padding: 7px 12px; border: 1px solid var(--border-medium); border-radius: 2px; background: #1b1f24; color: #c3cad1;">
                    {{ $user->reputationLevelTitle() }}
                </span>

                <span style="font: 400 11.5px/1.4 var(--font-mono); color: var(--text-muted);">
                    NEXT LEVEL AT {{ number_format($user->nextLevelThreshold()) }}
                </span>
            </div>
        </div>

        <!-- 5-Metric Stats Grid -->
        <div style="display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 12px;">
            @foreach($stats as $s)
                <div style="border: 1px solid var(--border-subtle); border-radius: 3px; background: #121519; padding: 12px; display: flex; flex-direction: column; gap: 4px;">
                    <span style="font: 600 20px/1 var(--font-mono); color: {{ $s['color'] }};">
                        {{ $s['value'] }}
                    </span>
                    <span style="font: 400 12px/1.35 var(--font-sans); color: var(--text-muted);">
                        {{ $s['label'] }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Badges Shelf -->
    <div style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 4px; padding: 20px; margin-bottom: 20px;">
        <div style="display: flex; align-items: baseline; gap: 10px; margin-bottom: 14px;">
            <span style="font: 600 15px/1 var(--font-sans); color: #e6e8eb;">{{ __('messages.badges') }}</span>
            <span style="font: 400 11.5px/1 var(--font-mono); color: var(--text-muted);">
                {{ count($earnedBadgeIds) }} OF {{ $allBadges->count() }} EARNED
            </span>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 12px;">
            @foreach($allBadges as $badge)
                @php $earned = in_array($badge->id, $earnedBadgeIds); @endphp
                <div style="display: flex; gap: 10px; padding: 10px 12px; border: 1px solid {{ $earned ? '#262b31' : 'var(--border-subtle)' }}; border-radius: 3px; background: {{ $earned ? '#14171b' : '#0e1013' }}; opacity: {{ $earned ? 1 : 0.4 }};">
                    <span style="width: 28px; height: 28px; flex: none; border: 1px solid {{ $earned ? '#4a72a0' : '#303740' }}; border-radius: 3px; background: {{ $earned ? '#1c2b3c' : '#1b1f24' }}; display: flex; align-items: center; justify-content: center;">
                        <span style="width: 8px; height: 8px; background: {{ $earned ? '#a9cdf0' : '#6a737c' }}; border-radius: 2px;"></span>
                    </span>
                    <div style="min-width: 0; display: flex; flex-direction: column; gap: 2px;">
                        <span style="font: 600 12.5px/1.2 var(--font-sans); color: #d6dbe0;">{{ $badge->name }}</span>
                        <span style="font: 400 11.5px/1.3 var(--font-sans); color: var(--text-muted);">{{ $badge->description }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Watched Films Grid & Recent Contributions -->
    <div style="display: flex; gap: 24px; align-items: flex-start;">
        <!-- Watched Films -->
        <div style="flex: 1; min-width: 0; background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 4px; padding: 20px;">
            <div style="display: flex; align-items: baseline; gap: 10px; margin-bottom: 14px;">
                <span style="font: 600 15px/1 var(--font-sans); color: #e6e8eb;">Watched Films</span>
                <span style="font: 400 11.5px/1 var(--font-mono); color: var(--text-muted);">{{ $watchedFilms->count() }} FILMS</span>
            </div>

            @if($watchedFilms->isEmpty())
                <div style="padding: 24px; text-align: center; color: var(--text-muted); font-style: italic; font-size: 13px;">
                    No watched films recorded yet.
                </div>
            @else
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)); gap: 14px;">
                    @foreach($watchedFilms as $w)
                        @php $wVerdict = $w->film->verdict(); @endphp
                        <a href="{{ route('films.show', $w->film) }}" style="display: flex; flex-direction: column; gap: 5px;">
                            <div style="position: relative; aspect-ratio: 2/3; background: repeating-linear-gradient(135deg, #1b1f24 0 5px, #171b20 5px 10px); border: 1px solid var(--border-default); border-radius: 2px; overflow: hidden;">
                                <span style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: {{ $wVerdict['color'] }};"></span>
                                @if($w->film->posterUrl())
                                    <img src="{{ $w->film->posterUrl() }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @endif
                            </div>
                            <div style="font: 600 12.5px/1.2 var(--font-serif); color: #d6dbe0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $w->film->title }}
                            </div>
                            <div style="font: 400 11px/1 var(--font-mono); color: var(--text-muted);">
                                {{ $w->film->releaseYear() }}
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Recent Contributions History -->
        <div style="width: 320px; flex: none; background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 4px; padding: 20px;">
            <div style="font: 600 15px/1 var(--font-sans); color: #e6e8eb; margin-bottom: 14px;">
                Contribution History
            </div>

            @if($recentScenes->isEmpty())
                <div style="color: var(--text-muted); font-size: 12.5px; font-style: italic;">
                    No recent contributions.
                </div>
            @else
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    @foreach($recentScenes as $scene)
                        <div style="display: flex; align-items: center; gap: 10px; font-size: 12.5px; padding-bottom: 8px; border-bottom: 1px solid var(--border-subtle);">
                            <span style="width: 6px; height: 6px; border-radius: 1px; background: {{ $scene->categoryColor() }}; flex: none;"></span>
                            <span style="color: #c3cad1; flex: 1; min-width: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $scene->categoryLabel() }} in {{ $scene->film->title }}
                            </span>
                            <span style="font-family: var(--font-mono); font-size: 11px; color: var(--text-muted);">
                                {{ $scene->created_at->format('m-d') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
