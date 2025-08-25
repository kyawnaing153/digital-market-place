<?php

namespace App\Http\Controllers\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\{EmailProviders, EmailList, SubscriberEmail, Setting};
use App\EmailProviders\{ConstantContact,Mailchimp,Sendinblue,Freshmail};
use Validator, DB;
class EmailIntegrationsController extends Controller
{
   //Get email providers
    public function index()
    {
        $obj = new EmailProviders();
         //List for Email Provider
        $data["providers"] = $obj->where("is_connect", 0)->get();
        $data["connect_providers"] = $obj->where("is_connect", 1)->get();
        return view("admin.email_integration.index", $data);
    }
   //Common function for sending requests to autoresponder
    public function store(Request $request)
    {
        if (!empty($request->form)) {
            switch ($request->form) {
                case "constant_contact":
                    $data = $this->ConstantContact($request, "GET");
                    break;
                case "mailchimp":
                    $data = $this->Mailchimp($request, "GET");
                    break;
                case "get_response":
                    $data = $this->GetResponse($request, "GET");
                    break;
                case "sendinblue":
                    $data = $this->Sendinblue($request, "GET");
                    break;
                case "active_campaign":
                    $data = $this->ActiveCampaign($request, "GET");
                    break;
                case "sendiio":
                    $data = $this->Sendiio($request, "GET");
                    break;
            }
            if ($data["status"] == false) { 
                return response()->json(
                    ["status" => false, "msg" =>$data["error"]],
                    200
                );
            }

            if ($data["status"] == true) {
                $obj = EmailProviders::where([
                    "slug" => $request->form,
                ])->first();

                /* If you get contact list, update the status to is_connected  */
                $obj->update([
                    "credentials" => json_encode($request->all()),
                    "is_connect" => 1,
                ]);
                $obj->save();


                $finalArr = [];
                foreach ($data["list"] as $key => $value) {
                    $Arr["parent_id"] = $obj->id;
                    $Arr["unique_id"] = $key;
                    $Arr["list_name"] = $value;
                    $finalArr[] = $Arr;
                }
                /* issert the all lint into emaillist table */
                EmailList::insert($finalArr);
            }
            return response()->json(
                ["status" => true, "msg" => "Email connect successfully"],
                200
            );
        }
        return response()->json(
            ["status" => false, "msg" => "invalid form"],
            200
        );
       
    }

    //Save Email Provider list
    public function saveList(Request $request)
    {
        $rules['unique_id.*'] = 'required';
        $msg['unique_id.*'] = 'Please Select List.';
        $validator = Validator::make($request->all(), $rules,$msg);
        if ($validator->fails())
            return response()->json(['status' => false, 'msg' => $validator->messages()->first()], 400);

        EmailList::where(['is_checked'=>1])->update(["is_checked" => 0]);
        EmailList::whereIn("unique_id", $request->unique_id)->update([
            "is_checked" => 1,
        ]);
        return response()->json(
            ["status" => true, "msg" => "Updated successfully"],
            200
        );
    }
    // Create Subscriber User When the User submits Newsletter, Contact us and Register
    public function create_subscribe_user($request)
    {
        $EmailProvidersObj = new EmailProviders();
        $EmailProviders = $EmailProvidersObj->where("is_connect", 1)->get();
        $isExist = SubscriberEmail::where(['email'=>$request->email])->exists();
        if($isExist){
            return true;  //Email alredy exist
        }
        SubscriberEmail::create($request->all());


        if(!empty($EmailProviders) && count($EmailProviders) > 0)   //if admin set Eamil provider
        {
            foreach ($EmailProviders as $key => $val) {
                $request->credentials = json_decode($val->credentials);
                $request->list_id = EmailList::where(["parent_id" => $val->id,"is_checked" => 1])->pluck("unique_id")->first();
                
                if(!empty($request->list_id)){
                    switch ($val->slug) {
                        case "constant_contact":
                              $data = $this->ConstantContact($request, "subsCribe");
                              break;
                          case "mailchimp":
                              $data = $this->Mailchimp($request, "subsCribe");
                              break;
                          case "get_response":
                              $data = $this->GetResponse($request, "subsCribe");
                              break;
                          case "sendinblue":
                              $data = $this->Sendinblue($request, "subsCribe");
                              break;
                          case "active_campaign":
                              $data = $this->ActiveCampaign($request, "subsCribe");
                              break;
                          case "sendiio":
                              $data = $this->Sendiio($request, "subsCribe");
                              break;
                        }
                }
                else{
                    continue;
                }
                if ($data["status"] == false) {
                    continue;
                }

                sleep(1);
            }
            return true;
        }
        return false;  //other wise false

    }

