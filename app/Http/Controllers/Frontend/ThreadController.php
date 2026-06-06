<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\DatabaseService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function index(Request $request)
    {
        DatabaseService::getConnection();

        $search = $request->input('search');
        if (!empty($search)) {
            $threads = \App\Models\Thread::with('user')
                ->where('status', 'active')
                ->where(function($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                      ->orWhere('location', 'like', '%' . $search . '%');
                })
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $threads = \App\Models\Thread::with('user')
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $banners = \App\Models\Banner::where('status', 'active')->orderBy('sort_order', 'asc')->get();

        return view('frontend.threads.index', compact('threads', 'banners'));
    }

    public function show($id)
    {
        DatabaseService::getConnection();

        $thread = \App\Models\Thread::with('user')->findOrFail($id);

        return view('frontend.threads.show', compact('thread'));
    }
}
