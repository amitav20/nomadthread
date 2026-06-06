<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\DatabaseService;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $mysqli = DatabaseService::getConnection();

        // 1. Get statistics
        $stats = [
            'users_count' => 0,
            'threads_count' => 0,
            'active_threads' => 0,
            'archived_threads' => 0,
        ];

        if ($result = $mysqli->query("SELECT COUNT(*) as count FROM users")) {
            $row = $result->fetch_assoc();
            $stats['users_count'] = $row['count'] ?? 0;
        }

        if ($result = $mysqli->query("SELECT COUNT(*) as count FROM threads")) {
            $row = $result->fetch_assoc();
            $stats['threads_count'] = $row['count'] ?? 0;
        }

        if ($result = $mysqli->query("SELECT COUNT(*) as count FROM threads WHERE status = 'active'")) {
            $row = $result->fetch_assoc();
            $stats['active_threads'] = $row['count'] ?? 0;
        }

        if ($result = $mysqli->query("SELECT COUNT(*) as count FROM threads WHERE status = 'archived'")) {
            $row = $result->fetch_assoc();
            $stats['archived_threads'] = $row['count'] ?? 0;
        }

        // 2. Get recent 5 threads
        $recentThreads = [];
        $queryRecent = "
            SELECT t.*, u.name as user_name 
            FROM threads t 
            JOIN users u ON t.user_id = u.id 
            ORDER BY t.created_at DESC 
            LIMIT 5
        ";
        if ($resultRecent = $mysqli->query($queryRecent)) {
            while ($row = $resultRecent->fetch_object()) {
                $row->user = (object) ['name' => $row->user_name];
                $row->created_at = Carbon::parse($row->created_at);
                $recentThreads[] = $row;
            }
        }

        // 3. Get location hotspots
        $locations = [];
        $queryLocations = "
            SELECT location, COUNT(*) as total 
            FROM threads 
            GROUP BY location 
            ORDER BY total DESC
        ";
        if ($resultLocations = $mysqli->query($queryLocations)) {
            while ($row = $resultLocations->fetch_object()) {
                $locations[] = $row;
            }
        }

        return view('backend.dashboard', compact('stats', 'recentThreads', 'locations'));
    }
}
