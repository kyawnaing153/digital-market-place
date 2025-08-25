<?php

namespace App\Http\Controllers\ADMIN;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator,Hash,Auth,DB;
use App\Models\User;
class AdminController extends Controller
{

    //Admin Login 
    function login(Request $request)
    {
        $rules['email'] = 'required|email';
        $rules['password'] = 'required';
        
        $msg['email.required'] = trans('msg.req_email');
        $msg['email.email'] = trans('msg.wrong_email_format');
        $msg['password.required'] = trans('msg.req_password');

        $validator = Validator::make($request->all(), $rules,$msg);
        if ($validator->fails())
            return response()->json(['status' => false, 'msg' => $validator->messages()->first()], 400);
        $userdata = ['email'=> $request->email,'password'=> $request->password, 'role'=>0];
        #$userdata = ['email'=> $request->email, 'role'=>0];
        #dd($userdata);
        if (Auth::attempt($userdata)) // CHECK LOGIN
        {
            return response()->json(['status' => true,'msg' =>trans('msg.succ_login'),'url'=>route('admin.dashboard')], 200);
        }
        else{
            return response()->json(['status' => false, 'msg' =>trans('msg.wrong_credential1')], 400);
        }
    }
    //Admin logout
    function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    //Admin Update profile
    function update_profile(request $request)
    {
    $user = Auth::user();
    if($request->old_password){
        $rules['password'] = ['required', 'min:6'];
        $rules['confirm_password'] = 'required|same:password';
        $msg['old_password.required'] = trans('msg.req_old_password');
        $msg['password.required'] = trans('msg.new_password');
        $msg['password.min'] = trans('msg.req_password_min');
        $msg['password.regex'] = trans('msg.invalid_password_format');
        $msg['confirm_password.required'] = trans('msg.req_confirmPassword');
        $msg['confirm_password.same'] = trans('msg.password_confirmed_not_match');

        $validator = Validator::make($request->all(), $rules, $msg); // CHECK VALIDATION
        if ($validator->fails())
            return response()->json(['status' => false, 'msg' => $validator->messages()->first()], 400);
        
        if (!Hash::check($request->old_password, $user->password)){ // CHECK OLD PASSWORD
            return response()->json(['status' => false, 'msg' => trans('msg.invalid_old_password')], 400);
        }
        if($request->old_password == $request->password){
            return response()->json(['status' => false, 'msg' => trans('msg.old_pas_current_pass_not_same')], 400);
        }
        $user->password = bcrypt($request->password);
    }
    
    $user->full_name = $request->full_name;
    $user->mobile = $request->mobile;
    $res = $user->save();
    return response()->json(['status' => true, 'msg' => trans('msg.succ_update_profile')], 200); 
    }
}
