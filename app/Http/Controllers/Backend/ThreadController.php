<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\DatabaseService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function index()
    {
        DatabaseService::getConnection();

        $threads = \App\Models\Thread::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('backend.threads.index', compact('threads'));
    }

    public function destroy($id)
    {
        DatabaseService::getConnection();

        $thread = \App\Models\Thread::findOrFail($id);
        $thread->delete();

        return redirect()->route('backend.threads.index')->with('success', 'Thread deleted successfully.');
    }
}
