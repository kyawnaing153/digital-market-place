<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Frontend\DiscountCoupon;
use Cart,Validator,Auth;
use App\Models\{Order};
class CouponsController extends Controller
{
    /* Check coupon code is valid or not or expired. */
    public function checkCouponCode(Request $request)
    {
        $rules = ['coupon_code' => 'required'];
        $validator = Validator::make($request->all(), $rules);
		if ($validator->fails())
			return json_response(['status' => false, 'msg' => $validator->messages()->first()], 400);
        
        $coupon = DiscountCoupon::where(['coupon_code'=>$request->coupon_code,'is_active'=>1])->first();
        if(empty($coupon)) //if empty
        return json_response(['status' => false, 'msg' => trans('frontend_msg.invalid_coupon')], 400);
        $cartTotal = Cart::instance('default')->subtotal();

        if($coupon->min_amount > $cartTotal)
        return json_response(['status' => false, 'msg' => $coupon->min_amount .' '.trans('frontend_msg.coupon_min_amt')], 400);
        
        $discount = $coupon->discount(Cart::instance('default')->subtotal());

        if($discount >= $cartTotal)
        return json_response(['status' => false, 'msg' => trans('frontend_msg.coupon_not_applied')], 400);
    
        //Get cart contents
        $contents = Cart::instance('default')->content()->map(function ($item) {
            return $item->model->id;
        })->values()->toArray();

        
        $coupon_prod = json_decode($coupon->product_id);//decode coupon product ids
        $cannot_applied_product_id = json_decode($coupon->cannot_applied_product_id); //decode coupon cannot applied product ids

        if($coupon->is_lifetime == 0) //check coupon is not lifetime free
        {
            //Check The coupon code required the product ID
            if(isset($coupon->product_id[0])){
                foreach($contents as $cart_pid)
                {
                    if (!in_array($cart_pid, $coupon_prod)){
                        return json_response(['status' => false, 'msg' => trans('frontend_msg.coupon_product_requirements')], 400);
                    }

                }
            }

            //The coupon code required the product ID
            if(isset($cannot_applied_product_id[0])){
                foreach($contents as $cart_pid)
                {
                    if (in_array($cart_pid, $cannot_applied_product_id)){
                        return json_response(['status' => false, 'msg' => trans('frontend_msg.coupon_not_valid_cart_contents')], 400);
                    }

                }
            }
              //check coupon code is not expired
            if(!empty($coupon->start_date) && !empty($coupon->end_date) ){
                if(($coupon->start_date < date('Y-m-d h:i:s')) && ($coupon->end_date > date('Y-m-d h:i:s'))){
                }else{
                    return json_response(['status' => false, 'msg' => trans('frontend_msg.coupon_expired')], 400);
                }
            }
        }

        if($coupon->is_once_per_user == 1) //check coupon code is once per user 
        {
            $isExist = Order::where(['user_id'=>Auth::id(),'billing_discount_code'=>$coupon->coupon_code])->exists();
            if($isExist){
                return json_response(['status' => false, 'msg' => trans('frontend_msg.already_applied_coupon')], 400);
            }
        }
        if(!empty($coupon->max_uses)) //check coupon code max uses 
        {
            $max_count = Order::where(['user_id'=>Auth::id(),'billing_discount_code'=>$coupon->coupon_code])->count();
            if($max_count >= $coupon->max_uses){
                return json_response(['status' => false, 'msg' => trans('frontend_msg.already_applied_coupon')], 400);
            }
        }
       //coupon code stored into session
        session()->put('coupon', [
            'code' => $coupon->coupon_code,
            'discount' =>$discount
        ]);

        return json_response(['status' => true, 'msg' => trans('frontend_msg.coupon_apply_succ')], 200);

    }

   /*  Coupon destroyed */
    public function destroy(){
        session()->forget('coupon');
        return redirect()->route('frontend.checkout',app()->getLocale())->with('success', 'Coupon has been removed');
    }
}
