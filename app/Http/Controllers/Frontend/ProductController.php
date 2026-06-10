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

    /**
     * Show checkout page.
     */
    public function checkout(Request $request)
    {
        $categoriesResponse = $this->api->categories();
        $categories = json_decode($categoriesResponse->getContent(), true)['data'] ?? [];
        return view('frontend.shop.checkout', compact('categories'));
    }

    /**
     * Submit checkout dynamically.
     */
    public function submitCheckout(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'subtotal' => 'required|integer',
            'tax' => 'required|integer',
            'discount' => 'nullable|integer',
            'total' => 'required|integer',
            'payment_method' => 'required|string',
            'items_summary' => 'required|string',
        ]);

        $orderNumber = 'ORD-' . rand(100000, 999999);

        // Save order to the database
        $order = \App\Models\Order::create([
            'order_number' => $orderNumber,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'shipping_address' => $request->shipping_address,
            'subtotal' => $request->subtotal,
            'tax' => $request->tax,
            'discount' => $request->discount ?: 0,
            'total' => $request->total,
            'status' => 'Pending',
            'payment_status' => 'Paid',
            'payment_method' => $request->payment_method,
            'shipping_method' => 'Standard Express',
            'notes' => $request->items_summary,
        ]);

        return response()->json([
            'status' => 'success',
            'order_number' => $orderNumber,
        ]);
    }

    /**
     * Show order confirmation page.
     */
    public function orderConfirmation(Request $request, $orderNumber)
    {
        $order = \App\Models\Order::where('order_number', $orderNumber)->firstOrFail();
        $categoriesResponse = $this->api->categories();
        $categories = json_decode($categoriesResponse->getContent(), true)['data'] ?? [];
        return view('frontend.shop.confirmation', compact('order', 'categories'));
    }
}
