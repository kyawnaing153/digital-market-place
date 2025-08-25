<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{ 
    public $fillable = [
        'id',
        'short_name',
        'name',
        
    ];
    use HasFactory;
}
