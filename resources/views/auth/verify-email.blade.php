@extends('layouts.app')

@section('content')
<div style="max-width: 520px; margin: 60px auto; padding: 32px; background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 4px;">
    
    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
        <div style="width: 36px; height: 36px; border-radius: 3px; background: var(--color-blue-bg); border: 1px solid var(--color-blue); display: flex; align-items: center; justify-content: center; flex: none;">
            <svg width="18" height="18" viewBox="0 0 16 16" fill="none" stroke="var(--color-blue-fg)" stroke-width="1.6">
                <rect x="2" y="3" width="12" height="10" rx="1.5"></rect>
                <path d="M2 5l6 4 6-4"></path>
            </svg>
        </div>
        <div>
            <h1 style="font: 600 20px/1.2 var(--font-serif); color: #f2f4f6; margin: 0;">
                {{ __('messages.verify_email_title') }}
            </h1>
            <span style="font: 400 11px/1 var(--font-mono); color: var(--text-muted);">
                {{ auth()->user()->email }}
            </span>
        </div>
    </div>

    <p style="font-size: 13px; line-height: 1.6; color: var(--text-secondary); margin-bottom: 24px;">
        {{ __('messages.verify_email_body') }}
    </p>

    @if (session('success'))
        <div style="margin-bottom: 20px; padding: 10px 14px; background: var(--color-clean-bg); border: 1px solid var(--color-clean-border); border-radius: 3px; font-size: 12px; color: var(--color-clean-fg);">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary" style="padding: 10px 16px; font-size: 12px;">
                {{ __('messages.resend_verification_email') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-secondary" style="padding: 10px 16px; font-size: 12px;">
                {{ __('messages.logout') }}
            </button>
        </form>
    </div>

</div>
@endsection
