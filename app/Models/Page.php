<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'page_type',
        'content',
        'featured_image',
        'status',
        'visibility',
        'schedule_publish',
        'show_in_navigation',
        'show_in_footer',
        'index_by_search_engines',
        'meta_title',
        'meta_description',
        'focus_keyword',
        'template',
    ];
}
