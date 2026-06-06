<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\DatabaseService;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        DatabaseService::getConnection();

        // 1. Get statistics
        $stats = [
            'users_count' => \App\Models\User::count(),
            'threads_count' => \App\Models\Thread::count(),
            'active_threads' => \App\Models\Thread::where('status', 'active')->count(),
            'archived_threads' => \App\Models\Thread::where('status', 'archived')->count(),
        ];

        // 2. Get recent 5 threads
        $recentThreads = \App\Models\Thread::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // 3. Get location hotspots
        $locations = \App\Models\Thread::select('location', \Illuminate\Support\Facades\DB::raw('COUNT(*) as total'))
            ->groupBy('location')
            ->orderBy('total', 'desc')
            ->get();

        return view('backend.dashboard', compact('stats', 'recentThreads', 'locations'));
    }
}
