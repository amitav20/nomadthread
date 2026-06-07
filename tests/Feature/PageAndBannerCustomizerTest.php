<?php

namespace Tests\Feature;

use App\Models\Banner;
use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PageAndBannerCustomizerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        \App\Services\DatabaseService::getConnection();
        $this->admin = \App\Models\User::where('role', 'admin')->first();
    }

    public function test_can_crud_banners_with_image_and_video()
    {
        $this->actingAs($this->admin);
        Storage::fake('public');

        // 1. Create Banner
        $image = UploadedFile::fake()->image('banner_hero.jpg');
        $video = UploadedFile::fake()->create('banner_loop.mp4', 5000, 'video/mp4');

        $response = $this->post(route('backend.banners.store'), [
            'title' => 'Winter Sale Hero',
            'position' => 'Homepage Hero',
            'image' => $image,
            'video' => $video,
            'status' => 'active',
            'sort_order' => 1,
            'headline' => 'Luxury Leather Co.',
            'subheadline' => 'Handcrafted details that matter',
            'cta_text' => 'Discover',
            'cta_link' => '/shop',
        ]);

        $response->assertRedirect(route('backend.banners.index'));

        $banner = Banner::where('title', 'Winter Sale Hero')->first();
        $this->assertNotNull($banner);
        $this->assertEquals('Homepage Hero', $banner->position);
        $this->assertEquals('Luxury Leather Co.', $banner->headline);

        // Verify storage paths
        $imageRelative = str_replace('/uploads/', '', $banner->image);
        $videoRelative = str_replace('/uploads/', '', $banner->video);
        Storage::disk('public')->assertExists($imageRelative);
        Storage::disk('public')->assertExists($videoRelative);

        // 2. Edit / Update Banner (replace video and details)
        $newVideo = UploadedFile::fake()->create('new_loop.mp4', 6000, 'video/mp4');
        $response = $this->put(route('backend.banners.update', $banner->id), [
            'title' => 'Updated Banner Name',
            'position' => 'Homepage Hero',
            'image' => null,
            'video' => $newVideo,
            'status' => 'active',
            'sort_order' => 2,
        ]);

        $response->assertRedirect(route('backend.banners.index'));
        $banner->refresh();
        $this->assertEquals('Updated Banner Name', $banner->title);
        $this->assertEquals(2, $banner->sort_order);

        // Check old video deleted and new video created
        Storage::disk('public')->assertMissing($videoRelative);
        $newVideoRelative = str_replace('/uploads/', '', $banner->video);
        Storage::disk('public')->assertExists($newVideoRelative);

        // 3. Destroy Banner
        $response = $this->delete(route('backend.banners.destroy', $banner->id));
        $response->assertRedirect(route('backend.banners.index'));
        $this->assertDatabaseMissing('banners', ['id' => $banner->id]);
        Storage::disk('public')->assertMissing($imageRelative);
        Storage::disk('public')->assertMissing($newVideoRelative);
    }

    public function test_can_crud_pages_with_featured_image()
    {
        $this->actingAs($this->admin);
        Storage::fake('public');

        // 1. Create Page
        $featuredImage = UploadedFile::fake()->image('about_us.jpg');
        $response = $this->post(route('backend.pages.store'), [
            'title' => 'About Our Brand',
            'slug' => 'about-us',
            'page_type' => 'About Us',
            'content' => '<h1>Our Story</h1><p>Crafted in India since 2010.</p>',
            'featured_image' => $featuredImage,
            'status' => 'Published',
            'visibility' => 'Public',
            'template' => 'With Sidebar',
            'show_in_navigation' => 1,
            'show_in_footer' => 1,
            'index_by_search_engines' => 1,
            'meta_title' => 'About Us | Nomad Thread',
            'meta_description' => 'Find out about our heritage leather craftsmanship.',
        ]);

        $response->assertRedirect(route('backend.pages.index'));

        $page = Page::where('slug', 'about-us')->first();
        $this->assertNotNull($page);
        $this->assertEquals('About Our Brand', $page->title);
        $this->assertEquals('With Sidebar', $page->template);
        $this->assertTrue((bool)$page->show_in_navigation);

        $imageRelative = str_replace('/uploads/', '', $page->featured_image);
        Storage::disk('public')->assertExists($imageRelative);

        // 2. Edit / Update Page
        $response = $this->put(route('backend.pages.update', $page->id), [
            'title' => 'Our Brand History',
            'slug' => 'about-our-brand',
            'content' => '<h1>New Content</h1>',
            'status' => 'Published',
            'visibility' => 'Public',
            'template' => 'Default Page',
        ]);

        $response->assertRedirect(route('backend.pages.index'));
        $page->refresh();
        $this->assertEquals('Our Brand History', $page->title);
        $this->assertEquals('about-our-brand', $page->slug);

        // 3. Destroy Page
        $response = $this->delete(route('backend.pages.destroy', $page->id));
        $response->assertRedirect(route('backend.pages.index'));
        $this->assertDatabaseMissing('pages', ['id' => $page->id]);
        Storage::disk('public')->assertMissing($imageRelative);
    }

    public function test_frontend_renders_pages_and_nav_menus()
    {
        $page = Page::create([
            'title' => 'Terms of Service',
            'slug' => 'terms',
            'page_type' => 'Terms & Conditions',
            'content' => '<p>Terms and conditions content.</p>',
            'status' => 'Published',
            'visibility' => 'Public',
            'template' => 'Policy Page',
            'show_in_navigation' => true,
            'show_in_footer' => true,
        ]);

        // Create a banner for the page slug position to test background loop
        $banner = Banner::create([
            'title' => 'Terms Page Banner',
            'position' => 'terms',
            'image' => '/uploads/banners/terms.jpg',
            'video' => '/uploads/banners/terms.mp4',
            'status' => 'active',
            'sort_order' => 1,
        ]);

        // Get custom page view
        $response = $this->get(route('pages.show', 'terms'));
        $response->assertStatus(200);
        $response->assertSee('Terms of Service');
        $response->assertSee('Terms and conditions content.');
        $response->assertSee('terms.mp4'); // Assert video loop rendering
    }

    public function test_admin_can_update_settings_and_renders_dynamically_in_frontend()
    {
        $this->actingAs($this->admin);
        // 1. Post to update settings
        $response = $this->post(route('backend.settings.update'), [
            'store_name' => 'Custom Leather Store',
            'logo_text' => 'MYCUSTOMNAV',
            'top_bar_text' => 'Announcement from dynamic settings',
            'footer_tagline' => 'My custom footer tagline text here',
            'copyright_text' => 'Custom Copyright Inc.',
        ]);

        $response->assertRedirect(route('backend.settings'));

        // 2. Check settings database values
        $this->assertDatabaseHas('settings', [
            'key' => 'store_name',
            'value' => 'Custom Leather Store',
        ]);
        $this->assertDatabaseHas('settings', [
            'key' => 'logo_text',
            'value' => 'MYCUSTOMNAV',
        ]);

        // 3. Visit homepage and verify settings are rendered
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee('MYCUSTOMNAV');
        $response->assertSee('Announcement from dynamic settings');
        $response->assertSee('My custom footer tagline text here');
        $response->assertSee('Custom Copyright Inc.');
    }
}
