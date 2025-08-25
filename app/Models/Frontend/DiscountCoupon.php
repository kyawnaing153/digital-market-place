<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCoupon extends Model
{
    use HasFactory;

    public function discount($total) {
        if($this->coupon_type == 0) { //fixed
            return $this->coupon_amount;
        } else if($this->coupon_type == 1) {//'percent'
            return ($this->coupon_amount / 100) * $total;
        } else {
            return 0;
        }
    }
}
