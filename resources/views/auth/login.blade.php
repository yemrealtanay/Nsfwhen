@extends('layouts.app')

@section('content')
<div class="app-container" style="max-width: 420px; padding-top: 48px;">

    <div style="border: 1px solid var(--border-medium); border-radius: 4px; background: var(--bg-card); overflow: hidden;">
        <div style="padding: 12px 18px; border-bottom: 1px solid var(--border-default); background: var(--bg-surface); font: 500 10px/1 var(--font-mono); color: var(--text-muted); letter-spacing: .08em;">
            ACCOUNT ACCESS
        </div>

        <form action="{{ route('login') }}" method="POST" style="padding: 24px; display: flex; flex-direction: column; gap: 16px;">
            @csrf

            <h1 style="font: 700 22px/1.2 var(--font-serif); color: #f2f4f6;">
                {{ __('messages.login') }}
            </h1>

            @if($errors->any())
                <div style="padding: 8px 12px; background: #231a1b; border: 1px solid #4a3033; color: #e8938e; border-radius: 2px; font-size: 11px;">
                    {{ $errors->first() }}
                </div>
            @endif

            <div style="display: flex; flex-direction: column; gap: 6px;">
                <label style="font: 500 9px/1 var(--font-mono); color: var(--text-muted); letter-spacing: .08em;">EMAIL</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       style="background: #1b1f24; border: 1px solid var(--border-strong); border-radius: 2px; padding: 9px 12px; color: #e6e8eb; font-size: 13px;">
            </div>

            <div style="display: flex; flex-direction: column; gap: 6px;">
                <label style="font: 500 9px/1 var(--font-mono); color: var(--text-muted); letter-spacing: .08em;">PASSWORD</label>
                <input type="password" name="password" required
                       style="background: #1b1f24; border: 1px solid var(--border-strong); border-radius: 2px; padding: 9px 12px; color: #e6e8eb; font-size: 13px;">
            </div>

            <label style="display: flex; align-items: center; gap: 8px; font-size: 11px; color: var(--text-secondary); cursor: pointer;">
                <input type="checkbox" name="remember" style="accent-color: var(--color-blue);">
                Remember this device
            </label>

            <button type="submit" class="btn btn-primary" style="justify-content: center; padding: 11px; font-size: 12px;">
                {{ __('messages.login') }}
            </button>

            <div style="font-size: 11px; color: var(--text-muted); text-align: center; margin-top: 6px;">
                Don't have an account? <a href="{{ route('register') }}" style="color: var(--color-blue-link);">{{ __('messages.register') }}</a>
            </div>
        </form>
    </div>

</div>
@endsection
