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
        $mysqli = DatabaseService::getConnection();
        $threads = [];

        $query = "
            SELECT t.*, u.name as user_name 
            FROM threads t 
            JOIN users u ON t.user_id = u.id 
            ORDER BY t.created_at DESC
        ";

        if ($result = $mysqli->query($query)) {
            while ($row = $result->fetch_object()) {
                $row->user = (object) ['name' => $row->user_name];
                $row->created_at = Carbon::parse($row->created_at);
                $threads[] = $row;
            }
        }

        return view('backend.threads.index', compact('threads'));
    }

    public function destroy($id)
    {
        $mysqli = DatabaseService::getConnection();

        $stmt = $mysqli->prepare("DELETE FROM threads WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        }

        return redirect()->route('backend.threads.index')->with('success', 'Thread deleted successfully.');
    }
}
