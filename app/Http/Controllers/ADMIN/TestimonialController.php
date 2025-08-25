<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Testimonial;
use Validator;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Testimonial::all();
        return view('admin.testimonial.index',compact('data'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('admin.testimonial.create_or_edit');
    }
    /**
     * Store a newly created and update resource in storage.
     */
    public function store(Request $request)
    {
        $rules['name'] = 'required';
        $rules['designation'] = 'required';
        $rules['message'] = 'required';
        $msg['name.required'] =trans('msg.testimonial_uname');
        $msg['designation.required'] = trans('msg.designation');
        $msg['message.required'] = trans('msg.message');
        $validator = Validator::make($request->all(), $rules,$msg);    
        if ($validator->fails())
        return response()->json(['status' => false, 'msg' => $validator->messages()->first()], 400);          
        $obj = Testimonial::firstOrNew(['id'=>$request->id]);
        $obj->name = $request->name;
        $obj->designation=$request->designation;
        $obj->is_checked_designation = $request->is_checked_designation ?? 0;
        $obj->message = $request->message;
        $obj->rating = $request->rating;
        $obj->save();
        $msg = (isset($request->id) && !empty($request->id))? trans('msg.testimonial_upd') : trans('msg.testimonial_add');
        return response()->json(['status' => true,'msg' =>$msg,'url'=>route('admin.testimonial.index')], 200);
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Testimonial::find($id);
        if(empty($data)){
          return redirect()->route('admin.testimonial.index');
        }
        return view('admin.testimonial.create_or_edit',compact('data'));
    }

    /**
     * Update the status specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        $obj = Testimonial::find($id);
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
         $data = Testimonial::find($id);
         $data->delete();
         return response()->json(['status' => true,'msg' =>trans('msg.testimonial_del')], 200);       
     }
    
}
