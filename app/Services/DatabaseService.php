<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseService
{
    private static $initialized = false;

    /**
     * Get a connection indicator to ensure the database is initialized.
     * Auto-creates the database, tables, and seeds them with demo data if empty.
     */
    public static function getConnection()
    {
        if (self::$initialized) {
            return true;
        }

        $connection = config('database.default', 'mysql');
        if ($connection === 'mysql') {
            $database = config('database.connections.mysql.database', 'nomadthread');
            try {
                DB::connection()->getPdo();
            } catch (\Exception $e) {
                // Connection failed, database might not exist.
                $config = config('database.connections.mysql');
                $tempConfig = $config;
                $tempConfig['database'] = ''; // Connect without database

                config(['database.connections.mysql_temp' => $tempConfig]);

                try {
                    $pdo = DB::connection('mysql_temp')->getPdo();
                    $dbEscaped = str_replace('`', '``', $database);
                    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbEscaped` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                    DB::purge('mysql_temp');
                } catch (\Exception $ex) {
                    throw new \Exception("Database connection & auto-creation failed: " . $ex->getMessage());
                }
            }
        }

        // Create Tables if they don't exist
        self::createTables();

        // Seed Data if database is empty
        self::seedDatabase();

        self::$initialized = true;
        return true;
    }

    /**
     * Create tables using Schema facade.
     */
    private static function createTables(): void
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function ($table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->timestamp('created_at')->useCurrent();
            });
        }

        if (!Schema::hasTable('threads')) {
            Schema::create('threads', function ($table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->string('title');
                $table->text('content');
                $table->string('location')->nullable();
                $table->string('status')->default('active');
                $table->timestamp('created_at')->useCurrent();
            });
        }
    }

    /**
     * Seed database with dummy users and nomad threads if users table is empty.
     */
    private static function seedDatabase(): void
    {
        // Check if users exist
        if (DB::table('users')->count() > 0) {
            return;
        }

        // Seed users
        $usersData = [
            ['Alex Mercer (Admin)', 'admin@nomadthread.test', password_hash('password', PASSWORD_DEFAULT)],
            ['Sophia Martinez', 'sophia@nomad.com', password_hash('password', PASSWORD_DEFAULT)],
            ['Kai Tanaka', 'kai@nomad.com', password_hash('password', PASSWORD_DEFAULT)],
            ['Elena Rostova', 'elena@nomad.com', password_hash('password', PASSWORD_DEFAULT)],
            ['Marcus Vance', 'marcus@nomad.com', password_hash('password', PASSWORD_DEFAULT)],
        ];

        $userIds = [];
        foreach ($usersData as $userData) {
            $userIds[] = DB::table('users')->insertGetId([
                'name' => $userData[0],
                'email' => $userData[1],
                'password' => $userData[2],
            ]);
        }

        // Seed Nomad Threads
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

        foreach ($threadsData as $threadData) {
            $randomUserId = $userIds[array_rand($userIds)];
            DB::table('threads')->insert([
                'user_id' => $randomUserId,
                'title' => $threadData['title'],
                'content' => $threadData['content'],
                'location' => $threadData['location'],
                'status' => $threadData['status'],
            ]);
        }
    }
}
