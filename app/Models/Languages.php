<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Languages extends Model
{
    protected $fillable = [
        'id',
        'name',
        'short_name',
        'flag',
        'is_active',
    ];

    use HasFactory;
}
