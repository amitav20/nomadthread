<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Banner;
use App\Models\Page;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Get all categories.
     */
    public function categories()
    {
        $categories = Category::where('status', 'active')->get();
        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }

    /**
     * Get products, optionally filtered by category.
     */
    public function products(Request $request)
    {
        $query = Product::with(['category', 'images'])->where('status', 'active');

        if ($request->has('category') && $request->input('category') !== 'all') {
            $categorySlug = $request->input('category');
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        if ($request->has('new') && $request->input('new') == 1) {
            $query->where('badge', 'new');
        }

        if ($request->has('sku')) {
            $query->where('sku', $request->input('sku'));
        }

        if ($request->has('id')) {
            $query->where('id', $request->input('id'));
        }

        $products = $query->get();

        // Map colors & sizes back to arrays for JSON readability
        $products->transform(function ($product) {
            $product->colors = $product->colors ? explode(',', $product->colors) : [];
            $product->sizes = $product->sizes ? explode(',', $product->sizes) : [];
            $product->oldPrice = $product->old_price;
            $product->category_slug = $product->category ? $product->category->slug : '';
            return $product;
        });

        return response()->json([
            'status' => 'success',
            'data' => $products
        ]);
    }

    /**
     * Get active banners.
     */
    public function banners()
    {
        $banners = Banner::where('status', 'active')->orderBy('sort_order', 'asc')->get();
        return response()->json([
            'status' => 'success',
            'data' => $banners
        ]);
    }

    /**
     * Get active pages.
     */
    public function pages()
    {
        $pages = Page::where('status', 'Published')->get();
        return response()->json([
            'status' => 'success',
            'data' => $pages
        ]);
    }
}
