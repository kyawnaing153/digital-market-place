<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Frontend\{Product,ProductMeta,Wishlist};
use Cart,Auth;
class CartController extends Controller
{
     /**
     * Display a listing of the cart items.
     */
    public function index() {

        //$product_items = Product::where(['is_active'=>1])->whereNotNull('published_at')->mightAlsoLike()->get();
        $product_items = Product::mightAlsoLike()->get();
        #dd($product_items);
        return view('frontend.cart.index')->with('product_items', $product_items);
    }

     /**
     * Store a product in a cart
     */
    public function store(request $request) {
       
        /* if the request has the buy_now flag after adding the product to a cart redirect to the checkout page otherwise redirect to the cart index */
        $url = (@$request->buy_now == 1) ? route('frontend.checkout',app()->getLocale()) : route('frontend.cart.index',app()->getLocale());
        
        $product = Product::where('slug',$request->slug)->first();  //check whether slug exists or not
        if(empty($product)){
            return response()->json(['status' => false, 'msg' => trans('frontend_msg.prod_not_found')], 400); 
        }

        session()->forget('coupon');  //Coupon destroyed
        $duplicates = Cart::instance('default')->search(function($cartItem, $rowId) use($product) {
            return $cartItem->id == $product->id;
        });
     
        /* if check item already in a cart */
        if($duplicates->isNotEmpty()) {
            return response()->json(['status' => true, 'msg' => trans('frontend_msg.item_in_your_cart'),'url'=>$url], 200); 
        } 
      
        $productPrice = ($product->is_free == 1) ? 0 : $product->price;
        $productName = $product->name;
        $downlaodfileArr = [];

        /* if the product has multiple prices then we have to add all prices. */
        $ProductMeta = (object) ProductMeta::where('product_id',$product->id)->pluck('value','key')->toArray();
        $priceArr = unserialize(@$ProductMeta->multi_price);
        $fileArr = unserialize(@$ProductMeta->multi_file);

        $variants = [];
        if(isset($request->price_id) && !empty($request->price_id))
        {
            if($product->is_offer){
                if($product->is_offer == 1)
                    $productPrice = $product->offer_price;
                elseif($product->is_offer == 2 && $product->start_offer < date('Y-m-d H:i:s') && $product->end_offer > date('Y-m-d H:i:s'))
                    $productPrice = $product->offer_price;
                else
                    $productPrice = $product->price;
            }
          
            $sum = 0;
            $str = ":-";
            
        
            foreach ($request->price_id as $key => $price_id){
    
                foreach($priceArr as $k => $row2)
                {
                    if($price_id == $row2['price_id']){
                        $p = (float) (($product->is_offer != 0) ? $row2['offer_price'] : $row2['price']);
                        $sum += $p;
                        $str .= (($key == 0)? ' ' : ' ,').$row2['option_name'];

                        $variantArr['price_id'] = $row2['price_id'];
                        $variantArr['option_name'] = $row2['option_name'];
                        $variantArr['price'] = $p;
                        $variants[] = $variantArr;
                    }
                }
            }
            $productPrice = $sum;
            $productName .= ' '. $str;
        }
        else
        {
            if($product->is_offer && $product->is_free != 1){
                if($product->is_offer == 1)
                    $productPrice = $product->offer_price;
                elseif($product->is_offer == 2 && $product->start_offer < date('Y-m-d H:i:s') && $product->end_offer > date('Y-m-d H:i:s'))
                    $productPrice = $product->offer_price;
            }
        }


        /* created a default cart array for storing cart values */
        Cart::instance('default')->add($product->id, $productName, 1, $productPrice, ['variants' => $variants])->associate('App\Models\Frontend\Product');
        #dd(Cart::instance('default')->content());
       
        return response()->json(['status' => true, 'msg' => trans('frontend_msg.prod_added_to_cart'),'url'=>$url], 200); 
    }

    /**
     * Remove the specified resource from cart.
     */
    public function destroy($lang,$id, $cart) {
        if($cart == 'default')
        Cart::instance('default')->remove($id);
        session()->flash('success', 'item has been removed');
        return back();
    }

    public function saveLater($id) {
        session()->forget('coupon');
        $item = Cart::get($id);
        Cart::remove($id);
        $duplicates = Cart::instance('saveForLater')->search(function($cartItem, $rowId) use ($id) {
            return $rowId == $id;
        });
        if($duplicates->isNotEmpty()) {
            session()->flash('success', 'Item is already saved for later');
            return redirect()->route('frontend.cart.index');
        
        }
        Cart::instance('saveForLater')->add($item->id, $item->name, 1, $item->price)->associate('App\Models\Frontend\Product');
        session()->flash('success', 'Item has been saved for later');
        return redirect()->route('frontend.cart.index');
    }
    
    public function addToCart($id) {
        session()->forget('coupon');
        $item = Cart::instance('saveForLater')->get($id);

        Cart::instance('saveForLater')->remove($id);
        $exist = Cart::instance('default')->search(function($cartItem, $rowId) use($item) {
            return $cartItem->id == $item->id;
        });
        if($exist->isNotEmpty()) {
            session()->flash('success', 'Item is already in the cart');
            return redirect()->route('frontend.cart.index');
        }
        Cart::instance('default')->add($item->id, $item->name, 1, $item->price)->associate('App\Models\Frontend\Product');
        #dd(Cart::instance('default')->content());
        session()->flash('success', 'item added to the cart');
        return redirect()->route('frontend.cart.index');
    }
    
    /**
     * Store a newly created and update resource in storage.
     */
    public function addToWishlist(request $request) {
        $product = Product::where('slug',$request->slug)->first();
        if(empty($product)){
            return response()->json(['status' => false, 'msg' => trans('frontend_msg.prod_not_found')], 400); 
        }
        $userId = Auth::id();
        $isExist = Wishlist::where(['user_id'=>$userId,'product_id'=>$product->id])->first();
        if($isExist) //if product already exists ,delete the wishlist
        {
            $isExist->delete();
            return response()->json(['status' => true, 'msg' => trans('frontend_msg.item_remove_form_wishlist')], 200);
        }
        $obj = Wishlist::firstOrNew(['user_id'=>$userId,'product_id'=>$product->id]);
        $obj->user_id = $userId;
        $obj->product_id = $product->id;
        $obj->save();
        return response()->json(['status' => true, 'msg' => trans('frontend_msg.prod_added_to_wishlist')], 200);
    }

     /**
     * Remove the specified resource from wishlist.
     */
    public function removefromWishlist(request $request) {
        $data = Wishlist::find($request->id);
        if(!empty($data))
           $data->delete();
        return back();
    }
}
