<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Archive;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalArchives = Archive::count();
        $totalUsers = User::count();
        $totalAdmins = User::role(['Super Admin', 'Admin'])->count();
        $uploadsToday = Archive::whereDate('created_at', today())->count();

        $recentArchives = Archive::with('uploader')
            ->latest()
            ->limit(5)
            ->get();

        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->limit(8)
            ->get();

        $canCreateArchive = auth()->user()->can('create archives');
        $canManageUsers = auth()->user()->can('view users');

        return view('dashboard', compact(
            'totalArchives',
            'totalUsers',
            'totalAdmins',
            'uploadsToday',
            'recentArchives',
            'recentActivities',
            'canCreateArchive',
            'canManageUsers'
        ));
    }
}
