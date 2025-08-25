<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\{DiscountCoupon,Product};
use Validator;
use Illuminate\Validation\Rule;
class DiscountCouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {       
        $data['data'] = DiscountCoupon::filter()->orderBy('id','DESC')->paginate(10);
        $data['searchable'] = DiscountCoupon::$searchable;
        return view('admin.discount_coupon.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['product']= Product::select('id','name')->where('is_active',1)->get();
        return view('admin.discount_coupon.create_or_edit',$data);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules['coupon_name'] = 'required';
        $rules['coupon_code'] = ['required',Rule::unique('discount_coupons')->where(function($query) use($request){
            $query->where('id', '!=', @$request->id);
        })];
        $rules['coupon_description'] = 'required';
        $msg['coupon_name.required'] = trans('msg.coupon_name');
        $msg['coupon_code.required'] = trans('msg.coupon_code');
        $msg['coupon_description.required'] = trans('msg.coupon_description');"";
        $validator = Validator::make($request->all(), $rules,$msg);    
           if ($validator->fails())
                return response()->json(['status' => false, 'msg' => $validator->messages()->first()], 400);          
        
        $obj = DiscountCoupon::firstOrNew(['id'=>$request->id]);
        $obj->fill($request->all());
  
        $obj->product_id = isset($request->product_id) ? json_encode($request->product_id) : NULL;
        $obj->cannot_applied_product_id = isset($request->cannot_applied_product_id) ?json_encode($request->cannot_applied_product_id): NULL;
        $obj->save();
        $msg = (isset($request->id) && !empty($request->id))?  trans('msg.coupon_upd') : trans('msg.coupon_succ');
        return response()->json(['status' => true,'msg' =>$msg,'url'=>route('admin.discount_coupon.index')], 200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = DiscountCoupon::find($id);
        if(empty($data)){
          return redirect()->route('admin.discount_coupon.index');
        }
        $data['data'] = $data;
        $data['product']= Product::select('id','name')->where('is_active',1)->get();
        return view('admin.discount_coupon.create_or_edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        $obj = DiscountCoupon::find($id);
        if($obj->is_active == 1){
            $obj->is_active = 0;
            $msg = trans('msg.de_active');
        }
        else{
            $obj->is_active = 1;
            $msg = trans('msg.active');
        }
        $obj->save();
        return response()->json(['status' => true,'msg' =>$msg], 200);
    }

      /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = DiscountCoupon::find($id);
        $data->delete();
        return response()->json(['status' => true,'msg' =>trans('msg.coupon_del')], 200);       
    }
    
}