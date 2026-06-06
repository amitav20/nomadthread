<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\DatabaseService;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $mysqli = DatabaseService::getConnection();
        $users = [];

        $query = "
            SELECT u.*, COUNT(t.id) as threads_count 
            FROM users u 
            LEFT JOIN threads t ON u.id = t.user_id 
            GROUP BY u.id 
            ORDER BY u.created_at DESC
        ";

        if ($result = $mysqli->query($query)) {
            while ($row = $result->fetch_object()) {
                $row->created_at = Carbon::parse($row->created_at);
                $users[] = $row;
            }
        }

        return view('backend.users.index', compact('users'));
    }
}
