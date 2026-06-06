<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $api;

    public function __construct(ApiController $api)
    {
        $this->api = $api;
    }

    public function index(Request $request)
    {
        $productsResponse = $this->api->products($request);
        $categoriesResponse = $this->api->categories();
        $bannersResponse = $this->api->banners();

        $products = json_decode($productsResponse->getContent(), true)['data'] ?? [];
        $categories = json_decode($categoriesResponse->getContent(), true)['data'] ?? [];
        $banners = json_decode($bannersResponse->getContent(), true)['data'] ?? [];

        return view('frontend.shop.index', compact('products', 'categories', 'banners'));
    }

    /**
     * Show category-specific shop page.
     */
    public function category(Request $request, $slug)
    {
        // Merge the category filter into the request
        $request->merge(['category' => $slug]);
        
        $productsResponse = $this->api->products($request);
        $categoriesResponse = $this->api->categories();
        $bannersResponse = $this->api->banners();

        $products = json_decode($productsResponse->getContent(), true)['data'] ?? [];
        $categories = json_decode($categoriesResponse->getContent(), true)['data'] ?? [];
        $banners = json_decode($bannersResponse->getContent(), true)['data'] ?? [];
        
        // Find current category
        $currentCategory = collect($categories)->firstWhere('slug', $slug);
        if (!$currentCategory) {
            abort(404);
        }

        return view('frontend.shop.category', compact('products', 'categories', 'currentCategory', 'banners'));
    }

    /**
     * Show product details page.
     */
    public function show(Request $request, $sku)
    {
        $request->merge(['sku' => $sku]);
        $productsResponse = $this->api->products($request);
        $categoriesResponse = $this->api->categories();

        $products = json_decode($productsResponse->getContent(), true)['data'] ?? [];
        $categories = json_decode($categoriesResponse->getContent(), true)['data'] ?? [];

        $product = collect($products)->first();
        if (!$product) {
            abort(404);
        }

        return view('frontend.shop.product', compact('product', 'categories'));
    }
}
