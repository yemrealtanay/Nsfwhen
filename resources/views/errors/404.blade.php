@extends('layouts.app')

@section('title', '404 — Not Found')

@section('content')
<div style="max-width: 560px; margin: 80px auto; padding: 40px 32px; background: var(--bg-card); border: 1px solid var(--border-default); border-radius: 4px; text-align: center;">
    <div style="font: 700 54px/1 var(--font-mono); color: var(--color-coral); margin-bottom: 12px; letter-spacing: -0.04em;">
        404
    </div>
    <h1 style="font: 600 24px/1.2 var(--font-serif); color: #f2f4f6; margin-bottom: 12px;">
        {{ app()->getLocale() === 'tr' ? 'Film veya Sayfa Bulunamadı' : 'Film or Page Not Found' }}
    </h1>
    <p style="font-size: 13px; line-height: 1.6; color: var(--text-secondary); max-width: 420px; margin: 0 auto 26px;">
        {{ app()->getLocale() === 'tr' 
            ? 'Aradığınız sayfa silinmiş, adı değiştirilmiş veya henüz kataloğa eklenmemiş olabilir.' 
            : 'The page you are looking for might have been removed, had its name changed, or has not been indexed yet.' }}
    </p>

    <div style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;">
        <a href="{{ route('home') }}" class="btn btn-primary" style="padding: 10px 18px; font-size: 12px;">
            {{ app()->getLocale() === 'tr' ? 'Kataloğa Göz At' : 'Browse Catalog' }}
        </a>
        <a href="{{ route('welcome') }}" class="btn btn-secondary" style="padding: 10px 18px; font-size: 12px;">
            {{ app()->getLocale() === 'tr' ? 'Ana Sayfaya Dön' : 'Back to Home' }}
        </a>
    </div>
</div>
@endsection
