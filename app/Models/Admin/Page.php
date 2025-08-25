<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public $table = 'pages';

    public $fillable = [
        'id',
        'slug',
        'heading',
        'description',
        'meta_title',
        'meta_desc',
        'meta_keywords',
        'meta_image',
        'is_active',
        'sub_heading',
    ];
    
}
