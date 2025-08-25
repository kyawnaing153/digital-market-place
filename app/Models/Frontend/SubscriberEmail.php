<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriberEmail extends Model
{
    use HasFactory;
     public $fillable = [
        'id',
        'email',
        'source',
    ];

}
