<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAdditionalInfo extends Model
{
    use HasFactory;
    public $fillable = [
        'id',
        'user_id',
        'key',
        'value',
    ];
}
