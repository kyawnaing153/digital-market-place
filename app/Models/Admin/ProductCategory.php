<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    public $fillable = [
        'id',
        'slug',
        'name',
        'is_active',
        'is_featured',
    ];

    public function getproduct()
    {
        return $this->hasMany(Product::class, 'category_id','id');
    }

    public function subCategories()
    {
        return $this->hasMany(ProductSubCategory::class, 'category_id', 'id');
    }
}
