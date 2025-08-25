<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\{Order,OrderProduct,Wallet};

class OrderController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Order = new Order();
        $data['data'] =  $Order->filter()->orderBy('id','DESC')->paginate(10);

        $data['today_revenue'] = $Order->whereDate('created_at', today())->sum('billing_total');
        $data['weekly_revenue'] = $Order->whereBetween('created_at', [today()->startOfWeek(), today()->endOfWeek()])->sum('billing_total');
        $data['monthly_revenue'] = $Order->whereBetween('created_at', [today()->startOfMonth(), today()->endOfMonth()])->sum('billing_total');
        $data['total_revenue'] = $Order->sum('billing_total');
            
        $data['searchable'] =  Order::$searchable;
        return view('admin.order.index',$data);
    }
   
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Order::find($id);
        if(empty($data)){
            return redirect()->route('admin.order.index');
        }
        return view('admin.order.show',compact('data'));
    }

   

    /**
     * Update the status specified resource in storage.
     */
    public function update_status(Request $request)
    {
        $obj = Order::find($request->id);
        $obj->status = $request->status;
        $obj->save();

        if($obj->status == 1)
        {
            $orderProduct = OrderProduct::where('order_id',$obj->id)->get();
            foreach ($orderProduct as $key => $value) {
                Wallet::create([
                    'user_id' => $value->vendor_id,
                    'type' => "SALE",
                    'credit' => $value->vendor_amount,
                ]);

                $product = Product::find($value->product_id);
                $product->sale_count = $product->sale_count + 1;
                $product->save(); 
                sleep(2);
            }

        }


        return response()->json(['status' => true,'msg' =>trans('msg.status_update'),'url'=>route('admin.order.index')], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Order::find($id);
        $data->delete();
        return response()->json(['status' => true,'msg' =>trans('msg.category_del')], 200);       
    }
}
