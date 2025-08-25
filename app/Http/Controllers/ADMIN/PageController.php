<?php

namespace App\Http\Controllers\ADMIN;
use App\Http\Controllers\Controller;
use App\Models\Admin\Page;
use Illuminate\Http\Request;
use Validator;

class PageController extends Controller
{
     /**
     * Display a listing of the Page.
     */
    public function index(Request $request)
    {
        $data = Page::orderBy('id','DESC')->paginate(10);
        return view('admin.pages.index',compact('data'));
    }
    /**
     * Store a newly created and update Page in storage.
     */
    public function store(Request $request)
    {
        $rules['sub_heading'] = 'required';
        $rules['description'] = 'required';
        $rules['meta_title'] = 'required';
        $rules['meta_keywords'] = 'required';
        $rules['meta_desc'] = 'required';

        $msg['sub_heading.required'] =  trans('msg.sub_heading');
        $msg['description.required'] =  trans('msg.description');
        $msg['meta_title.required'] =  trans('msg.meta_title');
        $msg['meta_keywords.required'] =  trans('msg.meta_keywords');
        $msg['meta_desc.required'] =  trans('msg.meta_description');

        $validator = Validator::make($request->all(), $rules,$msg);    
        if ($validator->fails())
        return response()->json(['status' => false, 'msg' => $validator->messages()->first()], 400); 
        $obj = Page::firstOrNew(['id'=>$request->id]);
        if(empty($request->id))
        $obj->slug = $request->slug;
        $obj->heading = $request->heading;
        $obj->sub_heading = $request->sub_heading;
        $obj->description = $request->description;
        $obj->meta_title = $request->meta_title;
        $obj->meta_keywords = $request->meta_keywords;
        $obj->meta_desc = $request->meta_desc;
        $obj->save();
        $msg = (isset($request->id) && !empty($request->id))? trans('msg.page_upd') : trans('msg.page_add');
        return response()->json(['status' => true,'msg' =>$msg,'url'=>route('admin.pages.index')], 200);
    }
     /**
     * Show the form for creating a new resource.
     */

     public function create()
     {
        return view('admin.pages.create_or_edit');
     }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Page::find($id);
        if(empty($data)){
          return redirect()->route('admin.pages.index');
        }
        return view('admin.pages.create_or_edit',compact('data'));
    }

 /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        $obj = Page::find($id);
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
         $data = Page::find($id);
         $data->delete();
         return response()->json(['status' => true,'msg' =>trans('msg.page_del')], 200);       
     }

}


