@extends('layouts.app')

@section('content')
<div class="app-container" style="padding-top: 12px;">

    <div class="editor-layout">
        <!-- Left Moderation Sidebar -->
        <aside class="editor-sidebar">
            <div style="font: 600 11px/1 var(--font-mono); color: var(--text-muted); letter-spacing: .09em; padding: 0 16px 12px;">
                {{ __('editor.moderation') }}
            </div>

            <div class="editor-nav-list">
                <a href="{{ route('editor.dashboard', ['tab' => 'pending']) }}"
                   class="{{ $currentTab === 'pending' ? 'active-tab' : '' }}"
                   style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; border-left: 3px solid {{ $currentTab === 'pending' ? 'var(--color-blue-link)' : 'transparent' }}; background: {{ $currentTab === 'pending' ? '#1a1f25' : 'transparent' }}; color: {{ $currentTab === 'pending' ? '#fff' : 'var(--text-secondary)' }}; font-size: 13.5px; font-weight: 500;">
                    <span>{{ __('editor.pending_queue') }}</span>
                    <span style="margin-left: auto; font-family: var(--font-mono); font-size: 11px; padding: 2px 7px; border-radius: 2px; border: 1px solid var(--border-medium); background: #1b1f24; color: var(--text-muted);">
                        {{ $pendingCount }}
                    </span>
                </a>

                <a href="{{ route('editor.dashboard', ['tab' => 'reported_content']) }}"
                   class="{{ $currentTab === 'reported_content' ? 'active-tab' : '' }}"
                   style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; border-left: 3px solid {{ $currentTab === 'reported_content' ? 'var(--color-blue-link)' : 'transparent' }}; background: {{ $currentTab === 'reported_content' ? '#1a1f25' : 'transparent' }}; color: {{ $currentTab === 'reported_content' ? '#fff' : 'var(--text-secondary)' }}; font-size: 13.5px; font-weight: 500;">
                    <span>{{ __('editor.reported_content') }}</span>
                    <span style="margin-left: auto; font-family: var(--font-mono); font-size: 11px; padding: 2px 7px; border-radius: 2px; border: 1px solid var(--border-medium); background: #1b1f24; color: var(--text-muted);">
                        {{ $reportedContentCount }}
                    </span>
                </a>

                <a href="{{ route('editor.dashboard', ['tab' => 'reported_users']) }}"
                   class="{{ $currentTab === 'reported_users' ? 'active-tab' : '' }}"
                   style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; border-left: 3px solid {{ $currentTab === 'reported_users' ? 'var(--color-blue-link)' : 'transparent' }}; background: {{ $currentTab === 'reported_users' ? '#1a1f25' : 'transparent' }}; color: {{ $currentTab === 'reported_users' ? '#fff' : 'var(--text-secondary)' }}; font-size: 13.5px; font-weight: 500;">
                    <span>{{ __('editor.reported_users') }}</span>
                    <span style="margin-left: auto; font-family: var(--font-mono); font-size: 11px; padding: 2px 7px; border-radius: 2px; border: 1px solid var(--border-medium); background: #1b1f24; color: var(--text-muted);">
                        {{ $reportedUsersCount }}
                    </span>
                </a>

                <a href="{{ route('editor.dashboard', ['tab' => 'delist_candidates']) }}"
                   class="{{ $currentTab === 'delist_candidates' ? 'active-tab' : '' }}"
                   style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; border-left: 3px solid {{ $currentTab === 'delist_candidates' ? 'var(--color-blue-link)' : 'transparent' }}; background: {{ $currentTab === 'delist_candidates' ? '#1a1f25' : 'transparent' }}; color: {{ $currentTab === 'delist_candidates' ? '#fff' : 'var(--text-secondary)' }}; font-size: 13.5px; font-weight: 500;">
                    <span>{{ __('editor.delist_candidates') }}</span>
                    <span style="margin-left: auto; font-family: var(--font-mono); font-size: 11px; padding: 2px 7px; border-radius: 2px; border: 1px solid var(--border-medium); background: #1b1f24; color: var(--text-muted);">
                        {{ $delistCandidatesCount }}
                    </span>
                </a>

                <a href="{{ route('editor.dashboard', ['tab' => 'users']) }}"
                   class="{{ $currentTab === 'users' ? 'active-tab' : '' }}"
                   style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; border-left: 3px solid {{ $currentTab === 'users' ? 'var(--color-blue-link)' : 'transparent' }}; background: {{ $currentTab === 'users' ? '#1a1f25' : 'transparent' }}; color: {{ $currentTab === 'users' ? '#fff' : 'var(--text-secondary)' }}; font-size: 13.5px; font-weight: 500;">
                    <span>{{ __('editor.users_management') }}</span>
                    <span style="margin-left: auto; font-family: var(--font-mono); font-size: 11px; padding: 2px 7px; border-radius: 2px; border: 1px solid #365880; background: #162436; color: #8fb8e0;">
                        {{ $editorsCount }}
                    </span>
                </a>

                <div style="font: 600 11px/1 var(--font-mono); color: var(--text-muted); letter-spacing: .09em; padding: 16px 16px 8px;">
                    {{ __('editor.catalog_tools') }}
                </div>

                <a href="{{ route('editor.dashboard', ['tab' => 'import']) }}"
                   class="{{ $currentTab === 'import' ? 'active-tab' : '' }}"
                   style="display: flex; align-items: center; gap: 10px; padding: 10px 16px; border-left: 3px solid {{ $currentTab === 'import' ? 'var(--color-blue-link)' : 'transparent' }}; background: {{ $currentTab === 'import' ? '#1a1f25' : 'transparent' }}; color: {{ $currentTab === 'import' ? '#fff' : 'var(--text-secondary)' }}; font-size: 13.5px; font-weight: 500;">
                    <span>🎬 {{ __('editor.tmdb_import') }}</span>
                </a>
            </div>

            <div style="font: 600 11px/1 var(--font-mono); color: var(--text-muted); letter-spacing: .09em; padding: 24px 16px 10px;">
                REFERENCE
            </div>
            <div style="display: flex; flex-direction: column; gap: 4px; padding: 0 16px; font-size: 12.5px; color: var(--text-muted);">
                <span>• {{ __('editor.category_rules') }}</span>
                <span>• {{ __('editor.audit_log') }}</span>
                <span>• {{ __('editor.editor_handbook') }}</span>
            </div>
        </aside>

        <!-- Right Main Workspace -->
        <main class="editor-main">

            <!-- 1. PENDING QUEUE TAB -->
            @if($currentTab === 'pending')
                <div style="display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 14px;">
                    <div>
                        <h1 style="font: 600 19px/1.2 var(--font-sans); color: var(--text-primary); margin-bottom: 4px;">
                            {{ __('editor.pending_queue') }}
                        </h1>
                        <span style="font-family: var(--font-mono); font-size: 12px; color: var(--text-muted);">
                            {{ __('editor.submissions_count', ['count' => $pendingScenes->total()]) }} · Prioritized by community confirmations (≥3 first)
                        </span>
                    </div>
                </div>

                @if($pendingScenes->isEmpty())
                    <div style="padding: 36px; text-align: center; background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; color: var(--text-muted); font-size: 13px;">
                        Pending queue is clear. No scene submissions awaiting review.
                    </div>
                @else
                    <div class="table-responsive" style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px;">
                        <div style="min-width: 720px;">
                            <div style="display: grid; grid-template-columns: 200px 140px 110px 80px 120px 1fr; align-items: center; gap: 12px; padding: 10px 14px; border-bottom: 1px solid var(--border-medium); font: 600 11px/1 var(--font-mono); color: var(--text-muted); letter-spacing: 0.08em;">
                                <span>FILM</span>
                                <span>TIME RANGE</span>
                                <span>CATEGORY</span>
                                <span>VOTES</span>
                                <span>SUBMITTER</span>
                                <span style="text-align: right;">ACTION</span>
                            </div>

                            @foreach($pendingScenes as $scene)
                                <div style="display: grid; grid-template-columns: 200px 140px 110px 80px 120px 1fr; align-items: center; gap: 12px; padding: 12px 14px; border-bottom: 1px solid var(--border-subtle); font-size: 13px;">
                                    <div>
                                        <a href="{{ route('films.show', $scene->film) }}" style="font: 600 14px/1.2 var(--font-serif); color: var(--text-primary);">
                                            {{ $scene->film->title }}
                                        </a>
                                        <div style="font-family: var(--font-mono); font-size: 11.5px; color: var(--text-muted);">
                                            {{ $scene->film->releaseYear() }}
                                        </div>
                                    </div>

                                    <span style="font-family: var(--font-mono); font-size: 13px; color: #d6dbe0;">
                                        {{ $scene->rangeFormatted() }}
                                    </span>

                                    <span style="display: flex; align-items: center; gap: 6px; font-weight: 500; color: {{ $scene->categoryColor() }}; font-size: 12px;">
                                        <span style="width: 7px; height: 7px; border-radius: 1px; background: {{ $scene->categoryColor() }};"></span>
                                        {{ $scene->categoryLabel() }}
                                    </span>

                                    <span style="font-family: var(--font-mono); font-weight: 600; color: {{ $scene->confirm_votes_count >= 3 ? '#7cc08a' : 'var(--text-muted)' }};">
                                        {{ $scene->confirm_votes_count }} ✓
                                    </span>

                                    <span style="color: var(--text-secondary); font-size: 12px;">
                                        {{ $scene->submitter?->name ?? 'anonymous' }}
                                    </span>

                                    <!-- Approve / Reject Actions -->
                                    <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                        <form action="{{ route('editor.scenes.approve', $scene) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-clean" style="padding: 6px 12px; font-size: 12px;">
                                                {{ __('editor.approve') }}
                                            </button>
                                        </form>

                                        <form action="{{ route('editor.scenes.reject', $scene) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 12px;">
                                                {{ __('editor.reject') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div style="margin-top: 16px;">
                        {{ $pendingScenes->links() }}
                    </div>
                @endif

            <!-- 2. REPORTED CONTENT TAB -->
            @elseif($currentTab === 'reported_content')
                <div style="margin-bottom: 14px;">
                    <h1 style="font: 600 19px/1.2 var(--font-sans); color: var(--text-primary); margin-bottom: 4px;">
                        {{ __('editor.reported_content') }}
                    </h1>
                </div>

                @if($reportedContent->isEmpty())
                    <div style="padding: 36px; text-align: center; background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; color: var(--text-muted); font-size: 13px;">
                        No reported content pending moderation.
                    </div>
                @else
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        @foreach($reportedContent as $report)
                            <div style="padding: 14px 16px; background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; display: flex; flex-direction: column; gap: 8px;">
                                <div style="display: flex; justify-content: space-between; font-size: 13px;">
                                    <span style="font-weight: 600; color: #f2f4f6;">
                                        Report on scene in {{ $report->reportable?->film?->title ?? 'Unknown' }}
                                        ({{ $report->reportable?->rangeFormatted() }})
                                    </span>
                                    <span style="font-family: var(--font-mono); font-size: 11.5px; color: var(--text-muted);">
                                        Reported by {{ $report->reporter?->name }} · {{ $report->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <div style="padding: 8px 12px; background: #161b22; border: 1px solid var(--border-subtle); border-radius: 2px; font-size: 13px; color: #c3cad1;">
                                    "{{ $report->reason }}"
                                </div>
                                <div style="display: flex; gap: 8px; justify-content: flex-end; margin-top: 4px;">
                                    <form action="{{ route('editor.reports.resolve', $report) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="action" value="resolve">
                                        <button type="submit" class="btn btn-clean" style="padding: 6px 12px; font-size: 12px;">
                                            {{ __('editor.resolve') }}
                                        </button>
                                    </form>
                                    <form action="{{ route('editor.reports.resolve', $report) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="action" value="dismiss">
                                        <button type="submit" class="btn btn-secondary" style="padding: 6px 12px; font-size: 12px;">
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
                    <h1 style="font: 600 19px/1.2 var(--font-sans); color: var(--text-primary); margin-bottom: 4px;">
                        {{ __('editor.reported_users') }}
                    </h1>
                </div>

                @if($reportedUsers->isEmpty())
                    <div style="padding: 36px; text-align: center; background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; color: var(--text-muted); font-size: 13px;">
                        No reported users.
                    </div>
                @else
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        @foreach($reportedUsers as $report)
                            <div style="padding: 14px 16px; background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; display: flex; flex-direction: column; gap: 8px;">
                                <div style="display: flex; justify-content: space-between; font-size: 13px;">
                                    <span style="font-weight: 600; color: #f2f4f6;">
                                        User: {{ $report->reportable?->name }} (Reputation: {{ $report->reportable?->reputation_score }})
                                    </span>
                                    <span style="font-family: var(--font-mono); font-size: 11.5px; color: var(--text-muted);">
                                        Reported by {{ $report->reporter?->name }} · {{ $report->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <div style="padding: 8px 12px; background: #161b22; border: 1px solid var(--border-subtle); border-radius: 2px; font-size: 13px; color: #c3cad1;">
                                    "{{ $report->reason }}"
                                </div>
                                <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                    <form action="{{ route('editor.reports.resolve', $report) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="action" value="resolve">
                                        <button type="submit" class="btn btn-secondary" style="padding: 6px 12px; font-size: 12px;">
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
                    <h1 style="font: 600 19px/1.2 var(--font-sans); color: var(--text-primary); margin-bottom: 4px;">
                        {{ __('editor.delist_candidates') }}
                    </h1>
                    <span style="font-family: var(--font-mono); font-size: 12px; color: var(--text-muted);">
                        Films with ≥5 positive clean votes. Editor approval is strictly required before delisting.
                    </span>
                </div>

                @if($delistCandidates->isEmpty())
                    <div style="padding: 36px; text-align: center; background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; color: var(--text-muted); font-size: 13px;">
                        No films currently pending delist review.
                    </div>
                @else
                    <div class="table-responsive" style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px;">
                        <div style="min-width: 600px;">
                            <div style="display: grid; grid-template-columns: 240px 100px 130px 1fr; align-items: center; gap: 12px; padding: 10px 14px; border-bottom: 1px solid var(--border-medium); font: 600 11px/1 var(--font-mono); color: var(--text-muted); letter-spacing: 0.08em;">
                                <span>FILM</span>
                                <span>YEAR</span>
                                <span>CLEAN VOTES</span>
                                <span style="text-align: right;">DECISION</span>
                            </div>

                            @foreach($delistCandidates as $film)
                                <div style="display: grid; grid-template-columns: 240px 100px 130px 1fr; align-items: center; gap: 12px; padding: 12px 14px; border-bottom: 1px solid var(--border-subtle); font-size: 13px;">
                                    <div>
                                        <a href="{{ route('films.show', $film) }}" style="font: 600 14px/1.2 var(--font-serif); color: var(--text-primary);">
                                            {{ $film->title }}
                                        </a>
                                    </div>
                                    <span style="font-family: var(--font-mono); color: var(--text-muted); font-size: 12px;">
                                        {{ $film->releaseYear() }}
                                    </span>
                                    <span style="font-family: var(--font-mono); font-weight: 600; color: #7cc08a; font-size: 12px;">
                                        {{ $film->clean_votes_count }} positive votes
                                    </span>
                                    <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                        <form action="{{ route('editor.films.delist', $film) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-clean" style="padding: 6px 12px; font-size: 12px;">
                                                {{ __('editor.confirm_delist') }}
                                            </button>
                                        </form>
                                        <form action="{{ route('editor.films.reject-delist', $film) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-secondary" style="padding: 6px 12px; font-size: 12px;">
                                                {{ __('editor.reject_delist') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            <!-- 5. USERS & EDITORS MANAGEMENT TAB -->
            @elseif($currentTab === 'users')
                <div style="display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 14px; gap: 16px; flex-wrap: wrap;">
                    <div>
                        <h1 style="font: 600 19px/1.2 var(--font-sans); color: var(--text-primary); margin-bottom: 4px;">
                            {{ __('editor.users_management') }}
                        </h1>
                        <span style="font-family: var(--font-mono); font-size: 12px; color: var(--text-muted);">
                            {{ __('editor.users_management_desc') }}
                        </span>
                    </div>

                    <!-- Search Box -->
                    <form action="{{ route('editor.dashboard') }}" method="GET" style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                        <input type="hidden" name="tab" value="users">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('editor.search_users_placeholder') }}"
                                style="background: #121519; border: 1px solid var(--border-medium); border-radius: 2px; padding: 6px 10px; color: var(--text-primary); font-size: 12.5px; width: 220px;">
                        <button type="submit" class="btn btn-secondary" style="padding: 6px 12px; font-size: 12px;">
                            {{ __('editor.search_button') }}
                        </button>
                        @if(request('search'))
                            <a href="{{ route('editor.dashboard', ['tab' => 'users']) }}" style="font-size: 12px; color: var(--text-muted); text-decoration: underline;">
                                {{ __('editor.clear_filter') }}
                            </a>
                        @endif
                    </form>
                </div>

                @if($users && $users->isEmpty())
                    <div style="padding: 36px; text-align: center; background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; color: var(--text-muted); font-size: 13px;">
                        {{ __('editor.no_users_found') }}
                    </div>
                @elseif($users)
                    <div class="table-responsive" style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px;">
                        <div style="min-width: 680px;">
                            <div style="display: grid; grid-template-columns: 2fr 110px 140px 100px 110px 150px; align-items: center; gap: 12px; padding: 10px 14px; border-bottom: 1px solid var(--border-medium); font: 600 11px/1 var(--font-mono); color: var(--text-muted); letter-spacing: 0.08em;">
                            <span>KULLANICI / USER</span>
                            <span>ROL</span>
                            <span>E-POSTA DURUMU</span>
                            <span>İTİBAR</span>
                            <span>KAYIT</span>
                            <span style="text-align: right;">İŞLEM</span>
                        </div>

                        @foreach($users as $u)
                            <div style="display: grid; grid-template-columns: 2fr 110px 140px 100px 110px 150px; align-items: center; gap: 12px; padding: 12px 14px; border-bottom: 1px solid var(--border-subtle); font-size: 13px;">
                                <div style="display: flex; align-items: center; gap: 10px; min-width: 0;">
                                    <span style="width: 28px; height: 28px; border-radius: 2px; background: #232a31; border: 1px solid var(--border-medium); display: inline-flex; align-items: center; justify-content: center; font-size: 12px; color: #8fb8e0; font-family: var(--font-mono); flex: none;">
                                        {{ strtoupper(substr($u->name, 0, 1)) }}
                                    </span>
                                    <div style="min-width: 0;">
                                        <div style="font-weight: 600; color: var(--text-primary); text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                            {{ $u->name }}
                                            @if($u->id === auth()->id())
                                                <span style="font-size: 11px; color: var(--text-muted); font-weight: normal;">({{ __('editor.you') }})</span>
                                            @endif
                                        </div>
                                        <div style="font-family: var(--font-mono); font-size: 11.5px; color: var(--text-muted); text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                            {{ $u->email }}
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    @if($u->is_editor)
                                        <span style="font-family: var(--font-mono); font-size: 11px; padding: 2px 6px; border-radius: 2px; background: #1a293c; border: 1px solid #3d6a9a; color: #8fb8e0; font-weight: 600;">
                                            {{ __('editor.role_editor') }}
                                        </span>
                                    @else
                                        <span style="font-family: var(--font-mono); font-size: 11px; padding: 2px 6px; border-radius: 2px; background: #1d2126; border: 1px solid var(--border-medium); color: var(--text-muted);">
                                            {{ __('editor.role_member') }}
                                        </span>
                                    @endif
                                </div>

                                <div style="font-size: 12px;">
                                    @if($u->hasVerifiedEmail())
                                        <span style="color: #6fc27d; display: inline-flex; align-items: center; gap: 4px;">
                                            <span style="font-size: 10px;">●</span> {{ __('editor.email_verified') }}
                                        </span>
                                    @else
                                        <span style="color: #d19a4e; display: inline-flex; align-items: center; gap: 4px;">
                                            <span style="font-size: 10px;">○</span> {{ __('editor.email_unverified') }}
                                        </span>
                                    @endif
                                </div>

                                <div style="font-family: var(--font-mono); font-size: 12px; color: #a2b0be;">
                                    {{ $u->reputation_score }}
                                </div>

                                <div style="font-family: var(--font-mono); font-size: 11.5px; color: var(--text-muted);">
                                    {{ $u->created_at ? $u->created_at->format('d.m.Y') : '—' }}
                                </div>

                                <div style="text-align: right;">
                                    @if($u->id === auth()->id())
                                        <span style="font-family: var(--font-mono); font-size: 12px; color: var(--text-muted);">
                                            {{ __('editor.you') }}
                                        </span>
                                    @else
                                        <form action="{{ route('editor.users.toggle-role', $u) }}" method="POST" onsubmit="return confirm('{{ $u->is_editor ? __('editor.confirm_revoke') : __('editor.confirm_promote') }}');" style="display: inline-block;">
                                            @csrf
                                            @if($u->is_editor)
                                                <button type="submit" class="btn" style="background: #271b1d; color: #e67d78; border: 1px solid #5a2e32; padding: 5px 10px; font-size: 12px; cursor: pointer;">
                                                    {{ __('editor.revoke_editor') }}
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-secondary" style="background: #172738; color: #7db7f0; border: 1px solid #355d88; padding: 5px 10px; font-size: 12px; cursor: pointer;">
                                                    + {{ __('editor.make_editor') }}
                                                </button>
                                            @endif
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>

                    <div style="margin-top: 14px;">
                        {{ $users->links() }}
                    </div>
                @endif
            @endif

            <!-- 6. TMDB IMPORT TAB -->
            @if($currentTab === 'import')
                <div style="display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 14px;">
                    <div>
                        <h1 style="font: 600 19px/1.2 var(--font-sans); color: var(--text-primary); margin-bottom: 4px;">
                            {{ __('editor.tmdb_import_title') }}
                        </h1>
                        <span style="font-family: var(--font-mono); font-size: 12px; color: var(--text-muted);">
                            {{ __('editor.tmdb_import_desc') }}
                        </span>
                    </div>
                </div>

                <!-- Search form -->
                <div style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; padding: 16px; margin-bottom: 20px;">
                    <form action="{{ route('editor.dashboard') }}" method="GET" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                        <input type="hidden" name="tab" value="import">
                        <input type="text"
                                name="q"
                                value="{{ $tmdbSearch ?? '' }}"
                                placeholder="{{ __('editor.tmdb_search_placeholder') }}"
                                style="flex: 1; min-width: 180px; background: var(--bg-surface); border: 1px solid var(--border-medium); border-radius: 2px; padding: 9px 13px; font-size: 14px; color: var(--text-primary); outline: none;">
                        <button type="submit" class="btn btn-primary" style="padding: 9px 18px; font-size: 13px; font-weight: 600;">
                            {{ __('editor.search_button') }}
                        </button>
                        @if(!empty($tmdbSearch))
                            <a href="{{ route('editor.dashboard', ['tab' => 'import']) }}" class="btn btn-secondary" style="padding: 9px 14px; font-size: 13px;">
                                {{ __('editor.clear_filter') }}
                            </a>
                        @endif
                    </form>
                </div>

                @if(!empty($tmdbSearch))
                    @if(empty($tmdbResults))
                        <div style="padding: 32px; text-align: center; border: 1px dashed var(--border-default); border-radius: 3px; background: var(--bg-card); color: var(--text-muted); font-size: 13px;">
                            {{ __('editor.tmdb_no_results') }}
                        </div>
                    @else
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            @foreach($tmdbResults as $movie)
                                <div style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; padding: 14px 18px; display: flex; gap: 18px; align-items: flex-start;">
                                    <!-- Poster -->
                                    <div style="width: 58px; height: 86px; flex: none; background: #1b1f24; border: 1px solid var(--border-subtle); border-radius: 2px; overflow: hidden;">
                                        @if(!empty($movie['poster_path']))
                                            <img src="https://image.tmdb.org/t/p/w200{{ $movie['poster_path'] }}" alt="{{ $movie['title'] ?? 'Film' }}" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy">
                                        @else
                                            <div style="height: 100%; display: flex; align-items: center; justify-content: center; font-size: 10px; font-family: var(--font-mono); color: var(--text-muted); text-align: center;">NO POSTER</div>
                                        @endif
                                    </div>

                                    <!-- Details -->
                                    <div style="flex: 1; min-width: 0;">
                                        <div style="display: flex; align-items: baseline; gap: 10px; margin-bottom: 4px; flex-wrap: wrap;">
                                            <span style="font: 600 17px/1.2 var(--font-serif); color: #f2f4f6;">
                                                {{ $movie['title'] ?? 'Unknown' }}
                                            </span>
                                            @if(!empty($movie['original_title']) && $movie['original_title'] !== ($movie['title'] ?? ''))
                                                <span style="font: 400 13px/1 var(--font-sans); color: var(--text-muted); font-style: italic;">
                                                    ({{ $movie['original_title'] }})
                                                </span>
                                            @endif
                                            <span style="font: 500 12px/1 var(--font-mono); color: var(--text-muted);">
                                                {{ !empty($movie['release_date']) ? substr($movie['release_date'], 0, 4) : '—' }}
                                            </span>
                                            <span style="font: 400 11px/1 var(--font-mono); color: var(--text-muted); margin-left: auto;">
                                                TMDb ID: #{{ $movie['id'] }}
                                            </span>
                                        </div>

                                        <p style="font: 400 13px/1.55 var(--font-sans); color: #9da7b3; margin: 0 0 10px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                            {{ $movie['overview'] ?? 'Açıklama bulunmuyor.' }}
                                        </p>

                                        <!-- Action Button -->
                                        <div>
                                            @if(!empty($movie['existing_film']))
                                                <div style="display: flex; align-items: center; gap: 10px;">
                                                    <span style="font: 600 11px/1 var(--font-mono); padding: 4px 8px; border-radius: 2px; background: #16241a; border: 1px solid #2b4d32; color: #7cc08a;">
                                                        ✓ {{ __('editor.already_indexed') }}
                                                    </span>
                                                    <a href="{{ route('films.show', $movie['existing_film']->id) }}" class="btn btn-secondary" style="padding: 5px 12px; font-size: 12px; text-decoration: none;">
                                                        {{ __('editor.view_film') }}
                                                    </a>
                                                </div>
                                            @else
                                                <form action="{{ route('editor.films.import') }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    <input type="hidden" name="tmdb_id" value="{{ $movie['id'] }}">
                                                    <button type="submit" class="btn btn-primary" style="padding: 6px 14px; font-size: 12px; font-weight: 600; cursor: pointer;">
                                                        {{ __('editor.import_button') }}
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div style="padding: 48px 32px; text-align: center; border: 1px dashed var(--border-default); border-radius: 3px; background: var(--bg-card); color: var(--text-muted);">
                        <div style="font-size: 32px; margin-bottom: 12px;">🎬</div>
                        <div style="font: 500 14.5px/1.5 var(--font-sans); color: #d6dbe0; margin-bottom: 4px;">
                            {{ __('editor.tmdb_import_title') }}
                        </div>
                        <div style="font: 400 12.5px/1.5 var(--font-sans); color: var(--text-muted); max-width: 440px; margin: 0 auto;">
                            {{ __('editor.tmdb_import_prompt') }}
                        </div>
                    </div>
                @endif
            @endif

        </main>
    </div>

</div>
@endsection
