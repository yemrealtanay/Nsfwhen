@extends('layouts.app')

@section('content')
<div class="app-container" style="padding-top: 12px;">

    <div style="display: flex; gap: 24px; align-items: flex-start;">
        <!-- Left Moderation Sidebar -->
        <aside style="width: 230px; flex: none; border-right: 1px solid var(--border-default); background: var(--bg-card); min-height: 600px; padding: 14px 0;">
            <div style="font: 500 9px/1 var(--font-mono); color: var(--text-muted); letter-spacing: .09em; padding: 0 16px 12px;">
                {{ __('editor.moderation') }}
            </div>

            <div style="display: flex; flex-direction: column;">
                <a href="{{ route('editor.dashboard', ['tab' => 'pending']) }}"
                   style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; border-left: 3px solid {{ $currentTab === 'pending' ? 'var(--color-blue-link)' : 'transparent' }}; background: {{ $currentTab === 'pending' ? '#1a1f25' : 'transparent' }}; color: {{ $currentTab === 'pending' ? '#fff' : 'var(--text-secondary)' }}; font-size: 12px; font-weight: 500;">
                    <span>{{ __('editor.pending_queue') }}</span>
                    <span style="margin-left: auto; font-family: var(--font-mono); font-size: 10px; padding: 2px 6px; border-radius: 2px; border: 1px solid var(--border-medium); background: #1b1f24; color: var(--text-muted);">
                        {{ $pendingCount }}
                    </span>
                </a>

                <a href="{{ route('editor.dashboard', ['tab' => 'reported_content']) }}"
                   style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; border-left: 3px solid {{ $currentTab === 'reported_content' ? 'var(--color-blue-link)' : 'transparent' }}; background: {{ $currentTab === 'reported_content' ? '#1a1f25' : 'transparent' }}; color: {{ $currentTab === 'reported_content' ? '#fff' : 'var(--text-secondary)' }}; font-size: 12px; font-weight: 500;">
                    <span>{{ __('editor.reported_content') }}</span>
                    <span style="margin-left: auto; font-family: var(--font-mono); font-size: 10px; padding: 2px 6px; border-radius: 2px; border: 1px solid var(--border-medium); background: #1b1f24; color: var(--text-muted);">
                        {{ $reportedContentCount }}
                    </span>
                </a>

                <a href="{{ route('editor.dashboard', ['tab' => 'reported_users']) }}"
                   style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; border-left: 3px solid {{ $currentTab === 'reported_users' ? 'var(--color-blue-link)' : 'transparent' }}; background: {{ $currentTab === 'reported_users' ? '#1a1f25' : 'transparent' }}; color: {{ $currentTab === 'reported_users' ? '#fff' : 'var(--text-secondary)' }}; font-size: 12px; font-weight: 500;">
                    <span>{{ __('editor.reported_users') }}</span>
                    <span style="margin-left: auto; font-family: var(--font-mono); font-size: 10px; padding: 2px 6px; border-radius: 2px; border: 1px solid var(--border-medium); background: #1b1f24; color: var(--text-muted);">
                        {{ $reportedUsersCount }}
                    </span>
                </a>

                <a href="{{ route('editor.dashboard', ['tab' => 'delist_candidates']) }}"
                   style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; border-left: 3px solid {{ $currentTab === 'delist_candidates' ? 'var(--color-blue-link)' : 'transparent' }}; background: {{ $currentTab === 'delist_candidates' ? '#1a1f25' : 'transparent' }}; color: {{ $currentTab === 'delist_candidates' ? '#fff' : 'var(--text-secondary)' }}; font-size: 12px; font-weight: 500;">
                    <span>{{ __('editor.delist_candidates') }}</span>
                    <span style="margin-left: auto; font-family: var(--font-mono); font-size: 10px; padding: 2px 6px; border-radius: 2px; border: 1px solid var(--border-medium); background: #1b1f24; color: var(--text-muted);">
                        {{ $delistCandidatesCount }}
                    </span>
                </a>
            </div>

            <div style="font: 500 9px/1 var(--font-mono); color: var(--text-muted); letter-spacing: .09em; padding: 24px 16px 10px;">
                REFERENCE
            </div>
            <div style="display: flex; flex-direction: column; gap: 4px; padding: 0 16px; font-size: 11px; color: var(--text-muted);">
                <span>• {{ __('editor.category_rules') }}</span>
                <span>• {{ __('editor.audit_log') }}</span>
                <span>• {{ __('editor.editor_handbook') }}</span>
            </div>
        </aside>

        <!-- Right Main Workspace -->
        <main style="flex: 1; min-width: 0;">

            <!-- 1. PENDING QUEUE TAB -->
            @if($currentTab === 'pending')
                <div style="display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 14px;">
                    <div>
                        <h1 style="font: 600 18px/1 var(--font-sans); color: var(--text-primary); margin-bottom: 4px;">
                            {{ __('editor.pending_queue') }}
                        </h1>
                        <span style="font-family: var(--font-mono); font-size: 11px; color: var(--text-muted);">
                            {{ __('editor.submissions_count', ['count' => $pendingScenes->total()]) }} · Prioritized by community confirmations (≥3 first)
                        </span>
                    </div>
                </div>

                @if($pendingScenes->isEmpty())
                    <div style="padding: 36px; text-align: center; background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; color: var(--text-muted);">
                        Pending queue is clear. No scene submissions awaiting review.
                    </div>
                @else
                    <div style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; overflow: hidden;">
                        <div style="display: grid; grid-template-columns: 200px 140px 110px 80px 120px 1fr; align-items: center; gap: 12px; padding: 10px 14px; border-bottom: 1px solid var(--border-medium); font: 500 9px/1 var(--font-mono); color: var(--text-muted); letter-spacing: 0.08em;">
                            <span>FILM</span>
                            <span>TIME RANGE</span>
                            <span>CATEGORY</span>
                            <span>VOTES</span>
                            <span>SUBMITTER</span>
                            <span style="text-align: right;">ACTION</span>
                        </div>

                        @foreach($pendingScenes as $scene)
                            <div style="display: grid; grid-template-columns: 200px 140px 110px 80px 120px 1fr; align-items: center; gap: 12px; padding: 12px 14px; border-bottom: 1px solid var(--border-subtle); font-size: 12px;">
                                <div>
                                    <a href="{{ route('films.show', $scene->film) }}" style="font: 600 13px/1.2 var(--font-serif); color: var(--text-primary);">
                                        {{ $scene->film->title }}
                                    </a>
                                    <div style="font-family: var(--font-mono); font-size: 10px; color: var(--text-muted);">
                                        {{ $scene->film->releaseYear() }}
                                    </div>
                                </div>

                                <span style="font-family: var(--font-mono); font-size: 12px; color: #d6dbe0;">
                                    {{ $scene->rangeFormatted() }}
                                </span>

                                <span style="display: flex; align-items: center; gap: 6px; font-weight: 500; color: {{ $scene->categoryColor() }}; font-size: 11px;">
                                    <span style="width: 7px; height: 7px; border-radius: 1px; background: {{ $scene->categoryColor() }};"></span>
                                    {{ $scene->categoryLabel() }}
                                </span>

                                <span style="font-family: var(--font-mono); font-weight: 600; color: {{ $scene->confirm_votes_count >= 3 ? '#7cc08a' : 'var(--text-muted)' }};">
                                    {{ $scene->confirm_votes_count }} ✓
                                </span>

                                <span style="color: var(--text-secondary); font-size: 11px;">
                                    {{ $scene->submitter?->name ?? 'anonymous' }}
                                </span>

                                <!-- Approve / Reject Actions -->
                                <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                    <form action="{{ route('editor.scenes.approve', $scene) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-clean" style="padding: 6px 12px; font-size: 11px;">
                                            {{ __('editor.approve') }}
                                        </button>
                                    </form>

                                    <form action="{{ route('editor.scenes.reject', $scene) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 11px;">
                                            {{ __('editor.reject') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div style="margin-top: 16px;">
                        {{ $pendingScenes->links() }}
                    </div>
                @endif

            <!-- 2. REPORTED CONTENT TAB -->
            @elseif($currentTab === 'reported_content')
                <div style="margin-bottom: 14px;">
                    <h1 style="font: 600 18px/1 var(--font-sans); color: var(--text-primary); margin-bottom: 4px;">
                        {{ __('editor.reported_content') }}
                    </h1>
                </div>

                @if($reportedContent->isEmpty())
                    <div style="padding: 36px; text-align: center; background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; color: var(--text-muted);">
                        No reported content pending moderation.
                    </div>
                @else
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        @foreach($reportedContent as $report)
                            <div style="padding: 14px 16px; background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; display: flex; flex-direction: column; gap: 8px;">
                                <div style="display: flex; justify-content: space-between; font-size: 12px;">
                                    <span style="font-weight: 600; color: #f2f4f6;">
                                        Report on scene in {{ $report->reportable?->film?->title ?? 'Unknown' }}
                                        ({{ $report->reportable?->rangeFormatted() }})
                                    </span>
                                    <span style="font-family: var(--font-mono); font-size: 10px; color: var(--text-muted);">
                                        Reported by {{ $report->reporter?->name }} · {{ $report->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <div style="padding: 8px 12px; background: #161b22; border: 1px solid var(--border-subtle); border-radius: 2px; font-size: 12px; color: #c3cad1;">
                                    "{{ $report->reason }}"
                                </div>
                                <div style="display: flex; gap: 8px; justify-content: flex-end; margin-top: 4px;">
                                    <form action="{{ route('editor.reports.resolve', $report) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="action" value="resolve">
                                        <button type="submit" class="btn btn-clean" style="padding: 5px 10px; font-size: 11px;">
                                            {{ __('editor.resolve') }}
                                        </button>
                                    </form>
                                    <form action="{{ route('editor.reports.resolve', $report) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="action" value="dismiss">
                                        <button type="submit" class="btn btn-secondary" style="padding: 5px 10px; font-size: 11px;">
                                            {{ __('editor.dismiss') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            <!-- 3. REPORTED USERS TAB -->
            @elseif($currentTab === 'reported_users')
                <div style="margin-bottom: 14px;">
                    <h1 style="font: 600 18px/1 var(--font-sans); color: var(--text-primary); margin-bottom: 4px;">
                        {{ __('editor.reported_users') }}
                    </h1>
                </div>

                @if($reportedUsers->isEmpty())
                    <div style="padding: 36px; text-align: center; background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; color: var(--text-muted);">
                        No reported users.
                    </div>
                @else
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        @foreach($reportedUsers as $report)
                            <div style="padding: 14px 16px; background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; display: flex; flex-direction: column; gap: 8px;">
                                <div style="display: flex; justify-content: space-between; font-size: 12px;">
                                    <span style="font-weight: 600; color: #f2f4f6;">
                                        User: {{ $report->reportable?->name }} (Reputation: {{ $report->reportable?->reputation_score }})
                                    </span>
                                    <span style="font-family: var(--font-mono); font-size: 10px; color: var(--text-muted);">
                                        Reported by {{ $report->reporter?->name }} · {{ $report->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <div style="padding: 8px 12px; background: #161b22; border: 1px solid var(--border-subtle); border-radius: 2px; font-size: 12px; color: #c3cad1;">
                                    "{{ $report->reason }}"
                                </div>
                                <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                    <form action="{{ route('editor.reports.resolve', $report) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="action" value="resolve">
                                        <button type="submit" class="btn btn-secondary" style="padding: 5px 10px; font-size: 11px;">
                                            Dismiss / Close
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            <!-- 4. DELIST CANDIDATES TAB -->
            @elseif($currentTab === 'delist_candidates')
                <div style="margin-bottom: 14px;">
                    <h1 style="font: 600 18px/1 var(--font-sans); color: var(--text-primary); margin-bottom: 4px;">
                        {{ __('editor.delist_candidates') }}
                    </h1>
                    <span style="font-family: var(--font-mono); font-size: 11px; color: var(--text-muted);">
                        Films with ≥5 positive clean votes. Editor approval is strictly required before delisting.
                    </span>
                </div>

                @if($delistCandidates->isEmpty())
                    <div style="padding: 36px; text-align: center; background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; color: var(--text-muted);">
                        No films currently pending delist review.
                    </div>
                @else
                    <div style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; overflow: hidden;">
                        <div style="display: grid; grid-template-columns: 240px 100px 130px 1fr; align-items: center; gap: 12px; padding: 10px 14px; border-bottom: 1px solid var(--border-medium); font: 500 9px/1 var(--font-mono); color: var(--text-muted); letter-spacing: 0.08em;">
                            <span>FILM</span>
                            <span>YEAR</span>
                            <span>CLEAN VOTES</span>
                            <span style="text-align: right;">DECISION</span>
                        </div>

                        @foreach($delistCandidates as $film)
                            <div style="display: grid; grid-template-columns: 240px 100px 130px 1fr; align-items: center; gap: 12px; padding: 12px 14px; border-bottom: 1px solid var(--border-subtle); font-size: 12px;">
                                <div>
                                    <a href="{{ route('films.show', $film) }}" style="font: 600 13px/1.2 var(--font-serif); color: var(--text-primary);">
                                        {{ $film->title }}
                                    </a>
                                </div>
                                <span style="font-family: var(--font-mono); color: var(--text-muted);">
                                    {{ $film->releaseYear() }}
                                </span>
                                <span style="font-family: var(--font-mono); font-weight: 600; color: #7cc08a;">
                                    {{ $film->clean_votes_count }} positive votes
                                </span>
                                <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                    <form action="{{ route('editor.films.delist', $film) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-clean" style="padding: 6px 12px; font-size: 11px;">
                                            {{ __('editor.confirm_delist') }}
                                        </button>
                                    </form>
                                    <form action="{{ route('editor.films.reject-delist', $film) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary" style="padding: 6px 12px; font-size: 11px;">
                                            {{ __('editor.reject_delist') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif

        </main>
    </div>

</div>
@endsection