     //update disconent email provider by provider id
    public function update(Request $request, string $id)
    {
        $obj = EmailProviders::find($id);
        $obj->is_connect = 0;
        $obj->credentials = NULL;
        $obj->save();
        EmailList::where('parent_id',$obj->id)->delete(); //Delete all list 
        return response()->json(
            ["status" => true, "msg" => trans("msg.disconnect_succ")],
            200
        );
    }

    //Subcribe email list
    public function SubscriberEmailList()
    {
        $data = SubscriberEmail::paginate(10);
        return view('admin.email_integration.email_list',compact('data'));
    }

    //For destory Subcriber Email
    public function destroy(string $id)
    {
        $data = SubscriberEmail::find($id);
        $data->delete();
        return response()->json(
            ["status" => true, "msg" => trans("msg.email_deleted")],
            200
        );
    }

    //Get list and create contact email form ConstantContact
    public function ConstantContact($request, $action)
    {
        // require_once "emailIntegration_resources/ConstantContact/class.cc.php";
        if ($action == "GET") { //get list 
            $cc = new ConstantContact($request->user_name, $request->password);
            $resultofcc = $cc->get_lists("lists");
            if ($resultofcc) {
                if (count($resultofcc) > 0) {
                    foreach ($resultofcc as $v) {
                        $list[$v["id"]] = $v["Name"];
                    }
                    $result["status"] = true;
                    $result["list"] = $list;
                } else {
                    $result["status"] = false;
                }
            } else {
                $result["status"] = false;
                $result["error"] = trans("msg.somethig_wrong");

            }
            return $result;
        }

        if ($action == "subsCribe") { //create contact
            $cc = new ConstantContact(
                $request->credentials->user_name,
                $request->credentials->password
            );

            $email = $request->email;
            $listID = $request->list_id;

            $extra_fields = [];
            if (!empty($request->name)) {
                $extra_fields["FirstName"] = $request->name;
            }

            $contact = $cc->query_contacts($email);

            if (!$contact) {
                $new_id = $cc->create_contact($email, $listID, $extra_fields);
                if ($new_id) {
                    $result["status"] = true;
                } else {
                    $result["status"] = false;
                }
            } else {
                $result["status"] = false;
            }

            return $result;
        }
    }

     //Get list and create contact email form Sendinblue
    public function Sendinblue($request, $action)
    {
        if ($action == "GET") {
            $key = $request["api_key"];
            $mailin = new Sendinblue("https://api.brevo.com/v3/contacts/lists?limit=10&offset=0&sort=desc", $key);
        
            $data = [
                "page" => 1,
                "page_limit" => 50,
            ];
            $retvals = $mailin->get_lists($data);
            sleep(2);

            if (isset($retvals["lists"])) {
                if (count($retvals["lists"]) > 0) {
                    $list = [];
                    foreach ($retvals["lists"] as $retval) {
                        $list[$retval["id"]] = $retval["name"];
                        
                    }
                    $result["status"] = true;
                    $result["list"] = $list;
                    
                } else {
                    $result = ["status"=>false, "error" => trans("msg.no_list_found")];
                }
            } else {
                $result = ["status"=>false, "error" => trans("msg.somethig_wrong")];
            }
            return $result;
        }

        if ($action == "subsCribe") { //create contact

            $key = $request->credentials->api_key;
            $listID = $request->list_id;
            $email = $request["email"];
            if (!empty($request["name"])) {
                $fname = $request["name"];
            } else {
                $fname = "";
            }

            try {
                $mailin = new Sendinblue("https://api.brevo.com/v3/contacts", $key);

                try {
                    $data = [
                        "email" => $email,
                        "attributes" => ["NAME" => $fname, "SURNAME" => ""],
                        "listid" => [$listID],
                    ];

    
                    $res = $mailin->create_update_user($data);

                    $result = ["status"=>true];

                } catch (Email_Invalid_Response_Exception $e) {
                  $result = ["status"=>false, "error" => trans("msg.unsubscribe_succ")];
                }
            } catch (Exception $e) {
                $result = ["status"=>false,"error" => trans("msg.unsubscribe_succ")];
            }
        }

        return $result;
    }

