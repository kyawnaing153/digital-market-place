<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Validator, Auth, Redirect, Mail;
use App\Models\{User,VendorRequest};
use DB, Socialite, Hash, Response, URL, Session, DataTables, Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Http\Middleware\ValidateSessionToken;

class UserController extends Controller
{
    /**
     * user login by credentails
     */
	function login(Request $request)
	{
		$rules['email'] = 'required|email';
		$rules['password'] = 'required';

		$msg['email.required'] = trans('frontend_msg.req_email');
		$msg['email.email'] = trans('frontend_msg.wrong_email_format');
		$msg['password.required'] = trans('frontend_msg.req_password');

		$validator = Validator::make($request->all(), $rules, $msg);
		if ($validator->fails())
			return json_response(['status' => false, 'msg' => $validator->messages()->first()], 400);

		$userdata = ['email' => $request->email, 'password' => $request->password];
		if (Auth::attempt($userdata)) // CHECK LOGIN
		{
			$user = Auth::user();
			if($user->is_active == 0){  //check user is active or not
				return json_response(['status' => false,'msg' =>trans('frontend_msg.blockuser')], 400);
			} 
			if($user->is_email_verified == 0){ //check user's email is verified or not
				$this->sendMail($user,'registration'); //sent email to verify mail
				Auth::logout(); //user logout
			    return json_response(['status' => false,'msg' =>trans('frontend_msg.email_not_verify')], 400); 
			}

			return json_response(['status' => true, 'url' =>"", 'msg' => trans('frontend_msg.succ_login')], 200);
		} else {
			return json_response(['status' => false, 'msg' => trans('frontend_msg.wrong_credential')], 400);
		}
	}

	/**
     * user signup
     */
	public function signup(Request $request)
	{
		$rules = [
			'name'    => 'required|min:3|max:25',
			'email' => 'unique:users,email',
			'password' => 'required|min:6',
		];
		$msg['name.required'] = trans('frontend_msg.req_name');
		$msg['email.required'] = trans('frontend_msg.req_email');
		$msg['email.email'] = trans('frontend_msg.wrong_email_format');
		$msg['email.unique'] = trans('frontend_msg.unique_email_format');
		$msg['password.required'] = trans('frontend_msg.new_password');
		$msg['confirm_password.required'] = trans('frontend_msg.req_confirmPassword');
		$msg['confirm_password.same'] = trans('frontend_msg.password_confirmed_not_match');
	
		$validator = Validator::make($request->all(), $rules, $msg);
		if ($validator->fails()) {
			return json_response(['status' => false, 'msg' => $validator->messages()->first()], 400);
		}

		$obj = new User();
		$obj->full_name  = $request->name;
		$obj->email  = $request->email;
		$obj->password  = bcrypt($request->password);
		$obj->role  = 1; 
		$obj->role_type  = "USER"; 
		$user = $obj->save();

		$this->sendMail($obj ,'registration'); //sent email to verify mail

		if ($user)
			return json_response(['status' => true, 'url' => route('frontend.sign-in',app()->getLocale()), 'msg' => trans('frontend_msg.succ_signup_with_email_verify')], 200);
		else
			return json_response(['status' => false, 'msg' => trans('frontend_msg.something_went_wrong')], 400);
	}

	/**
     * user logout
     */
	public function logout(Request $request)
	{
		Auth::logout();
		return redirect()->back();
	}

	/**
     * user update our profile
     */
	public function updateProfile(Request $request)
	{
		$rules = [
			'username'    => ['required','min:6','max:25',Rule::unique('users')->where(function($query) use($request){
				$query->where('id', '!=', Auth::id());
			})],
			'full_name'    => 'required|min:3|max:25',
		];

		$msg['name.required'] = trans('frontend_msg.req_name');
		$validator = Validator::make($request->all(), $rules, $msg);

		if ($validator->fails()) {
			return json_response(['status' => false, 'msg' => $validator->messages()->first()], 400);
		}

		$obj = Auth::user();
		$obj->full_name  = $request->full_name;
		$obj->username  = $request->username;
		if(@$request->mobile)
		$obj->mobile = $request->mobile;
		$obj->country_id = $request->country_id;
		$obj->city = $request->city;
		$obj->state = $request->state;
		$obj->address = $request->address;
		$user = $obj->save();
		if ($user)
			return json_response(['status' => true, 'msg' => trans('frontend_msg.succ_update_profile'),'url'=>route('frontend.profile', app()->getLocale())], 200);
		else
			return json_response(['status' => false, 'msg' => trans('frontend_msg.something_went_wrong')], 400);
	}

