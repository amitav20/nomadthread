<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'sku',
        'barcode',
        'type',
        'short_description',
        'description',
        'key_features',
        'price',
        'old_price',
        'cost_price',
        'tax_class',
        'hsn_code',
        'stock_quantity',
        'low_stock_alert',
        'stock_status',
        'allow_backorders',
        'track_stock',
        'weight',
        'length',
        'width',
        'height',
        'colors',
        'sizes',
        'leather_type',
        'lining_material',
        'status',
        'visibility',
        'badge',
        'shape',
        'image',
        'show_on_homepage',
        'enable_reviews',
        'allow_giftwrap',
        'gender',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('is_primary', 'desc')->orderBy('sort_order', 'asc');
    }
}
