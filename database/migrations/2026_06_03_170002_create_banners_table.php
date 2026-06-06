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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('position')->default('hero');
            $table->string('image');
            $table->string('image_mobile')->nullable();
            $table->string('click_url')->nullable();
            $table->string('open_in')->default('same_tab');
            $table->boolean('enable_overlay')->default(true);
            $table->string('headline')->nullable();
            $table->string('subheadline')->nullable();
            $table->string('cta_text')->nullable();
            $table->string('cta_link')->nullable();
            $table->string('text_position')->default('Centre');
            $table->string('text_color')->default('White');
            $table->string('alt_text')->nullable();
            $table->string('status')->default('active');
            $table->date('show_from')->nullable();
            $table->date('hide_after')->nullable();
            $table->integer('sort_order')->default(1);
            $table->string('target_audience')->default('All Visitors');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
