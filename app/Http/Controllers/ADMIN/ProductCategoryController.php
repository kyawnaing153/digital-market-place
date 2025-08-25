<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\ProductCategory;
use Validator;
use Illuminate\Validation\Rule; 
class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['data']= ProductCategory::orderBy('id','DESC')->paginate(10);
        return view('admin.product.category.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.category.create_or_edit');
    }

    /**
     * Store a newly created and update resource in storage.
     */
    public function store(Request $request)
    {
        $rules['name'] = 'required';
        $rules['slug'] = ['required',Rule::unique('product_categories')->where(function($query) use($request){
            $query->where('id', '!=', @$request->category_id);
        })];
        
        $msg['name.required'] = trans('msg.category_name');
        $msg['slug.required'] = trans('msg.category_url');
        $validator = Validator::make($request->all(), $rules,$msg);
        if ($validator->fails())
            return response()->json(['status' => false, 'msg' => $validator->messages()->first()], 400);
        
        $obj = ProductCategory::firstOrNew(['id'=>$request->category_id]);
        $obj->name = $request->name;
        $obj->slug = \Str::slug($request->slug);
        $obj->is_featured = $request->is_featured ?? 0;
        $obj->ishave_product = $request->ishave_product ?? 0;
        $obj->save();

        $msg = (isset($request->category_id) && !empty($request->category_id))? trans('msg.category_upd') : trans('msg.category_add');
        return response()->json(['status' => true,'msg' =>$msg,'url'=>route('admin.pro_category.index')], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = ProductCategory::find($id);
        if(empty($data)){
          return redirect()->route('admin.pro_category.index');
        }
        return view('admin.product.category.create_or_edit',compact('data'));
    }

    /**
     * Update the status active and deactive resource in storage.
     */
    public function update(Request $request, string $id)
    {
         
        $obj = ProductCategory::find($id);
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
       
        $data = ProductCategory::find($id);
        $data->delete();
        return response()->json(['status' => true,'msg' =>trans('msg.category_del')], 200);       
    }
    
    public function categoryView()
    {
        
        return view('admin.product.category.categoryView');
    }

}
