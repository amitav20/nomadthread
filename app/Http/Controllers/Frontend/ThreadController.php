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
        $mysqli = DatabaseService::getConnection();
        $threads = [];

        $search = $request->input('search');
        if (!empty($search)) {
            $searchTerm = '%' . $search . '%';
            $stmt = $mysqli->prepare("
                SELECT t.*, u.name as user_name 
                FROM threads t 
                JOIN users u ON t.user_id = u.id 
                WHERE t.status = 'active' 
                  AND (t.title LIKE ? OR t.location LIKE ?) 
                ORDER BY t.created_at DESC
            ");
            if ($stmt) {
                $stmt->bind_param("ss", $searchTerm, $searchTerm);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
            } else {
                $result = false;
            }
        } else {
            $query = "
                SELECT t.*, u.name as user_name 
                FROM threads t 
                JOIN users u ON t.user_id = u.id 
                WHERE t.status = 'active' 
                ORDER BY t.created_at DESC
            ";
            $result = $mysqli->query($query);
        }

        if ($result) {
            while ($row = $result->fetch_object()) {
                $row->user = (object) ['name' => $row->user_name];
                $row->created_at = Carbon::parse($row->created_at);
                $threads[] = $row;
            }
        }

        $banners = \App\Models\Banner::where('status', 'active')->orderBy('sort_order', 'asc')->get();

        return view('frontend.threads.index', compact('threads', 'banners'));
    }

    public function show($id)
    {
        $mysqli = DatabaseService::getConnection();

        $stmt = $mysqli->prepare("
            SELECT t.*, u.name as user_name 
            FROM threads t 
            JOIN users u ON t.user_id = u.id 
            WHERE t.id = ? 
            LIMIT 1
        ");
        
        if (!$stmt) {
            abort(500, "Database statement error");
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $thread = $result->fetch_object();
        $stmt->close();

        if (!$thread) {
            abort(404, "Thread not found");
        }

        $thread->user = (object) ['name' => $thread->user_name];
        $thread->created_at = Carbon::parse($thread->created_at);

        return view('frontend.threads.show', compact('thread'));
    }
}
