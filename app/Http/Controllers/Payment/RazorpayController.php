<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Razorpay\Api\Api;
use Cart;
use Illuminate\Support\Facades\Log;

class RazorpayController extends Controller
{

    public function razorpay($request){
   
        $user = auth()->user();
        $setting = getSetting();
        if (Cart::instance('default')->count() ==  0) {
            redirect()->route('frontend.cart.index',app()->getLocale());
        }
        if($setting->is_checked_razorpay == 0){  //setting razorpay is not checked
            redirect()->route('frontend.cart.index',app()->getLocale());
        }
        $data['razorpay_key'] = $setting->razorpay_key;
        $data['total_amount'] = $request['total_amount'] * 100;
        $data['total_amount_view'] = $request['total_amount'];
        $data['symbol'] = $setting->default_symbol ?? '₹';
        $data['email']  = $request['email'];
        $data['full_name']  = $request['full_name'];

        return view('frontend.gateways.razorpay',$data);
    }
    public function handlePayment(Request $request)
    {
        $setting = getSetting();
        $input = $request->all();
        $api = new Api($setting->razorpay_key, $setting->razorpay_secret_key);
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        if (count($input) && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture([
                    'amount' => $payment['amount']
                ]);

                $data = (object)[];
                $data->token = $response['id'];
                $data->payment_method = $response['method'];
                $data->email = $response['email'];
                $data->phone = $response['contact'];
                $data->json_response = $response;

                return (new CheckoutController())->paymentSuccess($data); //redirect to payment success 
    
            } catch (Exception $e) {
                Log::info($e->getMessage());
                return redirect()->route('frontend.cancel.payment',app()->getLocale())->withError('Error ' . $e->getMessage());
            }
        }
        return redirect()->route('frontend.cart.index',app()->getLocale());
    }
}