     //Get list and create contact email form GetResponse
    public function GetResponse($request, $action)
    {
        if ($action === "GET") {
            $list = [];
            $cURLConnection = curl_init();
            
            try {
                curl_setopt(
                    $cURLConnection,
                    CURLOPT_URL,
                    "https://api.getresponse.com/v3/campaigns"
                );
                curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, [
                    "X-Auth-Token:api-key " . $request["api_key"],
                ]);
                $alllists = curl_exec($cURLConnection);
                $list = json_decode($alllists, true);

                if (isset($list["code"]) && $list["code"] == "1014") {
                    $result = ["status"=> false,"error" => $list["message"]];
                }
                else {
                    if (count($list) > 0) {
                        if (isset($list["message"])) {
                            $result = ["status"=> false, "error" => $list["message"]]; // When no list found
                        } else {
                            foreach ($list as $v) {
                                $listData[$v["campaignId"]] = $v["name"];
                            }
                            $result['status'] = true;
                            $result["list"] = $listData;
                        }
                    } else {
                      $result = ['status'=>false, "error" => trans("msg.error_account")]; // When no list found
                    }
                    return $result;
                }
                return ['status'=>false, "error" => trans("msg.error_account")];

            } catch (Exception $e) {
                return ['status'=>false, "error" => $e->getMessage()];
            }
            curl_close($cURLConnection);
        }

