<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\Review;
use App\Models\Banner;
use App\Models\Page;
use App\Models\User;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $productsCount = Product::count();
        $categoriesCount = Category::count();
        $ordersCount = Order::count();
        $reviewsCount = Review::count();
        $bannersCount = Banner::count();
        $pagesCount = Page::count();
        $customersCount = User::count();

        $totalRevenue = Order::where('status', 'Completed')->sum('total');
        if ($totalRevenue == 0) {
            $totalRevenue = Order::sum('total') ?: 184500;
        }

        $recentOrders = Order::orderBy('created_at', 'desc')->limit(5)->get();
        $recentProducts = Product::with(['category', 'images'])->orderBy('created_at', 'desc')->limit(5)->get();

        return view('backend.admin.dashboard', compact(
            'productsCount',
            'categoriesCount',
            'ordersCount',
            'reviewsCount',
            'bannersCount',
            'pagesCount',
            'customersCount',
            'totalRevenue',
            'recentOrders',
            'recentProducts'
        ));
    }

    public function analytics()
    {
        return view('backend.admin.analytics');
    }

    public function productsIndex()
    {
        $products = Product::with(['category', 'images'])->orderBy('id', 'desc')->get();
        return view('backend.admin.products.index', compact('products'));
    }

    public function productsCreate()
    {
        $categories = Category::all();
        return view('backend.admin.products.create', compact('categories'));
    }

    public function productsStore(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'type' => 'nullable|string',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'colors' => 'nullable|string',
            'sizes' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'shape' => 'nullable|string',
            'stock_quantity' => 'required|integer',
            'low_stock_alert' => 'nullable|integer',
            'badge' => 'nullable|string',
            'gender' => 'nullable|string|in:unisex,men,women',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'sku' => $request->sku,
            'type' => $request->type,
            'price' => $request->price,
            'old_price' => $request->old_price,
            'colors' => $request->colors ?: 'tan,espresso,black',
            'sizes' => $request->sizes ?: 'N/A',
            'description' => $request->description,
            'status' => $request->status,
            'shape' => $request->shape ?: 'bag-shape',
            'stock_quantity' => $request->stock_quantity,
            'low_stock_alert' => $request->low_stock_alert ?: 10,
            'stock_status' => $request->stock_quantity > 0 ? 'In Stock' : 'Out of Stock',
            'badge' => $request->badge,
            'gender' => $request->gender ?: 'unisex',
        ]);

        // Upload and save product images securely
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            foreach ($files as $index => $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = md5(uniqid() . time() . $index) . '.' . $extension;
                $path = $file->storeAs('products/' . $product->id, $filename, 'public');
                
                $dimensions = @getimagesize($file->getRealPath());
                $width = $dimensions[0] ?? null;
                $height = $dimensions[1] ?? null;

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => '/uploads/' . $path,
                    'alt_text' => $product->name,
                    'is_primary' => ($index === 0),
                    'sort_order' => $index,
                    'width' => $width,
                    'height' => $height,
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getClientMimeType(),
                ]);
            }
        }

        return redirect()->route('backend.products.index')->with('success', 'Product created successfully.');
    }

    public function productsEdit($id)
    {
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::all();
        return view('backend.admin.products.edit', compact('product', 'categories'));
    }

    public function productsUpdate(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,' . $id,
            'type' => 'nullable|string',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'colors' => 'nullable|string',
            'sizes' => 'nullable|string',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'shape' => 'nullable|string',
            'stock_quantity' => 'required|integer',
            'low_stock_alert' => 'nullable|integer',
            'badge' => 'nullable|string',
            'gender' => 'nullable|string|in:unisex,men,women',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'sku' => $request->sku,
            'type' => $request->type,
            'price' => $request->price,
            'old_price' => $request->old_price,
            'colors' => $request->colors ?: 'tan,espresso,black',
            'sizes' => $request->sizes ?: 'N/A',
            'description' => $request->description,
            'status' => $request->status,
            'shape' => $request->shape ?: 'bag-shape',
            'stock_quantity' => $request->stock_quantity,
            'low_stock_alert' => $request->low_stock_alert ?: 10,
            'stock_status' => $request->stock_quantity > 0 ? 'In Stock' : 'Out of Stock',
            'badge' => $request->badge,
            'gender' => $request->gender ?: 'unisex',
        ]);

        // Manage existing images deletions
        if ($request->has('delete_images')) {
            foreach ($request->input('delete_images') as $imgId) {
                $img = ProductImage::where('product_id', $product->id)->find($imgId);
                if ($img) {
                    $relativePath = str_replace('/uploads/', '', $img->image_path);
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($relativePath);
                    $img->delete();
                }
            }
        }

        // Update alts and sorting orders
        if ($request->has('alt_texts')) {
            foreach ($request->input('alt_texts') as $imgId => $altText) {
                ProductImage::where('id', $imgId)->where('product_id', $product->id)->update([
                    'alt_text' => $altText,
                ]);
            }
        }

        if ($request->has('sort_orders')) {
            foreach ($request->input('sort_orders') as $imgId => $sortOrder) {
                ProductImage::where('id', $imgId)->where('product_id', $product->id)->update([
                    'sort_order' => (int) $sortOrder,
                ]);
            }
        }

        // Set primary image
        if ($request->has('is_primary_id')) {
            $primaryId = $request->input('is_primary_id');
            ProductImage::where('product_id', $product->id)->update(['is_primary' => false]);
            ProductImage::where('id', $primaryId)->where('product_id', $product->id)->update(['is_primary' => true]);
        }

        // Upload new images
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            $hasPrimary = ProductImage::where('product_id', $product->id)->where('is_primary', true)->exists();
            
            foreach ($files as $index => $file) {
                $extension = $file->getClientOriginalExtension();
                $filename = md5(uniqid() . time() . $index) . '.' . $extension;
                $path = $file->storeAs('products/' . $product->id, $filename, 'public');
                
                $dimensions = @getimagesize($file->getRealPath());
                $width = $dimensions[0] ?? null;
                $height = $dimensions[1] ?? null;

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => '/uploads/' . $path,
                    'alt_text' => $product->name,
                    'is_primary' => (!$hasPrimary && $index === 0),
                    'sort_order' => ProductImage::where('product_id', $product->id)->max('sort_order') + 1,
                    'width' => $width,
                    'height' => $height,
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getClientMimeType(),
                ]);
                $hasPrimary = true;
            }
        }

        return redirect()->route('backend.products.index')->with('success', 'Product updated successfully.');
    }

    public function productsDestroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('backend.products.index')->with('success', 'Product deleted successfully.');
    }

    public function categoriesIndex()
    {
        $categories = Category::withCount('products')->get();
        return view('backend.admin.categories.index', compact('categories'));
    }

    public function categoriesCreate()
    {
        return view('backend.admin.categories.create');
    }

    public function categoriesStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'status' => 'required|string',
            'accent_color' => 'nullable|string',
            'gender' => 'nullable|string|in:men,women,both',
            'image_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'video' => 'nullable|mimes:mp4,mov,ogg,qt,webm|max:20480',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'icon' => $request->icon ?: '👜',
            'status' => $request->status,
            'accent_color' => $request->accent_color ?: '#c9a84c',
            'gender' => $request->gender ?: 'both',
        ]);

        $uploadedData = [];
        if ($request->hasFile('image_banner')) {
            $file = $request->file('image_banner');
            $filename = 'banner_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('categories/' . $category->id, $filename, 'public');
            $uploadedData['image_banner'] = '/uploads/' . $path;
        }

        if ($request->hasFile('image_thumbnail')) {
            $file = $request->file('image_thumbnail');
            $filename = 'thumbnail_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('categories/' . $category->id, $filename, 'public');
            $uploadedData['image_thumbnail'] = '/uploads/' . $path;
        }

        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $filename = 'video_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('categories/' . $category->id, $filename, 'public');
            $uploadedData['video'] = '/uploads/' . $path;
        }

        if (!empty($uploadedData)) {
            $category->update($uploadedData);
        }

        return redirect()->route('backend.categories.index')->with('success', 'Category created successfully.');
    }

    public function categoriesEdit($id)
    {
        $category = Category::findOrFail($id);
        return view('backend.admin.categories.edit', compact('category'));
    }

    public function categoriesUpdate(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:categories,slug,' . $id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'status' => 'required|string',
            'accent_color' => 'nullable|string',
            'gender' => 'nullable|string|in:men,women,both',
            'image_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'video' => 'nullable|mimes:mp4,mov,ogg,qt,webm|max:20480',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'icon' => $request->icon ?: '👜',
            'status' => $request->status,
            'accent_color' => $request->accent_color ?: '#c9a84c',
            'gender' => $request->gender ?: 'both',
        ];

        if ($request->hasFile('image_banner')) {
            if ($category->image_banner) {
                $oldPath = str_replace('/uploads/', '', $category->image_banner);
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
            }
            $file = $request->file('image_banner');
            $filename = 'banner_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('categories/' . $category->id, $filename, 'public');
            $data['image_banner'] = '/uploads/' . $path;
        }

        if ($request->hasFile('image_thumbnail')) {
            if ($category->image_thumbnail) {
                $oldPath = str_replace('/uploads/', '', $category->image_thumbnail);
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
            }
            $file = $request->file('image_thumbnail');
            $filename = 'thumbnail_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('categories/' . $category->id, $filename, 'public');
            $data['image_thumbnail'] = '/uploads/' . $path;
        }

        if ($request->hasFile('video')) {
            if ($category->video) {
                $oldPath = str_replace('/uploads/', '', $category->video);
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
            }
            $file = $request->file('video');
            $filename = 'video_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('categories/' . $category->id, $filename, 'public');
            $data['video'] = '/uploads/' . $path;
        }

        if ($request->input('delete_banner') == 1 && $category->image_banner) {
            $oldPath = str_replace('/uploads/', '', $category->image_banner);
            \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
            $data['image_banner'] = null;
        }
        if ($request->input('delete_thumbnail') == 1 && $category->image_thumbnail) {
            $oldPath = str_replace('/uploads/', '', $category->image_thumbnail);
            \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
            $data['image_thumbnail'] = null;
        }
        if ($request->input('delete_video') == 1 && $category->video) {
            $oldPath = str_replace('/uploads/', '', $category->video);
            \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
            $data['video'] = null;
        }

        $category->update($data);

        return redirect()->route('backend.categories.index')->with('success', 'Category updated successfully.');
    }

    public function categoriesDestroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('backend.categories.index')->with('success', 'Category deleted successfully.');
    }

    public function inventory()
    {
        $products = Product::orderBy('stock_quantity', 'asc')->get();
        return view('backend.admin.inventory', compact('products'));
    }

    public function orders()
    {
        $orders = Order::orderBy('id', 'desc')->get();
        return view('backend.admin.orders', compact('orders'));
    }

    public function customers()
    {
        $customers = User::orderBy('id', 'desc')->get();
        return view('backend.admin.customers', compact('customers'));
    }

    public function reviews()
    {
        $reviews = Review::with('product')->orderBy('id', 'desc')->get();
        return view('backend.admin.reviews', compact('reviews'));
    }

    public function bannersIndex()
    {
        $banners = Banner::orderBy('sort_order', 'asc')->get();
        return view('backend.admin.banners.index', compact('banners'));
    }

    public function bannersCreate()
    {
        return view('backend.admin.banners.create');
    }

    public function bannersStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'position' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'video' => 'nullable|file|mimes:mp4,webm,ogg,mov|max:20480',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'click_url' => 'nullable|string',
            'headline' => 'nullable|string',
            'subheadline' => 'nullable|string',
            'cta_text' => 'nullable|string',
            'cta_link' => 'nullable|string',
            'text_position' => 'nullable|string',
            'text_color' => 'nullable|string',
            'alt_text' => 'nullable|string',
            'status' => 'required|string',
            'sort_order' => 'required|integer',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = md5(uniqid() . time()) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('banners', $filename, 'public');
            $imagePath = '/uploads/' . $path;
        }

        $videoPath = null;
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $filename = md5(uniqid() . time()) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('banners', $filename, 'public');
            $videoPath = '/uploads/' . $path;
        }

        $imageMobilePath = null;
        if ($request->hasFile('image_mobile')) {
            $file = $request->file('image_mobile');
            $filename = md5(uniqid() . time()) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('banners', $filename, 'public');
            $imageMobilePath = '/uploads/' . $path;
        }

        Banner::create([
            'title' => $request->title,
            'position' => $request->position,
            'image' => $imagePath ?: '',
            'video' => $videoPath,
            'image_mobile' => $imageMobilePath,
            'click_url' => $request->click_url,
            'open_in' => $request->open_in ?: 'same_tab',
            'enable_overlay' => $request->has('enable_overlay'),
            'headline' => $request->headline,
            'subheadline' => $request->subheadline,
            'cta_text' => $request->cta_text,
            'cta_link' => $request->cta_link,
            'text_position' => $request->text_position ?: 'Centre',
            'text_color' => $request->text_color ?: 'White',
            'alt_text' => $request->alt_text,
            'status' => $request->status,
            'sort_order' => $request->sort_order,
            'target_audience' => $request->target_audience ?: 'All Visitors',
        ]);

        return redirect()->route('backend.banners.index')->with('success', 'Banner created successfully.');
    }

    public function bannersEdit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('backend.admin.banners.edit', compact('banner'));
    }

    public function bannersUpdate(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'position' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'video' => 'nullable|file|mimes:mp4,webm,ogg,mov|max:20480',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'click_url' => 'nullable|string',
            'headline' => 'nullable|string',
            'subheadline' => 'nullable|string',
            'cta_text' => 'nullable|string',
            'cta_link' => 'nullable|string',
            'text_position' => 'nullable|string',
            'text_color' => 'nullable|string',
            'alt_text' => 'nullable|string',
            'status' => 'required|string',
            'sort_order' => 'required|integer',
        ]);

        $imagePath = $banner->image;
        if ($request->hasFile('image')) {
            if (!empty($banner->image)) {
                $oldPath = str_replace('/uploads/', '', $banner->image);
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
            }
            $file = $request->file('image');
            $filename = md5(uniqid() . time()) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('banners', $filename, 'public');
            $imagePath = '/uploads/' . $path;
        }

        $videoPath = $banner->video;
        if ($request->hasFile('video')) {
            if (!empty($banner->video)) {
                $oldPath = str_replace('/uploads/', '', $banner->video);
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
            }
            $file = $request->file('video');
            $filename = md5(uniqid() . time()) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('banners', $filename, 'public');
            $videoPath = '/uploads/' . $path;
        }

        if ($request->has('delete_video') && $request->delete_video == 1) {
            if (!empty($banner->video)) {
                $oldPath = str_replace('/uploads/', '', $banner->video);
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
            }
            $videoPath = null;
        }

        $imageMobilePath = $banner->image_mobile;
        if ($request->hasFile('image_mobile')) {
            if (!empty($banner->image_mobile)) {
                $oldPath = str_replace('/uploads/', '', $banner->image_mobile);
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
            }
            $file = $request->file('image_mobile');
            $filename = md5(uniqid() . time()) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('banners', $filename, 'public');
            $imageMobilePath = '/uploads/' . $path;
        }

        $banner->update([
            'title' => $request->title,
            'position' => $request->position,
            'image' => $imagePath,
            'video' => $videoPath,
            'image_mobile' => $imageMobilePath,
            'click_url' => $request->click_url,
            'open_in' => $request->open_in ?: 'same_tab',
            'enable_overlay' => $request->has('enable_overlay'),
            'headline' => $request->headline,
            'subheadline' => $request->subheadline,
            'cta_text' => $request->cta_text,
            'cta_link' => $request->cta_link,
            'text_position' => $request->text_position ?: 'Centre',
            'text_color' => $request->text_color ?: 'White',
            'alt_text' => $request->alt_text,
            'status' => $request->status,
            'sort_order' => $request->sort_order,
            'target_audience' => $request->target_audience ?: 'All Visitors',
        ]);

        return redirect()->route('backend.banners.index')->with('success', 'Banner updated successfully.');
    }

    public function bannersDestroy($id)
    {
        $banner = Banner::findOrFail($id);
        
        if (!empty($banner->image)) {
            $oldPath = str_replace('/uploads/', '', $banner->image);
            \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
        }
        if (!empty($banner->video)) {
            $oldPath = str_replace('/uploads/', '', $banner->video);
            \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
        }
        if (!empty($banner->image_mobile)) {
            $oldPath = str_replace('/uploads/', '', $banner->image_mobile);
            \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
        }

        $banner->delete();
        return redirect()->route('backend.banners.index')->with('success', 'Banner deleted successfully.');
    }

    public function coupons()
    {
        return view('backend.admin.coupons');
    }

    public function pagesIndex()
    {
        $pages = Page::orderBy('id', 'desc')->get();
        return view('backend.admin.pages.index', compact('pages'));
    }

    public function pagesCreate()
    {
        return view('backend.admin.pages.create');
    }

    public function pagesStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:pages,slug',
            'page_type' => 'nullable|string',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'status' => 'required|string',
            'visibility' => 'required|string',
            'schedule_publish' => 'nullable|date',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'focus_keyword' => 'nullable|string',
            'template' => 'required|string',
        ]);

        $featuredImagePath = null;
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = md5(uniqid() . time()) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('pages', $filename, 'public');
            $featuredImagePath = '/uploads/' . $path;
        }

        Page::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'page_type' => $request->page_type ?: 'Custom Page',
            'content' => $request->input('content'),
            'featured_image' => $featuredImagePath,
            'status' => $request->status,
            'visibility' => $request->visibility,
            'schedule_publish' => $request->schedule_publish,
            'show_in_navigation' => $request->has('show_in_navigation'),
            'show_in_footer' => $request->has('show_in_footer'),
            'index_by_search_engines' => $request->has('index_by_search_engines'),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'focus_keyword' => $request->focus_keyword,
            'template' => $request->template,
        ]);

        return redirect()->route('backend.pages.index')->with('success', 'Page created successfully.');
    }

    public function pagesEdit($id)
    {
        $page = Page::findOrFail($id);
        return view('backend.admin.pages.edit', compact('page'));
    }

    public function pagesUpdate(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:pages,slug,' . $id,
            'page_type' => 'nullable|string',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'status' => 'required|string',
            'visibility' => 'required|string',
            'schedule_publish' => 'nullable|date',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'focus_keyword' => 'nullable|string',
            'template' => 'required|string',
        ]);

        $featuredImagePath = $page->featured_image;
        if ($request->hasFile('featured_image')) {
            if (!empty($page->featured_image)) {
                $oldPath = str_replace('/uploads/', '', $page->featured_image);
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
            }
            $file = $request->file('featured_image');
            $filename = md5(uniqid() . time()) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('pages', $filename, 'public');
            $featuredImagePath = '/uploads/' . $path;
        }

        $page->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'page_type' => $request->page_type ?: 'Custom Page',
            'content' => $request->input('content'),
            'featured_image' => $featuredImagePath,
            'status' => $request->status,
            'visibility' => $request->visibility,
            'schedule_publish' => $request->schedule_publish,
            'show_in_navigation' => $request->has('show_in_navigation'),
            'show_in_footer' => $request->has('show_in_footer'),
            'index_by_search_engines' => $request->has('index_by_search_engines'),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'focus_keyword' => $request->focus_keyword,
            'template' => $request->template,
        ]);

        return redirect()->route('backend.pages.index')->with('success', 'Page updated successfully.');
    }

    public function pagesDestroy($id)
    {
        $page = Page::findOrFail($id);
        
        if (!empty($page->featured_image)) {
            $oldPath = str_replace('/uploads/', '', $page->featured_image);
            \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
        }

        $page->delete();
        return redirect()->route('backend.pages.index')->with('success', 'Page deleted successfully.');
    }

    public function shipping()
    {
        return view('backend.admin.shipping');
    }

    public function payments()
    {
        return view('backend.admin.payments');
    }

    public function settings()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->all();
        return view('backend.admin.settings', compact('settings'));
    }

    public function settingsUpdate(Request $request)
    {
        $data = $request->except('_token');

        if ($request->hasFile('logo_image')) {
            $file = $request->file('logo_image');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('branding', $filename, 'public');
            $data['logo_image'] = '/uploads/' . $path;
        }

        if ($request->hasFile('hero_video')) {
            $file = $request->file('hero_video');
            $filename = 'hero_video_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('branding', $filename, 'public');
            $data['hero_video'] = '/uploads/' . $path;
        }

        foreach ($data as $key => $value) {
            if ($value !== null) {
                \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }
        return redirect()->route('backend.settings')->with('success', 'Settings updated successfully.');
    }
}
