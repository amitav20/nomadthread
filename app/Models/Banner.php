<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'position',
        'image',
        'video',
        'image_mobile',
        'click_url',
        'open_in',
        'enable_overlay',
        'headline',
        'subheadline',
        'cta_text',
        'cta_link',
        'text_position',
        'text_color',
        'alt_text',
        'status',
        'show_from',
        'hide_after',
        'sort_order',
        'target_audience',
    ];
}
