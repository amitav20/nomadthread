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
        'video',
        'icon',
        'accent_color',
        'status',
        'gender',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