	// CHANGE PASSWORD
	function change_password(Request $request)
	{
		$rules['old_password'] = 'required';
		$rules['password'] = ['required', 'min:6','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'];
		$rules['confirm_password'] = 'required|same:password';
		$msg['old_password.required'] = trans('frontend_msg.req_old_password');
		$msg['password.required'] = trans('frontend_msg.new_password');
		$msg['password.min'] = trans('frontend_msg.req_password_min');
		$msg['password.regex'] = trans('frontend_msg.invalid_password_format');
		$msg['confirm_password.required'] = trans('frontend_msg.req_confirmPassword');
		$msg['confirm_password.same'] = trans('frontend_msg.password_confirmed_not_match');

		$validator = Validator::make($request->all(), $rules, $msg);
		if ($validator->fails())
			return json_response(['status' => false, 'msg' => $validator->messages()->first()], 400);
		
		$user = User::find(Auth::user()->id);
		if (!Hash::check($request->old_password, $user->password)){// CHECK OLD PASSWORD
			return json_response(['status' => false, 'msg' => trans('frontend_msg.invalid_old_password')], 400);
		}
		if($request->old_password == $request->password){
            return json_response(['status' => false, 'msg' => trans('frontend_msg.old_pas_current_pass_not_same')], 400);
        }
	
		$user->password = bcrypt($request->password);
		$user->save();
		return json_response(['status' => true, 'msg' => trans('frontend_msg.succ_update_password')], 200);
	}

	//UPDATE IMAGE
	function update_user_image(Request $request)
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

	// SEND MAIL FOR RESET FORGET PASSWORD 
	function forgot_password(Request $request)
	{
		$rules['email'] = 'required|email';
		$msg['email.required'] = trans('frontend_msg.req_email');
		$msg['email.email'] = trans('frontend_msg.wrong_email_format');
		$validator = Validator::make($request->all(), $rules, $msg);
		if ($validator->fails())
			return json_response(['status' => false, 'msg' => $validator->messages()->first()], 400);

		$user = User::where('email', '=', $request->email)->first();
		if (empty($user)) {
			return json_response(['status' => false, 'msg' => trans('frontend_msg.user_not_register')], 400);
		}

		$passReset  = DB::table('password_reset_tokens')->where('email', $request->email)->orderBy('created_at', 'DESC')->first();
		//check if the existing email created time is greater than to current time
		if (!empty($passReset) && $passReset->created_at > date('Y-m-d H:i:s')) { 
			return json_response(['status' => true, 'msg' => trans('frontend_msg.already_password_reset_send_mail')], 200);
		}else{
			DB::table('password_reset_tokens')->where('email', $request->email)->delete();
		}

		$check = $this->sendMail($user,'forget_password'); //Send forgot password mail 

		if ($check) {
			return json_response(['status' => true, 'msg' => trans('frontend_msg.succ_password_reset_send_mail')], 200);
		} else {
			return json_response(['status' => false, 'msg' => trans('frontend_msg.failed_password_reset_send_mail')], 400);
		}
	}

