<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@hasSection('title')@yield('title') — {{ config('app.name', 'NSFWhen') }}@else{{ config('app.name', 'NSFWhen') }} — {{ __('messages.site_tagline') }}@endif</title>

    <meta name="description" content="@yield('meta_description', 'A minute-by-minute index of sexual content and nudity in mainstream films. Community-marked, editor-verified timestamps.')">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Social Sharing -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', config('app.name', 'NSFWhen').' — '.__('messages.site_tagline'))">
    <meta property="og:description" content="@yield('meta_description', 'A minute-by-minute index of sexual content and nudity in mainstream films.')">
    <meta property="og:image" content="@yield('og_image', asset('favicon.svg'))">

    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', config('app.name', 'NSFWhen'))">
    <meta name="twitter:description" content="@yield('meta_description', 'A minute-by-minute index of sexual content and nudity in mainstream films.')">
    <meta name="twitter:image" content="@yield('og_image', asset('favicon.svg'))">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/nsfwhen.css') }}">

    <!-- Standalone Vue 3 Global Prod -->
    <script src="{{ asset('vue.global.prod.js') }}"></script>
    <script src="{{ asset('js/components/age-gate.js') }}"></script>
    @stack('scripts')
</head>
<body>

    <!-- Header -->
    <header class="site-header">
        <!-- NSFWhen Brand Logo with Timeline Scrubber Motif -->
        <a href="{{ route('welcome') }}" class="brand-logo" title="NSFWhen — Film Content Advisory">
            <div class="brand-wordmark">NSFW<span class="accent">hen</span></div>
            <div class="brand-scrubber">
                <span class="brand-scrubber-line"></span>
                <span class="brand-scrubber-dot"></span>
            </div>
        </a>

        <!-- Top Nav (Browse, Guidelines, How it works) -->
        <nav class="site-nav" style="display: flex; gap: 18px; font-size: 12px; font-weight: 500; color: #98a0a8; margin-left: 8px; flex: none;">
            <a href="{{ route('home') }}" style="{{ request()->routeIs('home') ? 'color: #e6e8eb;' : 'color: #98a0a8;' }}">{{ __('welcome.nav_browse') }}</a>
            <a href="{{ route('guidelines') }}" style="{{ request()->routeIs('guidelines', 'terms', 'privacy') ? 'color: #e6e8eb;' : 'color: #98a0a8;' }}">{{ __('welcome.nav_guidelines') }}</a>
            <a href="{{ route('welcome') }}" style="{{ request()->routeIs('welcome') ? 'color: #e6e8eb;' : 'color: #98a0a8;' }}">{{ __('welcome.nav_how_it_works') }}</a>
        </nav>

        <!-- Search Bar -->
        <form action="{{ route('home') }}" method="GET" class="header-search">
            <svg width="13" height="13" viewBox="0 0 16 16" fill="none" stroke="#828a93" stroke-width="1.5">
                <circle cx="7" cy="7" r="4.5"></circle>
                <path d="M10.5 10.5L14 14"></path>
            </svg>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ __('messages.search_placeholder') }}">
        </form>

        <!-- Actions & User Bar -->
        <div class="header-actions">
            <!-- TR / EN Toggle -->
            <div class="lang-toggle">
                <a href="{{ route('locale.switch', 'tr') }}" class="{{ app()->getLocale() === 'tr' ? 'active' : '' }}">TR</a>
                <a href="{{ route('locale.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
            </div>

            @auth
                @if(auth()->user()->isEditor())
                    <a href="{{ route('editor.dashboard', ['tab' => 'import']) }}" class="btn" style="padding: 5px 9px; font-size: 11px; background: #152230; border: 1px solid #2e4d6d; color: #8ec3f8; text-decoration: none;">
                        + {{ app()->getLocale() === 'tr' ? 'Film Ekle' : 'Add Film' }}
                    </a>
                    <a href="{{ route('editor.dashboard') }}" class="btn btn-secondary" style="padding: 5px 9px; font-size: 11px;">
                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #6fa8dc;"></span>
                        {{ __('messages.editor_dashboard') }}
                    </a>
                @endif

                <a href="{{ route('profile.show', auth()->user()) }}" style="display: flex; align-items: center; gap: 8px; font-size: 12px; font-weight: 500; color: #c3cad1;">
                    <span style="width: 24px; height: 24px; border-radius: 2px; background: #2c333b; border: 1px solid #3a424a; display: inline-flex; align-items: center; justify-content: center; font-size: 11px; color: #a9cdf0; font-family: var(--font-mono);">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                    <span>{{ auth()->user()->name }}</span>
                    <span style="font-family: var(--font-mono); font-size: 10px; color: #8fb8e0; background: #1c2b3c; border: 1px solid #4a72a0; border-radius: 2px; padding: 2px 5px;">
                        {{ auth()->user()->reputation_score }}
                    </span>
                </a>

                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: none; border: none; font-size: 11px; color: #767e87; cursor: pointer;">
                        {{ __('messages.logout') }}
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" style="font-size: 12px; color: #98a0a8; font-weight: 500;">
                    {{ __('messages.login') }}
                </a>
                <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 6px 12px; font-size: 11px;">
                    {{ __('messages.register') }}
                </a>
            @endauth
        </div>
    </header>

    <!-- Flash Messages -->
    @if(session('success'))
        <div style="max-width: 1320px; margin: 12px auto 0; padding: 10px 16px; background: #16211a; border: 1px solid #2e4a36; border-radius: 3px; color: #7cc08a; font-size: 12px;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="max-width: 1320px; margin: 12px auto 0; padding: 10px 16px; background: #231a1b; border: 1px solid #4a3033; border-radius: 3px; color: #e8938e; font-size: 12px;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer with TMDb attribution -->
    <footer class="site-footer">
        <div class="footer-inner">
            <div class="tmdb-badge">
                TMDB ATTRIBUTION
            </div>
            <p style="max-width: 720px; line-height: 1.5; color: #767e87;">
                {{ __('messages.tmdb_attribution') }}
            </p>
            <div style="margin-left: auto; display: flex; gap: 16px; font-size: 11px; color: #767e87; flex-wrap: wrap;">
                <a href="{{ route('home') }}">{{ __('welcome.nav_browse') }}</a>
                <a href="{{ route('welcome') }}">{{ __('welcome.nav_how_it_works') }}</a>
                <a href="{{ route('guidelines') }}">{{ __('welcome.nav_guidelines') }}</a>
                <a href="{{ route('terms') }}">{{ __('messages.terms_of_service') }}</a>
                <a href="{{ route('privacy') }}">{{ __('messages.privacy_policy') }}</a>
                @auth
                    @if(auth()->user()->isEditor())
                        <a href="{{ route('editor.dashboard') }}">{{ __('messages.editor_dashboard') }}</a>
                    @endif
                @endauth
            </div>
        </div>
    </footer>

    <!-- Age Gate Modal Mount -->
    <div id="age-gate-mount"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.initAgeGate) {
                window.initAgeGate('#age-gate-mount');
            }
        });
    </script>
</body>
</html>
