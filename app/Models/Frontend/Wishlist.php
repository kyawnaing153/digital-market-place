<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Wishlist extends Model
{
    use HasUuids,HasFactory;
    public $fillable = [
        'id',
        'user_id',
        'product_id',
    ];

    public function getProduct()
    {
        return $this->hasOne(Product::class, 'id','product_id');
    }

}
