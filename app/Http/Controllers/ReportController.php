<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Scene;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController
{
    public function store(Request $request)
    {
        if (! auth()->check()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $validated = $request->validate([
            'type' => ['required', 'in:scene,user'],
            'id' => ['required', 'integer'],
            'reason' => ['required', 'string', 'max:1000'],
        ]);

        $modelClass = $validated['type'] === 'scene' ? Scene::class : User::class;
        $target = $modelClass::findOrFail($validated['id']);

        $report = Report::create([
            'reportable_type' => $modelClass,
            'reportable_id' => $target->id,
            'reporter_id' => auth()->id(),
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('messages.reported_success'),
            ]);
        }

        return back()->with('success', __('messages.reported_success'));
    }
}
