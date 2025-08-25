<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\ProductSubCategory;
use App\Models\Admin\ProductCategory;
use Validator;
use Illuminate\Validation\Rule; 
class ProductSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ProductSubCategory::orderBy('id','DESC')->paginate(10);
        return view('admin.product.subcategory.index',compact('data'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['all_category']= ProductCategory::where('is_active',1)->get();
        return view('admin.product.subcategory.create_or_edit', $data);
    }
    /**
     * Store a newly created and update resource in storage.
     */
    public function store(Request $request)
    {
        $rules['name'] = 'required';
        $rules['slug'] = ['required',Rule::unique('product_sub_categories')->where(function($query) use($request){
            $query->where('id', '!=', @$request->sub_id);
        })];
        $msg['name.required'] = trans('msg.sub_category_name');
        $msg['slug.required'] = trans('msg.sub_category_slug');
        $msg['sub_parent.required'] = trans('msg.sub_parent_category');

        $validator = Validator::make($request->all(), $rules,$msg);
        if ($validator->fails())
            return response()->json(['status' => false, 'msg' => $validator->messages()->first()], 400);  
        $obj = ProductSubCategory::firstOrNew(['id'=>$request->sub_id]);
        $obj->name = $request->name;
        $obj->slug = \Str::slug($request->slug);
        $obj->category_id = $request->category_id;      
        $obj->is_featured = @$request->is_featured ?? 0;      
        $obj->save();
        $msg = (isset($request->sub_id) && !empty($request->sub_id))? trans('msg.sub_category_upd') : trans('msg.sub_category_add');     
        return response()->json(['status' => true,'msg' =>$msg,'url'=>route('admin.subcategory.index')], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['all_category']= ProductCategory::where('is_active',1)->get();
        $data['all_subcat'] = ProductSubCategory::find($id);        
        if(empty($data)){
          return redirect()->route('admin.subcategory.edit');
        }
        return view('admin.product.subcategory.create_or_edit',$data);  
    }
 /**
     * Deleted the specified resource.
     */
  
    public function destroy(string $id)
    {
        $data = ProductSubCategory::find($id);
        $data->delete();
        return response()->json(['status' => true,'msg' =>trans('msg.sub_category_del')], 200);       
    }
    
    public function subcategoryView()
    {
         return view('admin.product.subcategory.subcategoryView');  
    }
 

}
