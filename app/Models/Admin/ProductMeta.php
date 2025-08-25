<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMeta extends Model
{
    use HasFactory;
    public $fillable = [
        'id',
        'product_id',
        'key',
        'value',
    ];

    
}
