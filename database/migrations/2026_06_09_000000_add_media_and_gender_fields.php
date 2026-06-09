<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'video')) {
                $table->string('video')->nullable();
            }
            if (!Schema::hasColumn('categories', 'gender')) {
                $table->string('gender')->nullable()->default('both');
            }
        });

        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'gender')) {
                $table->string('gender')->nullable()->default('unisex');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'video')) {
                $table->dropColumn('video');
            }
            if (Schema::hasColumn('categories', 'gender')) {
                $table->dropColumn('gender');
            }
        });

        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'gender')) {
                $table->dropColumn('gender');
            }
        });
    }
};
