<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Order,OrderProduct};

class OrderController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $Order = new OrderProduct();
        $data['data'] =  $Order->filter()->where('vendor_id',$user->id)->orderBy('id','DESC')->paginate(10);

        $data['today_revenue'] = $Order->where('vendor_id',$user->id)->whereDate('created_at', today())->sum('vendor_amount');
        $data['weekly_revenue'] = $Order->where('vendor_id',$user->id)->whereBetween('created_at', [today()->startOfWeek(), today()->endOfWeek()])->sum('vendor_amount');
        $data['monthly_revenue'] = $Order->where('vendor_id',$user->id)->whereBetween('created_at', [today()->startOfMonth(), today()->endOfMonth()])->sum('vendor_amount');
        $data['total_revenue'] = $Order->where('vendor_id',$user->id)->sum('vendor_amount');
            
        $data['searchable'] =  OrderProduct::$searchable;
        return view('author.order.index',$data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = OrderProduct::find($id);
        if(empty($data)){
            return redirect()->route('vendor.order.index');
        }
        return view('author.order.show',compact('data'));
    }
}
