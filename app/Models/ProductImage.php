<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image_path',
        'alt_text',
        'sort_order',
        'is_primary',
        'width',
        'height',
        'file_size',
        'mime_type',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
