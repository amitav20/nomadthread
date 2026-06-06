<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Thread;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create an Admin user
        $admin = User::create([
            'name' => 'Alex Mercer (Admin)',
            'email' => 'admin@nomadthread.test',
            'password' => Hash::make('password'),
        ]);

        // Create some nomad users
        $nomads = [
            [
                'name' => 'Sophia Martinez',
                'email' => 'sophia@nomad.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Kai Tanaka',
                'email' => 'kai@nomad.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Elena Rostova',
                'email' => 'elena@nomad.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Marcus Vance',
                'email' => 'marcus@nomad.com',
                'password' => Hash::make('password'),
            ]
        ];

        $users = [$admin];
        foreach ($nomads as $nomad) {
            $users[] = User::create($nomad);
        }

        // Demo Nomad Threads
        $threadsData = [
            [
                'title' => 'Top Coworking Cafes in Ubud, Bali',
                'content' => 'Hey everyone! I\'ve been in Ubud for 3 months now and found the absolute best cafes with high-speed internet and great coffee. Outpost and Hubud are classic, but have you tried Sayuri Healing Food or Zest? The vibes are incredible and connection is solid (50+ Mbps). Drop your favorites below!',
                'location' => 'Ubud, Bali',
                'status' => 'active',
            ],
            [
                'title' => 'DN Visa Guide for Spain - 2026 updates',
                'content' => 'Applying for the digital nomad visa in Spain can be a bureaucratic nightmare. I just got my approval last week! Here is a step-by-step breakdown of the paperwork, translation requirements, and how to prove your contract/income. Make sure your contracts explicitly state you can work remotely from anywhere.',
                'location' => 'Barcelona, Spain',
                'status' => 'active',
            ],
            [
                'title' => 'How to survive the heat in Chiang Mai during burning season?',
                'content' => 'It\'s that time of the year again. Air quality index is reaching 200+ and temperatures are rising. Are most nomads migrating to the south (Ko Lanta / Phuket) or just staying indoors with air purifiers? Looking for advice on short term rentals down south.',
                'location' => 'Chiang Mai, Thailand',
                'status' => 'active',
            ],
            [
                'title' => 'Medellin Nomad Community Meetup!',
                'content' => 'Hey guys! Setting up a casual networking meetup this Thursday at 7 PM in El Poblado. Let\'s get together for some craft beers, talk about remote work, tech, and travel experiences. All are welcome! Reply to confirm so I can reserve a table.',
                'location' => 'Medellin, Colombia',
                'status' => 'active',
            ],
            [
                'title' => 'Best eSIM providers for South America multi-country trip',
                'content' => 'I\'m planning a 6-month journey across Colombia, Peru, Chile, and Argentina. Should I buy local physical SIM cards in each country, or is there a reliable multi-country eSIM provider that doesn\'t cost a fortune? Airalo and Holafly seem popular but expensive for high data usage.',
                'location' => 'Lima, Peru',
                'status' => 'active',
            ],
            [
                'title' => 'Coliving in Lisbon: Worth the premium price?',
                'content' => 'Lisbon rental prices have skyrocketed. I\'m looking at some coliving spaces like Selina or SameSame. They want around €1200 for a private room. Is the community aspect and networking worth the markup compared to a standard Airbnb? Let me know your thoughts.',
                'location' => 'Lisbon, Portugal',
                'status' => 'archived',
            ]
        ];

        foreach ($threadsData as $data) {
            $user = $users[array_rand($users)];
            Thread::create([
                'user_id' => $user->id,
                'title' => $data['title'],
                'content' => $data['content'],
                'location' => $data['location'],
                'status' => $data['status'],
            ]);
        }

        // Seed Categories
        $categoriesData = [
            ['name' => 'Leather Bags', 'slug' => 'bags', 'icon' => '👜', 'description' => 'Premium handcrafted leather bags for every occasion.'],
            ['name' => 'Wallets', 'slug' => 'wallets', 'icon' => '👛', 'description' => 'Slim, minimalist full-grain leather wallets.'],
            ['name' => 'Accessories', 'slug' => 'accessories', 'icon' => '🪙', 'description' => 'Handcrafted belts, watch straps, and small accessories.'],
            ['name' => 'Travel Luggage', 'slug' => 'travel', 'icon' => '🎒', 'description' => 'Spacious and durable bridle leather travel bags.'],
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[$cat['slug']] = \App\Models\Category::create($cat);
        }

        // Seed Products
        $productsData = [
            [
                'category_slug' => 'bags',
                'name' => 'The Sorrento Sling',
                'sku' => 'LTH-SNG-001',
                'type' => 'Sling Bag',
                'price' => 8900,
                'badge' => 'new',
                'colors' => 'tan,espresso,cognac,black',
                'shape' => 'bag-shape',
                'description' => 'A perfectly sized everyday sling crafted from full-grain leather. Adjustable strap, two internal compartments.',
            ],
            [
                'category_slug' => 'wallets',
                'name' => 'Milano Bifold Wallet',
                'sku' => 'LTH-WLT-014',
                'type' => 'Slim Wallet',
                'price' => 3200,
                'colors' => 'espresso,tan,black,wine',
                'shape' => 'wallet-shape',
                'description' => 'Slim 4-card bifold with a central cash slot. Minimal profile, maximum impact.',
            ],
            [
                'category_slug' => 'bags',
                'name' => 'Torino Tote',
                'sku' => 'LTH-TOT-003',
                'type' => 'Tote Bag',
                'price' => 14500,
                'colors' => 'tan,camel,black',
                'shape' => 'tote-shape',
                'description' => 'A refined open-top tote with a leather base and reinforced handles for the daily commute or weekend getaway.',
            ],
            [
                'category_slug' => 'accessories',
                'name' => 'The Venice Belt',
                'sku' => 'LTH-BLT-004',
                'type' => 'Leather Belt',
                'price' => 2800,
                'badge' => 'sale',
                'old_price' => 3800,
                'colors' => 'espresso,tan,black,cognac',
                'shape' => 'belt-shape',
                'description' => 'A 35mm full-grain belt with a solid brass roller buckle. Bevelled and burnished edges.',
            ],
            [
                'category_slug' => 'bags',
                'name' => 'Palermo Backpack',
                'sku' => 'LTH-BPK-005',
                'type' => 'Backpack',
                'price' => 22000,
                'badge' => 'new',
                'colors' => 'tan,espresso,olive,slate',
                'shape' => 'bag-shape',
                'description' => '15L capacity backpack in vegetable-tanned leather. Padded laptop sleeve, magnetic closure.',
            ],
            [
                'category_slug' => 'accessories',
                'name' => 'Roma Cardholder',
                'sku' => 'LTH-CRD-006',
                'type' => 'Cardholder',
                'price' => 1800,
                'colors' => 'tan,espresso,wine,cognac',
                'shape' => 'wallet-shape',
                'description' => 'Holds 6 cards and a folded bill. Slim enough for a shirt pocket.',
            ],
            [
                'category_slug' => 'travel',
                'name' => 'Florence Duffel',
                'sku' => 'LTH-DFL-007',
                'type' => 'Weekend Bag',
                'price' => 32000,
                'colors' => 'tan,espresso',
                'shape' => 'bag-shape',
                'description' => 'A spacious weekend companion in bridle leather. Brass fittings, adjustable shoulder strap.',
            ],
            [
                'category_slug' => 'bags',
                'name' => 'Naples Laptop Sleeve',
                'sku' => 'LTH-SLV-008',
                'type' => 'Laptop Sleeve',
                'price' => 6500,
                'badge' => 'new',
                'colors' => 'tan,black,slate',
                'shape' => 'wallet-shape',
                'description' => 'Padded full-grain leather sleeve for 13" & 15" laptops. Wool felt interior lining.',
            ],
        ];

        foreach ($productsData as $prod) {
            $catSlug = $prod['category_slug'];
            unset($prod['category_slug']);
            $prod['category_id'] = $categories[$catSlug]->id;
            \App\Models\Product::create($prod);
        }

        // Seed Banners
        $bannersData = [
            [
                'title' => 'Heritage Collection 2026',
                'position' => 'Homepage Hero',
                'image' => 'banner-heritage.jpg',
                'subheadline' => 'Full-Grain Leather Goods Handcrafted by Master Artisans',
                'cta_text' => 'Explore Collection',
                'cta_link' => '#products',
                'status' => 'active',
                'sort_order' => 1,
            ],
            [
                'title' => 'The Wingman Edit',
                'position' => 'Homepage Secondary',
                'image' => 'banner-wingman.jpg',
                'subheadline' => 'Premium Wallets and Daily Accessories built to last a lifetime.',
                'cta_text' => 'Shop Wallets',
                'cta_link' => '#products',
                'status' => 'active',
                'sort_order' => 2,
            ]
        ];
        foreach ($bannersData as $b) {
            \App\Models\Banner::create($b);
        }

        // Seed Pages
        $pagesData = [
            [
                'title' => 'About Our Craft',
                'slug' => 'about-us',
                'page_type' => 'Custom Page',
                'content' => 'At Nomad Thread, we hand-select every piece of leather and stitch each item by hand...',
                'status' => 'Published',
                'template' => 'Default Page',
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact',
                'page_type' => 'Contact Page',
                'content' => 'Have questions? Get in touch with our master leathercraft workshop...',
                'status' => 'Published',
                'template' => 'Contact Page',
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'page_type' => 'Policy Page',
                'content' => 'We value your privacy. Read our policy on data encryption...',
                'status' => 'Published',
                'template' => 'Policy Page',
            ]
        ];
        foreach ($pagesData as $p) {
            \App\Models\Page::create($p);
        }

        // Seed Orders
        $ordersData = [
            [
                'order_number' => 'ORD-2841',
                'customer_name' => 'Priya Sharma',
                'customer_email' => 'priya@example.com',
                'subtotal' => 3200,
                'tax' => 290,
                'total' => 3490,
                'status' => 'Completed',
                'payment_status' => 'Paid',
                'payment_method' => 'Credit Card',
                'shipping_method' => 'Express',
            ],
            [
                'order_number' => 'ORD-2840',
                'customer_name' => 'Rahul Verma',
                'customer_email' => 'rahul@example.com',
                'subtotal' => 6800,
                'tax' => 400,
                'total' => 7200,
                'status' => 'Shipped',
                'payment_status' => 'Paid',
                'payment_method' => 'Net Banking',
                'shipping_method' => 'Standard',
            ],
            [
                'order_number' => 'ORD-2839',
                'customer_name' => 'Sneha Patel',
                'customer_email' => 'sneha@example.com',
                'subtotal' => 1700,
                'tax' => 150,
                'total' => 1850,
                'status' => 'Processing',
                'payment_status' => 'Paid',
                'payment_method' => 'UPI',
                'shipping_method' => 'Standard',
            ],
            [
                'order_number' => 'ORD-2838',
                'customer_name' => 'Amit Singh',
                'customer_email' => 'amit@example.com',
                'subtotal' => 3900,
                'tax' => 200,
                'total' => 4100,
                'status' => 'Completed',
                'payment_status' => 'Paid',
                'payment_method' => 'Debit Card',
                'shipping_method' => 'Express',
            ],
            [
                'order_number' => 'ORD-2836',
                'customer_name' => 'Rohan Mehta',
                'customer_email' => 'rohan@example.com',
                'subtotal' => 2800,
                'tax' => 190,
                'total' => 2990,
                'status' => 'Pending',
                'payment_status' => 'Unpaid',
                'payment_method' => 'COD',
                'shipping_method' => 'Standard',
            ]
        ];
        foreach ($ordersData as $o) {
            \App\Models\Order::create($o);
        }

        // Seed Reviews
        $dbProducts = \App\Models\Product::all();
        $reviewsData = [
            [
                'reviewer_name' => 'Arjun Mehta',
                'reviewer_email' => 'arjun@example.com',
                'rating' => 5,
                'title' => 'Stunning Quality',
                'comment' => 'The cognac messenger bag I bought three years ago looks better today than the day it arrived.',
                'status' => 'Approved',
            ],
            [
                'reviewer_name' => 'Priya Sharma',
                'reviewer_email' => 'priya@example.com',
                'rating' => 5,
                'title' => 'Perfect Gift',
                'comment' => 'Absolutely stunning quality. The leather is buttery smooth and feels very luxury.',
                'status' => 'Approved',
            ],
            [
                'reviewer_name' => 'Sameer Rathore',
                'reviewer_email' => 'sameer@example.com',
                'rating' => 4,
                'title' => 'Very Nice',
                'comment' => 'Excellent leather belt, hand burnished edges look beautiful.',
                'status' => 'Approved',
            ]
        ];
        foreach ($reviewsData as $r) {
            $r['product_id'] = $dbProducts->random()->id;
            \App\Models\Review::create($r);
        }
    }
}
