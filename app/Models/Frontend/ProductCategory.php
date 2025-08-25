<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    public function getproduct()
    {
        return $this->hasMany(Product::class, 'category_id','id')->where('is_active',1)->whereNotNull('published_at');
    }

    public function subCategories()
    {
        return $this->hasMany(ProductSubCategory::class, 'category_id', 'id');
    }
}
