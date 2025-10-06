<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'posts_per_page',
        'default_order_by',
        'default_order_dir',
        'filter_author_id',
        'filter_category_id'
    ];
    protected $casts = [
    'posts_per_page' => 'integer',
    'default_order_by' => 'string',
    'default_order_dir' => 'string',
    'filter_author_id' => 'integer',
    'filter_category_id' => 'integer',
    ];
}

