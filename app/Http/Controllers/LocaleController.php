<?php

namespace App\Http\Controllers;

class LocaleController
{
    public function switch(string $lang)
    {
        if (in_array($lang, ['tr', 'en'])) {
            session(['locale' => $lang]);

            if (auth()->check()) {
                auth()->user()->update(['locale' => $lang]);
            }
        }

        return redirect()->back();
    }
}
