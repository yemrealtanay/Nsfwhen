@extends('layouts.app')

@section('title', '419 — Page Expired')

@section('content')
<div style="max-width: 560px; margin: 80px auto; padding: 40px 32px; background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 4px; text-align: center;">
    <div style="font: 700 54px/1 var(--font-mono); color: var(--color-suggestive); margin-bottom: 12px; letter-spacing: -0.04em;">
        419
    </div>
    <h1 style="font: 600 24px/1.2 var(--font-serif); color: #f2f4f6; margin-bottom: 12px;">
        {{ app()->getLocale() === 'tr' ? 'Oturum Süreniz Doldu' : 'Session Expired' }}
    </h1>
    <p style="font-size: 13px; line-height: 1.6; color: var(--text-secondary); max-width: 420px; margin: 0 auto 26px;">
        {{ app()->getLocale() === 'tr' 
            ? 'Güvenlik amacıyla form oturum süreniz doldu. Lütfen sayfayı yenileyip işleminizi tekrarlayın.' 
            : 'For security reasons, your form session has timed out. Please refresh the page and try again.' }}
    </p>

    <div style="display: flex; justify-content: center; gap: 12px;">
        <button onclick="window.location.reload();" class="btn btn-primary" style="padding: 10px 18px; font-size: 12px;">
            {{ app()->getLocale() === 'tr' ? 'Sayfayı Yenile' : 'Refresh Page' }}
        </button>
    </div>
</div>
@endsection
