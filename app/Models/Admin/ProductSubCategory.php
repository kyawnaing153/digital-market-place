<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSubCategory extends Model
{
    use HasFactory;
    public $fillable = [
        'id',
        'slug',
        'name',
        'category_id',
        'is_active',
        'is_featured',
    ];

    public function getCategory()
    {
        return $this->hasOne(ProductCategory::class, 'id','category_id');
    }

}
