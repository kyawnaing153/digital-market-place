<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ADMIN\EmailIntegrationsController;
use Illuminate\Http\Request;
use App\Models\{User};
use App\Models\Frontend\{Contactus,HomeContent,SubscriberEmail};
use Validator,Redirect,DB;
use Carbon\Carbon;
class HomeController extends Controller
{

	/**
     * Store a new contact us request .
     */
	public function postContactus(Request $request){
		$rules = [
			'name'    => 'required|min:3|max:100',
			'email'    => 'required|email|max:150',
			'message' => 'required|max:2000',
		];
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails())
			return json_response(['status' => false, 'msg' => $validator->messages()->first()], 400);
		$request->type = 'Contactus';

		Contactus::create($request->all());
		/**
		 * create subcribe contact
		 */
		(new EmailIntegrationsController())->create_subscribe_user($request);
		return response()->json(['status' => true, 'msg' => trans('frontend_msg.contactus_succ')], 200);
	}

	/**
     * Store a new news letter request .
     */
	public function postNewsletter(Request $request){
		$rules = [
			'email'    => 'required|email|max:150',
		];
		$msg['email.required'] = trans('frontend_msg.req_email');
		$msg['email.email'] = trans('frontend_msg.wrong_email_format');
		$validator = Validator::make($request->all(), $rules,$msg);
		if ($validator->fails())
			return json_response(['status' => false, 'msg' => $validator->messages()->first()], 400);

		$is_exist = SubscriberEmail::where(['email'=>$request->email])->first();
		if($is_exist){
			return response()->json(['status' => false, 'msg' => trans('frontend_msg.already_have_news_letter_email')], 200);
		}
		/**
		 * create subcribe contact  
		 */
		(new EmailIntegrationsController())->create_subscribe_user($request);

		return response()->json(['status' => true, 'msg' => trans('frontend_msg.newsletter_succ')], 200);
	}

	/**
     * after registration verify email
     */
	public function emailVerify(Request $request)
	{
		$rules['token'] = 'required|exists:password_reset_tokens,token';
		$msg['token.required'] = trans('frontend_msg.req_token');
		$msg['token.exists'] = trans('frontend_msg.invalid_token');

		$validator = Validator::make($request->all(), $rules,$msg);
		if ($validator->fails()){
		    $data = ['success'=>false,'message'=>$validator->messages()->first()];
		    return view('email_success_error_page',$data);
		}
		$tokenData = DB::table('password_reset_tokens')->where('token', $request->token)->first();
		if(empty($tokenData)){
		    $data = ['success'=>false,'message'=>trans('frontend_msg.invalid_token')];
		    return view('email_success_error_page',$data);
		}
		//update status 
		User::where('email',$tokenData->email)->update(["is_email_verified" => 1,'email_verified_at'=>Carbon::now()]);

		//destroyed email
		DB::table('password_reset_tokens')->where(['email'=>$tokenData->email])->delete();
		$data = ['success'=>true,'message'=>trans('frontend_msg.succ_email_verified')];

		return view('email_success_error_page', $data);
	}

	/**
     * get advertising for specific pages.
     */
	public function get_advertize(Request $request) {
		$data = HomeContent::where(['is_active'=>1,'type'=>'Advertisement','page_name'=>$request->page_name])->first();
		$html = '<a target="_blank" rel="nofollow noreferrer noopener" href="'.$data->link.'"><img src="'. $data->image.'" alt="'.$data->header.'"  />
		</a>';
		return response()->json(['status' => true, 'msg' => trans('frontend_msg.contactus_succ'),'html'=>$html], 200);
	}

}