        if ($action == "subsCribe") { //create contact
            try {
                $listID = $request->list_id;
                if (!empty($listID)) {
                    $args = [
                        "campaign" => ["campaignId" => $listID],
                        "email" => $request["email"],
                        "dayOfCycle" => 0,
                    ];
                }
                if (!empty($request["name"])) {
                    $args["name"] = $request["name"];
                }
                $data_string = json_encode($args);
                $ch = curl_init("https://api.getresponse.com/v3/contacts");
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    "X-Auth-Token:api-key " . $request->credentials->api_key,
                    "Content-Type: application/json",
                    "Content-Length: " . strlen($data_string),
                ]);
                $res = curl_exec($ch);
                $result = ["status" => true];
            } catch (Exception $e) {
                $result = ["status" => false];
            }
        }
        return $result;
    }

     //Get list and create contact email form Mailchimp
    public function Mailchimp($request, $action)
    {
        if ($action == "GET") {
            $key = $request["api_key"];
           
           	$MailChimp = new Mailchimp($request->api_key);
            $retval = $MailChimp->get("lists", ["count" => 100]); 
            
            if (isset($retval["lists"])) {
                if (!empty($retval["lists"])) {
                    for ($i = count($retval["lists"]) - 1; $i >= 0; $i--) {
                        $result["id"] = $retval["lists"][$i]["id"];
                       	$list[$retval['lists'][$i]['id']] = $retval['lists'][$i]['name'];
                    }
                    $result["list"] = $list;
                    $result["status"] = true;
                   
                } else {
                    $result = ['status'=>false,"error" => trans("msg.error_account")];
                }
            } else {
                $result = ['status'=>false,"error" => trans("msg.somethig_wrong")];
            }

            return $result;
        }
        if($action == 'subsCribe'){ //create contact
          $key = $request->credentials->api_key;
          try{
              $MailChimp = new Mailchimp($key);
              $listID = $request->list_id;
              
              if($request['name'] != '' && $request['phone'] != ''){
                  $args = array('FNAME' => $request['name'], 'PHONE' => $request['phone']);
              }else if($request['name']){
                $args = array('FNAME' => $request['name']);
              }else{
                $args = array();
              }
              
              if(!empty($listID)){
                $mdata = $MailChimp->post("lists/$listID/members", [
                  'email_address' => $request['email'],
                  'status'        => 'subscribed',
                ]);
              }
          
              if ($MailChimp->success()) {
                if(!empty($args)){
                  $subscriber_hash = $MailChimp->subscriberHash( $request['email'] );
                  $mdata = $MailChimp->patch("lists/$listID/members/$subscriber_hash", [
                    'merge_fields' => $args
                  ]);
                }
                $result = array('status'=>true,'error'=>$MailChimp->getLastError());
              }
              else{
                $result = array('status'=>false,'error'=>$MailChimp->getLastError());
              }
            }catch(Exception $e){
              $result = array('status'=>false,'error'=>$e->getMessage());
          }
                
          return $result;
          
        }
    }

    //Get list and create contact email form Active Campaign
    public function ActiveCampaign($request , $action)
    {
        if($action === 'GET'){
            $url = $request->api_url;
            $api_key = $request->api_key;
            $params = array(
                'api_key'      => $api_key,
				'api_action'   => 'list_paginator',
				'api_output'   => 'json',
				'somethingthatwillneverbeused' => '',
				'sort' => '',
				'offset' => 0,
				'limit' => 20,
				'filter' => 0,
				'public' => 0,
            );
            $query = "";

            foreach($params as $key => $value)
            $query .= $key . '=' . urlencode($value) . '&';

            $query = rtrim($query, '& ');
            $url = rtrim($url, '/ ');
            if ( !function_exists('curl_init') ) { 
                $result = array('error'=>trans('msg.somethig_wrong')); 
            }
            if ( $params['api_output'] == 'json' && !function_exists('json_decode') ) {
                $result = array('error'=>trans('msg.somethig_wrong'));
            }
            $api = $url . '/admin/api.php?' . $query;
            $request = curl_init($api);
            curl_setopt($request, CURLOPT_HEADER, 0);
            curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
            $response = (string)curl_exec($request);
            curl_close($request);
            if ( !$response ) {
                $result = array('error'=>trans('msg.somethig_wrong'));
            }
            $results = json_decode($response);
            
            if( $results == null) {
            $result = array('status'=>false,'error'=>trans('msg.somethig_wrong'));
            
            }else {
            if ( $results->cnt == 0 ) {
            $result = array('status'=>false,'error'=>trans('msg.error_account'));
            }
            else {
            foreach ($results->rows as $solo_list){
                $list_key = $solo_list->id;
                $list_name = $solo_list->name;
                $list[$list_key] = $list_name;
                }
                $result['list'] = $list;
                $result["status"] = true;
            }
        }
            
        }
        if($action === 'subsCribe'){

			$url = $request->credentials->api_url;
			$api_key = $request->credentials->api_key;
			$listID = $request->list_id;

			$params = array(
				'api_key'      => $api_key,
				'api_action'   => 'contact_add',
				'api_output'   => 'json'
			);

			if (!empty($request['name'])){
				$fname = $request['name'];
			}
			else {
				$fname = '';
			}

			$post = array(
				'email'                    => $request['email'],
				'first_name'               => $fname,
				'tags'                     => 'api',
				'p[1]'                   => $listID,
				'status[1]'              => 1,
				'instantresponders[123]' => 1
			);

			$query = "";
			foreach( $params as $key => $value ) $query .= $key . '=' . urlencode($value) . '&';
			$query = rtrim($query, '& ');

			$data = "";
			foreach( $post as $key => $value ) $data .= $key . '=' . urlencode($value) . '&';
			$data = rtrim($data, '& ');

			$url = rtrim($url, '/ ');

			$api = $url . '/admin/api.php?' . $query;

			$curl = curl_init($api);
			curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			$response = (string)curl_exec($curl);
			curl_close($curl);
			if ( $response ) {
				$results = json_decode($response);
				if( $results->result_code != 0) {
					return $result = array('status'=>true);
				}
			}
		}
        return array('status'=>false,'error'=>trans('msg.unsubscribe_succ'));
       
    }

    //Get list and create contact email form Sendiio
    public function Sendiio($request,$action)
    {
      if($action == "GET"){
        $url = 'https://sendiio.com/api/v1/lists/email';
        $headers = array('Content-Type: text/html','token:'.$request['api_token'],'secret:'.$request['api_secret']);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $server_output = curl_exec($ch);
        curl_close ($ch);
        $data = json_decode($server_output,true);

		if($data['error'] == 0){
                $list = array();
                foreach($data['data']['lists'] as $group){
                    $list[$group['encrypted_id']] = $group['name'];
                }
                $result['list'] = $list;
                $result['status'] = true;
			}
            else{
                $result = array('status'=>false,'error'=>trans('msg.somethig_wrong'));
				$result['list'] = "";
			}
      }
      if($action == 'subsCribe'){	
        $listID = $request->list_id;
        $url = 'https://sendiio.com/api/v1/lists/subscribe/json';
        $headers = array('Content-Type: text/html');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "email_list_id=".$listID."&email=".$request['email']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $server_output = curl_exec($ch);
        curl_close ($ch);
        $result=json_decode($server_output,true);

        if(isset($result['error']) && $result['error']==0){
            $result = array('status'=>false,'success'=>'We\'ve received your message! We\'ll get back to you soon.');
        }else{
            $result = array('status'=>true,'error'=>trans('msg.unsubscribe_succ'));
        }
		}
        return $result;
  
    }
}