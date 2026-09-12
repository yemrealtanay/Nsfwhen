@extends('layouts.app')

@section('title', '500 — Server Error')

@section('content')
<div style="max-width: 560px; margin: 80px auto; padding: 40px 32px; background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 4px; text-align: center;">
    <div style="font: 700 54px/1 var(--font-mono); color: var(--color-sex); margin-bottom: 12px; letter-spacing: -0.04em;">
        500
    </div>
    <h1 style="font: 600 24px/1.2 var(--font-serif); color: #f2f4f6; margin-bottom: 12px;">
        {{ app()->getLocale() === 'tr' ? 'Sunucu Hatası Oluştu' : 'Internal Server Error' }}
    </h1>
    <p style="font-size: 13px; line-height: 1.6; color: var(--text-secondary); max-width: 420px; margin: 0 auto 26px;">
        {{ app()->getLocale() === 'tr' 
            ? 'Beklenmedik bir sorun meydana geldi. Teknik ekibimiz durumdan haberdar edildi, lütfen biraz sonra tekrar deneyin.' 
            : 'An unexpected issue occurred. Our technical team has been notified, please try again shortly.' }}
    </p>

    <div style="display: flex; justify-content: center; gap: 12px;">
        <a href="{{ route('welcome') }}" class="btn btn-primary" style="padding: 10px 18px; font-size: 12px;">
            {{ app()->getLocale() === 'tr' ? 'Ana Sayfaya Dön' : 'Back to Home' }}
        </a>
    </div>
</div>
@endsection
