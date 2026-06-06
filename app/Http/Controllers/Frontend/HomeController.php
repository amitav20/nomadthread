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
        DatabaseService::getConnection();

        // 1. Get user count
        $userCount = \App\Models\User::count();

        // 2. Get thread count
        $threadCount = \App\Models\Thread::count();

        // 3. Get 3 most recent active threads along with the user name
        $featuredThreads = \App\Models\Thread::with('user')
            ->where('status', 'active')
            ->latest()
            ->limit(3)
            ->get();

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
