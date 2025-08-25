<?php

namespace App\Http\Controllers\ADMIN;

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
        $data['data'] = User::filter()->where('role',1)->orderBy('id','DESC')->paginate(10); //role is User
        $data['searchable'] = User::$searchable;
        return view('admin.users.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['country'] = Country::all();
        return view('admin.users.create_or_edit',$data);
    }
    /**
     * Store a newly created and update resource in storage.
     */
    public function store(Request $request)
    {  

        $rules['full_name'] = 'required';
        $rules['email'] = ['required',Rule::unique('users')->where(function($query) use($request){
            $query->where('id', '!=', @$request->id);
        })];
        if(!$request->id)
        $rules['password'] = 'required';
        $msg['full_name.required'] =  trans('msg.full_name');
        $msg['email.required'] = trans('msg.email');
        $msg['password.required'] =  trans('msg.password');
    
        $validator = Validator::make($request->all(), $rules,$msg);    
        if ($validator->fails())
            return response()->json(['status' => false, 'msg' => $validator->messages()->first()], 400);       
        
        $obj = User::firstOrNew(['id'=>$request->id]);
        $obj->full_name = $request->full_name;
        $obj->email = $request->email;
        $obj->is_email_verified = $request->is_email_verified;
        if(isset($request->password))      
        $obj->password = bcrypt($request->password);
        $obj->mobile = $request->mobile;
        $obj->address = $request->address;
        $obj->country_id = $request->country;
        $obj->state  = $request->state;
        $obj->city  =  $request->city;
        $obj->role = 1;
        $obj->role_type = "USER";
        $obj->save();

        if($request->sendemail){
            $request->type = 'new_user_temp';
            (new MailController())->send_mail($request);
        }
        $msg = (isset($request->id) && !empty($request->id))?  trans('msg.user_upd') : trans('msg.user_add');
        return response()->json(['status' => true,'msg' =>$msg,'url'=>route('admin.users.index')], 200);
    }    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['country'] = Country::all();
        $data['data'] = User::find($id);
        if(empty($data)){
          return redirect()->route('admin.users.edit');
        }
        return view('admin.users.create_or_edit',$data);
    }
  
     /**
   * Deleted the specified resource.
      */
  
    public function destroy(string $id){
        $data = User::find($id);
        if(empty($data)){
            return redirect()->route('admin.users.index');
        }
        $data->delete();
        return response()->json(['status' => true,'msg' =>trans('msg.user_del')], 200);       
    }

    /**
     * Show the user details the specified resource.
     */

    public function show($id){
        $data = User::find($id);
        if(empty($data)){
            return redirect()->route('admin.users.index');
        }
        return view("admin.users.show",compact('data'));
    }

    /**
     * Update the status specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $obj = User::find($id);
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
}
