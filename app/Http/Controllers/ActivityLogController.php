<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless(auth()->user()->can('view activity logs'), 403);

        $search = $request->input('search');
        $action = $request->input('action');

        $logs = ActivityLog::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where('description', 'like', "%{$search}%");
            })
            ->when($action, fn ($query) => $query->where('action', $action))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $actions = ActivityLog::distinct()->pluck('action');

        return view('activity-logs.index', compact('logs', 'search', 'action', 'actions'));
    }
}
