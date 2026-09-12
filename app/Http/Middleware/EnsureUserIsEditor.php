<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsEditor
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login')->with('error', __('messages.login_required'));
        }

        if (! auth()->user()->isEditor()) {
            abort(403, 'Unauthorized. Editor access required.');
        }

        return $next($request);
    }
}
