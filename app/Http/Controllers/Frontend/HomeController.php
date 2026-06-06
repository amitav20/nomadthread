<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiController;
use App\Services\DatabaseService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $api;

    public function __construct(ApiController $api)
    {
        $this->api = $api;
    }

    public function index(Request $request)
    {
        $mysqli = DatabaseService::getConnection();

        // 1. Get user count
        $userCount = 0;
        if ($result = $mysqli->query("SELECT COUNT(*) as count FROM users")) {
            $row = $result->fetch_assoc();
            $userCount = $row['count'] ?? 0;
        }

        // 2. Get thread count
        $threadCount = 0;
        if ($result = $mysqli->query("SELECT COUNT(*) as count FROM threads")) {
            $row = $result->fetch_assoc();
            $threadCount = $row['count'] ?? 0;
        }

        // 3. Get 3 most recent active threads along with the user name
        $featuredThreads = [];
        $query = "
            SELECT t.*, u.name as user_name 
            FROM threads t 
            JOIN users u ON t.user_id = u.id 
            WHERE t.status = 'active' 
            ORDER BY t.created_at DESC 
            LIMIT 3
        ";
        if ($result = $mysqli->query($query)) {
            while ($row = $result->fetch_object()) {
                // Mock the Eloquent relation so Blade doesn't break
                $row->user = (object) ['name' => $row->user_name];
                $row->created_at = Carbon::parse($row->created_at);
                $featuredThreads[] = $row;
            }
        }

        // 4. Fetch e-commerce data from API and decode
        $bannersResponse = $this->api->banners();
        $categoriesResponse = $this->api->categories();
        $productsResponse = $this->api->products($request);

        $banners = json_decode($bannersResponse->getContent(), true)['data'] ?? [];
        $categories = json_decode($categoriesResponse->getContent(), true)['data'] ?? [];
        $products = json_decode($productsResponse->getContent(), true)['data'] ?? [];

        return view('frontend.home', compact(
            'threadCount', 
            'userCount', 
            'featuredThreads',
            'banners',
            'categories',
            'products'
        ));
    }

    public function showPage($slug)
    {
        $page = \App\Models\Page::where('slug', $slug)->where('status', 'Published')->firstOrFail();
        
        // Load active banners to see if there is any banner assigned to this custom page
        $bannersResponse = $this->api->banners();
        $banners = json_decode($bannersResponse->getContent(), true)['data'] ?? [];
        
        $pageBanner = collect($banners)->first(function ($b) use ($slug) {
            return strtolower($b['position']) === strtolower($slug) || strtolower($b['position']) === 'custom page';
        });

        return view('frontend.page', compact('page', 'pageBanner'));
    }
}