	// UPDATE RESET PASSWORD
	public function update_reset_password(Request $request)
	{
		$rules['token'] = 'required|exists:password_reset_tokens,token';
		$rules['password'] = 'required';
		$rules['confirmpassword'] = 'required|same:password';

		$msg['token.required'] = trans('frontend_msg.req_token');
		$msg['token.exists'] = trans('frontend_msg.invalid_token');
		$msg['password.required'] = trans('frontend_msg.new_password');
		$msg['password.min'] = trans('frontend_msg.req_new_password_min');
		$msg['password.regex'] = trans('frontend_msg.invalid_new_password_format');
		$msg['confirmpassword.required'] = trans('frontend_msg.req_confirmPassword');
		$msg['confirmpassword.same'] = trans('frontend_msg.new_password_confirmed_not_match');

		$validator = Validator::make($request->all(), $rules, $msg);
		if ($validator->fails())
			return json_response(['status' => false, 'msg' => $validator->messages()->first()], 400);

		$tokenData = DB::table('password_reset_tokens')->where('token', $request->token)->first();
		if (empty($tokenData))
			return json_response(['status' => false, 'msg' => trans('frontend_msg.invalid_token')], 400);

		//updated password
		$user = User::where('email', $tokenData->email)->first();
		$user->update(["password" => bcrypt($request->password)]);
		//destroyed email
		DB::table('password_reset_tokens')->where('email', $tokenData->email)->delete();
		if($user->role == 0)//Check role is admin redirect to admin login 
		$url = route('admin.login');
		else
		$url = route('frontend.sign-in',app()->getLocale());
		return json_response(['status' => true, 'msg' => trans('frontend_msg.succ_update_password'), 'url' => $url], 200);
	}

	/**
     * common function for sending mail
     */
	public function sendMail($request,$type){

		$setting = (object) DB::table('settings')->pluck('short_value','key')->toArray();
		if($setting->is_checked_smtp == 1){ //if user have set smtp credentails
			if (DB::table('password_reset_tokens')->where('email', $request->email)->exists()) {
				DB::table('password_reset_tokens')->where('email', $request->email)->delete();
			}
			$token = unique_key(); // GENERATE TOKEN
			DB::table('password_reset_tokens')->insert(['email' => $request->email, 'token' => $token, 'created_at' => date('Y-m-d H:i:s', strtotime('+4 hour'))]);
			
			if($type == 'registration'){
				$template = $setting->registration_template;
				$link_text = '<a href="'.route('frontend.email-verify', [app()->getLocale(),"token" => $token]).'">'.$setting->reg_link_text.'</a>';
				$subject = trans('frontend_msg.subject_email_verification');
			}
			elseif($type == 'forget_password'){
				$template = $setting->forget_password_template;
				$link_text = '<a href="'.route('frontend.reset-password',[app()->getLocale(),"token" => $token]).'">'.$setting->forget_pass_link_text.'</a>';
				$subject = trans('frontend_msg.subject_forget_password');
			}
			$final_template = "";

			if($setting->is_checked_logo_on_mail)  //if checked logo on mail
			{
				$final_template .=  '<img src="'.\Storage::url(getSettingShortValue('my_logo')).'" alt="logo" width="200px" height="50px" > </br> </br>'."\r\n";
			}
	
			//get an email template from the database and replace the template content
			$new_template = str_replace('[username]',$request->full_name ?? 'username',$template);
			$new_template = str_replace('[break]','</br>',$new_template);
			$new_template = str_replace('[linktext]',$link_text,$new_template);

			$final_template .= $new_template;
	
			$obj = (object)[];
			$obj->receiver_email = $request->email;
			$obj->template = $final_template;
			$obj->subject = $subject;
			return send_mail($obj);  //custom helper function 
		}

		return false;
	}

	/**
     * request for become an vendor 
     */
	public function become_an_vendor_request(Request $request){

		$rules['answer'] = 'required';
		$rules['answer.0'] = 'required';
		$rules['answer.1'] = 'required';

		$msg['answer'] = trans('frontend_msg.select_options');
		$msg['answer.*'] = trans('frontend_msg.select_options');

		$validator = Validator::make($request->all(), $rules, $msg);
		if ($validator->fails())
			return json_response(['status' => false, 'msg' => $validator->messages()->first()], 400);

		$obj = new VendorRequest();
		$obj->user_id = Auth::id();
		$obj->fill($request->all());
		$obj->answers = json_encode($request->answer);
		$data = $obj->save();
		if($data)
		return json_response(['status' => true, 'url' =>route('frontend.profile', [app()->getLocale(), 'tab' => 'become-an-author']), 'msg' => trans('frontend_msg.become_an_vendor_request_succ')], 200);
		else
		return json_response(['status' => false, 'url' =>"", 'msg' => trans('frontend_msg.something_went_wrong')], 400);
	}
}
