<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image_banner',
        'image_thumbnail',
        'icon',
        'accent_color',
        'status',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
