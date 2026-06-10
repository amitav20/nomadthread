<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('currency_code');
            $table->string('currency_symbol');
            $table->decimal('exchange_rate', 10, 4)->default(1.0000);
            $table->string('status')->default('active');
            $table->timestamps();
        });

        // Insert initial countries (Base is INR = 1.0)
        $countries = [
            [
                'name' => 'India',
                'code' => 'IN',
                'currency_code' => 'INR',
                'currency_symbol' => '₹',
                'exchange_rate' => 1.0000,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'United States',
                'code' => 'US',
                'currency_code' => 'USD',
                'currency_symbol' => '$',
                'exchange_rate' => 0.0120, // 1 INR = 0.012 USD
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'United Kingdom',
                'code' => 'GB',
                'currency_code' => 'GBP',
                'currency_symbol' => '£',
                'exchange_rate' => 0.0094, // 1 INR = 0.0094 GBP
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Europe',
                'code' => 'EU',
                'currency_code' => 'EUR',
                'currency_symbol' => '€',
                'exchange_rate' => 0.0110, // 1 INR = 0.011 EUR
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'United Arab Emirates',
                'code' => 'AE',
                'currency_code' => 'AED',
                'currency_symbol' => 'د.إ',
                'exchange_rate' => 0.0440, // 1 INR = 0.044 AED
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('countries')->insert($countries);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
