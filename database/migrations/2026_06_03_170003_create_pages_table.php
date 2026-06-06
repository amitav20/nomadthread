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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('page_type')->default('Custom Page');
            $table->longText('content')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('status')->default('Published');
            $table->string('visibility')->default('Public');
            $table->dateTime('schedule_publish')->nullable();
            $table->boolean('show_in_navigation')->default(true);
            $table->boolean('show_in_footer')->default(false);
            $table->boolean('index_by_search_engines')->default(true);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('focus_keyword')->nullable();
            $table->string('template')->default('Default Page');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
