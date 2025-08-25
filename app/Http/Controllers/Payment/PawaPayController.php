<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PawaPayController extends Controller
{
    public $base_url;
    public function __construct(Type $var = null) {
        $this->base_url  = "https://api.sandbox.pawapay.cloud/";
    }
     
    public function handlePayment($request){

       $setting = getSetting();
       $body = [
           "depositId"=>$request['depositId'],
           "returnUrl"=>route('frontend.pawapay.success',app()->getLocale()),
           //"returnUrl"=> "https://merchant.com/paymentProcessed",
           "amount"=> (string) $request["total_amount"],
           "country" => 'ZMB',
        ];
        $endpoint  = 'v1/widget/sessions';
       
		$_URL = $this->base_url . $endpoint;
		$response = $this->CURL('POST',$_URL,$body);
        
        if($response['status'] == true){
            return redirect()->to($response['data']->redirectUrl);
        }
        else{
            session()->flash("error", $response['data']?->errorMessage);
            return redirect()->to($request->checkout_url);
        }
    }

    public function curl($method,$url,$body){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_POSTFIELDS =>json_encode($body),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.config('services.PAWAPAY_TOKEN'),
        ),
        ));

        $response = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curl_errno = curl_errno($curl);
        curl_close($curl);
        $data = json_decode($response);

        if (($http_status != 201 && $http_status != 200)  || empty($data)) {
            return ['status' => false, 'data' => $data ];
        }
        return ['status' => true, 'data' => $data];

    }

    public function success(Request $request){
     
        $cart = session()->get('cart');
        $tnx_id = session()->get('tnx_id');
        if (isset($request->depositId)  && $tnx_id == $request->depositId &&  !isset($request->cancel)) {

            $endpoint  = 'deposits/'. $request->depositId;
            $_URL = $this->base_url . $endpoint;
            $response = $this->CURL('GET',$_URL,[]);

            $res = @$response['data'][0];
            $data = (object)[];
            $data->json_response = $res;
            $data->id = $res->depositId;
            $data->status = config('constants.STATUS_SUCCESS');
            return (new CheckoutController())->paymentSuccess($data);
            
        } else {
            return redirect()->to($cart->return_url ?? '/')->with('error', $response['message'] ?? trans('frontend_msg.something_went_wrong'));
        }
    }

}


