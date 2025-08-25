<?php

namespace App\Http\Controllers\Author;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator,Hash,Auth,DB;
use App\Models\{User,UserAdditionalInfo};
class AuthorController extends Controller
{

    //Author Login 
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
        $userdata = ['email'=> $request->email,'password'=> $request->password, 'role'=>2];
        if (Auth::attempt($userdata)) // CHECK LOGIN
        {
            return response()->json(['status' => true,'msg' =>trans('msg.succ_login'),'url'=>route('vendor.dashboard')], 200);
        }
        else{
            return response()->json(['status' => false, 'msg' =>trans('msg.wrong_credential')], 400);
        }
    }
    //Author logout
    function logout()
    {
        Auth::logout();
        return redirect()->route('vendor.login');
    }

    //Author Update profile
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
        $user->username = $request->username;
        $user->mobile = $request->mobile;
        $res = $user->save();
        return response()->json(['status' => true, 'msg' => trans('msg.succ_update_profile')], 200); 
    }
    
    //Author Addtional info like Bank Details
    function additionalInfo(request $request)
    {
        $request->request->remove('_token');
        $input = $request->all();
        if(count($input) > 0){
            foreach ($request->all() as $key => $value)
            {
                $obj = UserAdditionalInfo::firstOrNew(['key' => $key]);
                $obj->user_id = auth()->id();
                $obj->key = $key;
                $obj->value = $value;
                $obj->save();
            }
            return response()->json(['status' => true,'msg' =>trans('msg.succ_update_profile')], 200);
        }
        return response()->json(['status' => false,'msg' =>trans('msg.something_went_wrong')], 400);
    }
    
    //UPDATE IMAGE
	function update_image(Request $request)
	{
		$rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1000';
		$msg['image.required'] = trans('frontend_msg.req_user_image');
		$msg['image.mimes'] = trans('frontend_msg.req_user_image_mimes');
		$msg['image.max'] = trans('frontend_msg.req_user_image_max');

		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails())
			return json_response(['status' => false, 'msg' => $validator->messages()->first()], 400);

		$obj = Auth::user();
		$obj->save();
		return json_response(['status' => true, 'msg' => trans('frontend_msg.succ_update_user_image'),'url'=>route('frontend.profile', app()->getLocale())], 200);
	}
}
