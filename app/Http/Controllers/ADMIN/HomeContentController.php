<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\HomeContent;
use Validator;
class HomeContentController extends Controller
{
    /**
     * Display a listing of the Homecontent.
     */
    public function index()
    {
        $data = HomeContent::whereNot('type','Advertisement')->paginate(10);
        return view('admin.home_content.index',compact('data'));
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(request $request)
    {
        $rules['heading'] = 'required';
        $rules['sub_heading'] = 'required';

        $validator = Validator::make($request->all(), $rules);    
        if ($validator->fails())
        return response()->json(['status' => false, 'msg' => $validator->messages()->first()], 400); 
        $obj = HomeContent::firstOrNew(['id'=>$request->id]);
        $obj->heading = $request->heading;
        $obj->sub_heading = $request->sub_heading;
        $obj->type = $request->type;
        if($request->page_name)
        $obj->page_name = $request->page_name;
        $obj->save();
        $msg = (isset($request->id) && !empty($request->id))? trans('msg.content_upd') : trans('msg.content_add');
        return response()->json(['status' => true,'msg' =>$msg,'url'=>route('admin.home_content.index')], 200);
    }

    /**
     * Show a newly created resource in storage.
     */
    public function create()
    {
        return view('admin.home_content.create_or_edit');
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
        $data = HomeContent::find($id);
        if(empty($data)){
          return redirect()->route('admin.home_content.index');
        }
        return view('admin.home_content.create_or_edit',compact('data'));
    }

    /**
     * Update the status ative and deactive.
     */
    public function update(Request $request, string $id)
    {
        $obj = HomeContent::find($id);
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
        $data = HomeContent::find($id);
        $data->delete();
        return response()->json(['status' => true,'msg' =>trans('msg.content_del')], 200);       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function advertise_store(Request $request){
        $obj = HomeContent::firstOrNew(['id'=>$request->id]);
        $obj->link = $request->link;
        $obj->heading = $request->heading;
        $obj->page_name = $request->page_name;
        $obj->type = $request->type;
        $obj->save();
        $msg = (isset($request->id) && !empty($request->id))? 'Advertisement updated successfully.' : 'Advertisement added successfully.';
        return response()->json(['status' => true,'msg' =>$msg,'url'=>route('admin.advertise.index')], 200);      
    } 

    /**
     * Show advertise view.
     */  
    public function advertise_view(){
      $data['data'] = HomeContent::where(['type'=>'Advertisement'])->paginate(10);
      return view('admin.advertise.index',$data);
    }

    /**
     * Show a newly created resource in storage.
     */
    public function advertise_create()
    {
        return view('admin.advertise.create_or_edit');
    }

    /**
     * edit a newly created resource in storage.
     */
    public function advertise_edit(string $id)
    {
        $data = HomeContent::find($id);
        if(empty($data)){
          return redirect()->route('admin.advertise.index');
        }
        return view('admin.advertise.create_or_edit',compact('data'));
    }
}
