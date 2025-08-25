<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel as Model;

class DiscountCoupon extends Model
{
    use HasFactory;
    public $fillable = [
        'id',
        'coupon_name',
        'coupon_code',
        'coupon_description',
        'coupon_amount',
        'coupon_type',
        'is_lifetime',
        'coupon_duration',
        'start_date',
        'end_date',
        'max_uses',
        'min_amount',
        'product_id',
        'cannot_applied_product_id',
        'is_once_per_user',
    ];

    public static $searchable = [
        'id' => 'Coupon Id',
        'coupon_name' => 'Coupon name',
        'coupon_code' => 'Coupon code',
        'coupon_amount' => 'Coupon amount',
        'status' => 'Status',
        'is_once_per_user' => 'once per user',
        'is_lifetime' => 'Is lifetime',
    ];



}
