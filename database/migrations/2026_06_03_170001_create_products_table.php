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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('sku')->unique();
            $table->string('barcode')->nullable();
            $table->string('type')->nullable();
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->text('key_features')->nullable();
            $table->integer('price')->default(0);
            $table->integer('old_price')->nullable();
            $table->integer('cost_price')->nullable();
            $table->string('tax_class')->nullable();
            $table->string('hsn_code')->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->integer('low_stock_alert')->default(10);
            $table->string('stock_status')->default('In Stock');
            $table->boolean('allow_backorders')->default(false);
            $table->boolean('track_stock')->default(true);
            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->text('colors')->nullable(); // comma-separated colors
            $table->text('sizes')->nullable(); // comma-separated sizes
            $table->string('leather_type')->nullable();
            $table->string('lining_material')->nullable();
            $table->string('status')->default('active');
            $table->string('visibility')->default('public');
            $table->string('badge')->nullable(); // e.g. new, sale
            $table->string('shape')->default('bag-shape');
            $table->string('image')->nullable();
            $table->boolean('show_on_homepage')->default(true);
            $table->boolean('enable_reviews')->default(true);
            $table->boolean('allow_giftwrap')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
