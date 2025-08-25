<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Frontend\{Comments,Rating,Product};
use App\Models\{OrderProduct,Order};
use Validator;
class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules['comment'] = 'required';
        $msg['comment.required'] = "Comment is required.";

        $validator = Validator::make($request->all(), $rules,$msg);    
           if ($validator->fails())
                return response()->json(['status' => false, 'msg' => $validator->messages()->first()], 400);          
        
        $obj = new Comments();
        if(isset($request->parent_id))
            $obj->parent_id = $request->parent_id;
        $obj->product_id = @$request->product_id;
        $obj->user_id = auth()->user()->id;
        $obj->comment = $request->comment;
        $obj->save();
        return response()->json(['status' => true,'msg' =>trans('frontend_msg.comment_succ')], 200);
    }

    /* Get comments by prouduct id with filter */
    public function ajax_search_comments(Request $request){
        $query = Comments::query();
        $query->where('product_id',$request->product_id);
        $query->whereNull('parent_id');
        if(isset($request->filter_month))
        $query->whereMonth('created_at', '=', $request->filter_month);

        if(isset($request->filter_year))
        $query->whereYear('created_at', '=', $request->filter_year);

        $query->orderBy('id','DESC');
        $data = $query->paginate(10);
        $html= view('frontend.search.comment_search', ['data' =>$data])->render();
        return response()->json(['status' => true, 'html_response' =>$html,'last_page'=>$data->lastPage(),'current_page'=>$data->currentPage()], 200);
    }

    /* get rating by prouduct id with filter */
    public function ajax_search_rating(Request $request){
        $query = Rating::query();
        $query->where('product_id',$request->product_id);
        $query->whereNull('parent_id');
        if(isset($request->rating))
        $query->where('rating', '=', $request->rating);
        $query->orderBy('id','DESC');
        $data = $query->paginate(10);
        $html= view('frontend.search.rating_search', ['data' =>$data])->render();
        return response()->json(['status' => true, 'html_response' =>$html,'last_page'=>$data->lastPage(),'current_page'=>$data->currentPage()], 200);
    }

    /**
     * Store a newly created rating .
     */
    public function rating_store(Request $request)
    {
        $rules['comment'] = 'required';
        $rules['rating'] = 'required';
        $rules['pid'] = 'required';
        $msg['comment.required'] = "Comment is required.";
        $msg['rating.required'] = "Rating is required.";

        $validator = Validator::make($request->all(), $rules,$msg);    
           if ($validator->fails())
                return response()->json(['status' => false, 'msg' => $validator->messages()->first()], 400);          
        $product = Product::where('slug',$request->pid)->first();
        if($product){
            $is_exist = Order::where(['user_id' => auth()->id(),'tnx_id'=>$request->txid])->first();
            //check if login user and tnx_id exists 
            if($is_exist){

                $obj = Rating::firstOrNew(['id'=>$request->rid]);
                $obj->product_id = $product->id;
                $obj->user_id = auth()->user()->id;
                $obj->comment = $request->comment;
                $obj->rating = $request->rating;
                $obj->save();
                
                //get the average rating of specific product ID and store into product table
                $rating = Rating::where('product_id', $product->id)->avg('rating');
                $product->rating = $rating;
                $product->save();
                return response()->json(['status' => true,'msg' =>trans('frontend_msg.review_succ'),'url'=>route('frontend.profile', [app()->getLocale(),'tab'=>'my-downloads'])], 200);
            }
        }

        return response()->json(['status' => false,'msg' =>trans('frontend_msg.something_went_wrong')], 200);
    }
}
