<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController
{
    /**
     * Display Terms of Service / Guidelines page.
     */
    public function terms(Request $request)
    {
        return view('legal.terms');
    }

    /**
     * Display Privacy Policy & GDPR agreement page.
     */
    public function privacy(Request $request)
    {
        return view('legal.privacy');
    }
}
