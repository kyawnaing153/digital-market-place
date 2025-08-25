<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;
use Validator;
use Illuminate\Validation\Rule;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['data'] = User::filter()        
        ->select('users.id','users.full_name','users.email')
        ->join('orders','users.id','=','orders.user_id')
        ->join('order_products','orders.id','=','order_products.order_id')
        ->where('order_products.vendor_id',auth()->id())
        ->groupBy('users.id')
        ->orderBy('users.id','DESC')->paginate(10); //role is User

        $data['searchable'] = [
            'full_name' => 'Name',
            'email' => 'Email',
        ];
        return view('author.users.index',$data);
    }

    /**
     * Show the user details the specified resource.
     */

    public function show($id){

        $data = User::join('orders','users.id','=','orders.user_id')
        ->join('order_products','orders.id','=','order_products.order_id')
        ->where('order_products.vendor_id',auth()->id())
        ->find($id);
        if(empty($data)){
            return redirect()->route('vendor.users.index');
        }
        return view("author.users.show",compact('data'));
    }

   
}
