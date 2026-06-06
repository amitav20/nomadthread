<?php

namespace App\Services;

class DatabaseService
{
    private static $connection = null;

    /**
     * Get a mysqli connection to the MySQL database.
     * Auto-creates the database, tables, and seeds them with demo data if empty.
     */
    public static function getConnection(): \mysqli
    {
        if (self::$connection !== null) {
            return self::$connection;
        }

        $host = config('database.connections.mysql.host', '127.0.0.1');
        $username = config('database.connections.mysql.username', 'root');
        $password = config('database.connections.mysql.password', '');
        $database = config('database.connections.mysql.database', 'nomadthread');
        $port = config('database.connections.mysql.port', '3306');

        // 1. Connect to MySQL server (without specifying DB to handle auto-creation)
        $mysqli = @new \mysqli($host, $username, $password, '', $port);
        if ($mysqli->connect_error) {
            throw new \Exception("Database connection failed: " . $mysqli->connect_error);
        }

        // 2. Create database if it doesn't exist
        $dbEscaped = $mysqli->real_escape_string($database);
        if (!$mysqli->query("CREATE DATABASE IF NOT EXISTS `$dbEscaped` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci")) {
            throw new \Exception("Failed to create database: " . $mysqli->error);
        }

        // 3. Select the database
        if (!$mysqli->select_db($database)) {
            throw new \Exception("Failed to select database: " . $mysqli->error);
        }

        // 4. Create Tables if they don't exist
        self::createTables($mysqli);

        // 5. Seed Data if database is empty
        self::seedDatabase($mysqli);

        self::$connection = $mysqli;
        return self::$connection;
    }

    /**
     * Create tables using raw SQL queries.
     */
    private static function createTables(\mysqli $mysqli): void
    {
        // Users Table
        $createUsersQuery = "
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB;
        ";
        if (!$mysqli->query($createUsersQuery)) {
            throw new \Exception("Failed to create users table: " . $mysqli->error);
        }

        // Threads Table
        $createThreadsQuery = "
            CREATE TABLE IF NOT EXISTS threads (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                title VARCHAR(255) NOT NULL,
                content TEXT NOT NULL,
                location VARCHAR(255) DEFAULT NULL,
                status VARCHAR(50) DEFAULT 'active',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            ) ENGINE=InnoDB;
        ";
        if (!$mysqli->query($createThreadsQuery)) {
            throw new \Exception("Failed to create threads table: " . $mysqli->error);
        }
    }

    /**
     * Seed database with dummy users and nomad threads if users table is empty.
     */
    private static function seedDatabase(\mysqli $mysqli): void
    {
        // Check if users exist
        $result = $mysqli->query("SELECT COUNT(*) as count FROM users");
        $row = $result->fetch_assoc();
        
        if ($row['count'] > 0) {
            // Already seeded
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
        $stmt = $mysqli->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        foreach ($usersData as $userData) {
            $stmt->bind_param("sss", $userData[0], $userData[1], $userData[2]);
            $stmt->execute();
            $userIds[] = $mysqli->insert_id;
        }
        $stmt->close();

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

        $stmt = $mysqli->prepare("INSERT INTO threads (user_id, title, content, location, status) VALUES (?, ?, ?, ?, ?)");
        foreach ($threadsData as $threadData) {
            $randomUserId = $userIds[array_rand($userIds)];
            $stmt->bind_param("issss", $randomUserId, $threadData['title'], $threadData['content'], $threadData['location'], $threadData['status']);
            $stmt->execute();
        }
        $stmt->close();
    }
}
