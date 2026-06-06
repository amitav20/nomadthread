<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Seed initial default configurations
        $defaults = [
            'store_name' => 'Nomad Thread',
            'store_url' => 'https://nomadthread.in',
            'support_email' => 'support@nomadthread.in',
            'support_phone' => '+91 98765 43210',
            'store_address' => 'Nomad Thread Atelier, 12, Heritage Lane, Dharavi, Mumbai, India',
            'currency' => 'INR (₹)',
            'timezone' => 'Asia/Kolkata (IST)',
            'top_bar_text' => '✦ Free shipping on orders above ₹5,000 &nbsp;|&nbsp; Handcrafted with full-grain leather &nbsp;|&nbsp; ✦ 10% off on first order — Use CRAFT10',
            'logo_text' => 'NOMAD THREAD',
            'footer_tagline' => 'Premium handcrafted leather goods built to last a lifetime and grow more beautiful with every use.',
            'copyright_text' => 'Nomad Thread. Made with ♥ in India.',
            'facebook_link' => '#',
            'linkedin_link' => '#',
            'instagram_link' => '#',
            'youtube_link' => '#',
            'story_title' => 'Where Heritage Meets Craft',
            'story_sub' => 'Every Nomad Thread piece begins as raw full-grain hide, selected by hand in our atelier. Skilled artisans spend days cutting, stitching, and finishing each item — no shortcuts, no compromises.',
            'marquee_text' => 'Full Grain Leather • Handstitched Artisanship • Indian Heritage • Lifetime Durability • Bespoke Monogramming • 10+ Years of Craft'
        ];

        foreach ($defaults as $key => $value) {
            \Illuminate\Support\Facades\DB::table('settings')->insert([
                'key' => $key,
                'value' => $value,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
