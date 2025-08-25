<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAnalysis extends Model
{
    use HasFactory;
    public $fillable = [
        'id',
        'product_id',
        'browser',
        'device',
        'ip_adress',
        'page_name',
    ];
}
