<?php

namespace App\Models;
use App\Models\BaseModel as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'tnx_id','payment_id','payer_id','billing_email', 'billing_name', 'billing_address', 'billing_city',
    'billing_province', 'billing_postalcode', 'billing_phone', 'billing_name_on_card',
    'billing_discount', 'billing_discount_code', 'billing_subtotal', 'billing_tax',
    'billing_total', 'error','payment_method','mode','payment_gateway','status','json_response',
    'admin_commission','vendor_amount','tax_rate','commission_rate',
    ];


    public function getUser()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }

    public function getOrderProduct()
    {
        return $this->hasMany(OrderProduct::class,'order_id','id');
    }

    public function getStatusStrAttribute()
    {
        if($this->status == 1)
        return 'Completed';
        elseif($this->status == 2)
        return 'Fail';
        else
        return 'Pending';
    }

    public static $searchable = [
        'id' => 'Order Id',
        'tnx_id' => 'Transaction Id',
        'user_id' => 'User Id',
        'payment_gateway' => 'Payment Gateway',
        'status' => 'Status',
        'payment_id' => 'Payment Id',
        'payer_id' => 'Payer Id',
        'billing_total' => 'Billing Total',
        'created_at'=>'DATE',
    ];
    
}
