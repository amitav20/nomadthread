<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductImageUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_upload_multiple_images_when_creating_product()
    {
        Storage::fake('public');

        $category = Category::create([
            'name' => 'Bags',
            'slug' => 'bags',
            'status' => 'active',
        ]);

        $image1 = UploadedFile::fake()->image('bag_front.jpg', 800, 600);
        $image2 = UploadedFile::fake()->image('bag_side.png', 1000, 800);

        $response = $this->post(route('backend.products.store'), [
            'category_id' => $category->id,
            'name' => 'Vintage Leather Bag',
            'sku' => 'BAG-VNTG-01',
            'type' => 'Messenger Bag',
            'price' => 4500,
            'old_price' => 5000,
            'colors' => 'tan,cognac',
            'sizes' => 'Medium',
            'description' => 'A fine vintage bag.',
            'status' => 'active',
            'shape' => 'bag-shape',
            'stock_quantity' => 15,
            'low_stock_alert' => 5,
            'images' => [$image1, $image2],
        ]);

        $response->assertRedirect(route('backend.products.index'));

        $product = Product::where('sku', 'BAG-VNTG-01')->first();
        $this->assertNotNull($product);

        // Check product images exist in database
        $this->assertCount(2, $product->images);

        $firstImage = $product->images->firstWhere('is_primary', true);
        $this->assertNotNull($firstImage);
        $this->assertEquals(800, $firstImage->width);
        $this->assertEquals(600, $firstImage->height);
        $this->assertEquals('image/jpeg', $firstImage->mime_type);
        $this->assertEquals($product->name, $firstImage->alt_text);

        // Check storage
        $path1 = str_replace('/storage/', '', $firstImage->image_path);
        Storage::disk('public')->assertExists($path1);

        $secondImage = $product->images->firstWhere('is_primary', false);
        $this->assertNotNull($secondImage);
        $this->assertEquals(1000, $secondImage->width);
        $this->assertEquals(800, $secondImage->height);
        $this->assertEquals('image/png', $secondImage->mime_type);

        $path2 = str_replace('/storage/', '', $secondImage->image_path);
        Storage::disk('public')->assertExists($path2);
    }

    public function test_can_manage_images_when_updating_product()
    {
        Storage::fake('public');

        $category = Category::create([
            'name' => 'Wallets',
            'slug' => 'wallets',
            'status' => 'active',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Bifold Wallet',
            'sku' => 'WLT-BF-01',
            'price' => 1200,
            'status' => 'active',
            'stock_quantity' => 50,
        ]);

        // Mock existing image upload
        $file = UploadedFile::fake()->image('wallet1.jpg', 400, 400);
        $filename = 'wallet_mock.jpg';
        $path = $file->storeAs('products/' . $product->id, $filename, 'public');

        $img = ProductImage::create([
            'product_id' => $product->id,
            'image_path' => '/storage/' . $path,
            'alt_text' => 'Old Alt',
            'is_primary' => true,
            'sort_order' => 0,
            'width' => 400,
            'height' => 400,
            'file_size' => $file->getSize(),
            'mime_type' => 'image/jpeg',
        ]);

        Storage::disk('public')->assertExists('products/' . $product->id . '/' . $filename);

        // Update product, upload a new image, delete old, change details
        $newFile = UploadedFile::fake()->image('wallet2.png', 600, 600);

        $response = $this->put(route('backend.products.update', $product->id), [
            'category_id' => $category->id,
            'name' => 'Updated Wallet Name',
            'sku' => 'WLT-BF-01',
            'price' => 1300,
            'status' => 'active',
            'stock_quantity' => 40,
            'delete_images' => [$img->id],
            'images' => [$newFile],
        ]);

        $response->assertRedirect(route('backend.products.index'));

        // Assert old image deleted
        Storage::disk('public')->assertMissing('products/' . $product->id . '/' . $filename);
        $this->assertDatabaseMissing('product_images', ['id' => $img->id]);

        // Assert new image exists
        $product->refresh();
        $this->assertCount(1, $product->images);

        $newImg = $product->images->first();
        $this->assertEquals(600, $newImg->width);
        $this->assertEquals(600, $newImg->height);
        $this->assertEquals('image/png', $newImg->mime_type);
        $this->assertTrue((bool)$newImg->is_primary);
    }

    public function test_api_returns_products_with_images()
    {
        $category = Category::create([
            'name' => 'Bags',
            'slug' => 'bags',
            'status' => 'active',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Vintage Leather Bag',
            'sku' => 'BAG-VNTG-01',
            'price' => 4500,
            'status' => 'active',
            'stock_quantity' => 15,
        ]);

        ProductImage::create([
            'product_id' => $product->id,
            'image_path' => '/storage/products/1/img1.jpg',
            'alt_text' => 'Bag Alt',
            'is_primary' => true,
            'sort_order' => 0,
            'width' => 800,
            'height' => 600,
            'file_size' => 10240,
            'mime_type' => 'image/jpeg',
        ]);

        $response = $this->getJson(route('api.products'));

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'image_path' => '/storage/products/1/img1.jpg',
            'alt_text' => 'Bag Alt',
        ]);
    }
}
