<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\User;
class Rating extends Model
{
    use HasUuids,HasFactory;

    public $fillable = [
        'id',
        'user_id',
        'product_id',
        'parent_id',
        'comment',
        'rating',
        'is_active'
    ];

    public function getUser()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }
    public function reviewReply()
    {
        return $this->hasMany(Rating::class, 'parent_id','id');
    }
    
}
