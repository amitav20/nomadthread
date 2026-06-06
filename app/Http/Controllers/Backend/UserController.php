<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\DatabaseService;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        DatabaseService::getConnection();

        $users = \App\Models\User::withCount('threads')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('backend.users.index', compact('users'));
    }
}
