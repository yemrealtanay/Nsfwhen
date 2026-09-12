@extends('layouts.app')

@section('content')
<div class="app-container" style="max-width: 1120px; padding-top: 32px; padding-bottom: 80px;">

    <!-- Document Header & Navigation Tabs -->
    <div style="border-bottom: 1px solid var(--border-default); padding-bottom: 24px; margin-bottom: 32px;">
        <div style="display: flex; align-items: baseline; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 12px;">
            <div style="font: 500 10px/1 var(--font-mono); color: var(--text-muted); letter-spacing: .1em; text-transform: uppercase;">
                NSFWHEN · {{ __('messages.legal_eyebrow') }}
            </div>

            <!-- Language Switcher in Doc -->
            <div style="display: flex; align-items: center; gap: 8px; font-family: var(--font-mono); font-size: 11px;">
                <span style="color: var(--text-muted);">{{ __('messages.document_language') }}:</span>
                <a href="{{ route('locale.switch', 'tr') }}" style="padding: 2px 8px; border-radius: 2px; border: 1px solid {{ app()->getLocale() === 'tr' ? 'var(--color-blue-link)' : 'var(--border-medium)' }}; background: {{ app()->getLocale() === 'tr' ? '#1c2836' : '#14171b' }}; color: {{ app()->getLocale() === 'tr' ? '#8fb8e0' : 'var(--text-muted)' }}; text-decoration: none;">
                    Türkçe (TR)
                </a>
                <a href="{{ route('locale.switch', 'en') }}" style="padding: 2px 8px; border-radius: 2px; border: 1px solid {{ app()->getLocale() === 'en' ? 'var(--color-blue-link)' : 'var(--border-medium)' }}; background: {{ app()->getLocale() === 'en' ? '#1c2836' : '#14171b' }}; color: {{ app()->getLocale() === 'en' ? '#8fb8e0' : 'var(--text-muted)' }}; text-decoration: none;">
                    English (EN)
                </a>
            </div>
        </div>

        <h1 style="font: 700 32px/1.2 var(--font-serif); color: #f2f4f6; margin-bottom: 12px;">
            @yield('legal_title')
        </h1>

        <div style="display: flex; align-items: center; gap: 16px; flex-wrap: wrap; font-family: var(--font-mono); font-size: 11px; color: var(--text-muted); margin-bottom: 24px;">
            <span>{{ __('messages.last_updated') }}: <b style="color: #d6dbe0; font-weight: 500;">12.09.2026</b></span>
            <span>·</span>
            <span>{{ __('messages.version') }}: <b style="color: #d6dbe0; font-weight: 500;">1.0</b></span>
            <span>·</span>
            <span>{{ __('messages.jurisdiction') }}: <b style="color: #d6dbe0; font-weight: 500;">TR & UK</b></span>
        </div>

        <!-- Document Selection Tabs -->
        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
            <a href="{{ route('terms') }}"
               style="padding: 8px 16px; border-radius: 3px; font-size: 12px; font-weight: 500; text-decoration: none; border: 1px solid {{ request()->routeIs('terms', 'guidelines') ? 'var(--color-blue-link)' : 'var(--border-medium)' }}; background: {{ request()->routeIs('terms', 'guidelines') ? '#1c293c' : 'var(--bg-card)' }}; color: {{ request()->routeIs('terms', 'guidelines') ? '#fff' : 'var(--text-secondary)' }};">
                {{ __('messages.terms_of_service') }}
            </a>
            <a href="{{ route('privacy') }}"
               style="padding: 8px 16px; border-radius: 3px; font-size: 12px; font-weight: 500; text-decoration: none; border: 1px solid {{ request()->routeIs('privacy', 'gdpr') ? 'var(--color-blue-link)' : 'var(--border-medium)' }}; background: {{ request()->routeIs('privacy', 'gdpr') ? '#1c293c' : 'var(--bg-card)' }}; color: {{ request()->routeIs('privacy', 'gdpr') ? '#fff' : 'var(--text-secondary)' }};">
                {{ __('messages.privacy_policy') }}
            </a>
        </div>
    </div>

    <!-- Document Two-Column Body -->
    <div class="legal-layout">

        <!-- Sticky Table of Contents Sidebar -->
        <aside class="legal-toc" style="background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 3px; padding: 16px;">
            <div style="font: 500 9px/1 var(--font-mono); color: var(--text-muted); letter-spacing: .09em; text-transform: uppercase; margin-bottom: 12px;">
                {{ __('messages.table_of_contents') }}
            </div>
            <nav style="display: flex; flex-direction: column; gap: 8px; font-size: 12px;">
                @yield('table_of_contents')
            </nav>
        </aside>

        <!-- Main Document Text -->
        <article style="flex: 1; min-width: 0; line-height: 1.7; font-size: 13px; color: #c3cad1;">
            @yield('legal_content')
        </article>

    </div>

</div>
@endsection
