<?php
namespace App\Http\Controllers\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
class PayPalPaymentController extends Controller
{

   /**
    * paypal payment handler
   */
    public function handlePayment($request)
    {
        $provider = new PayPalClient($this->paypal_config());
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.success.payment',app()->getLocale()),
                "cancel_url" => route('paypal.cancel.payment',app()->getLocale()),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $request['total_amount'],
                    ]
                ]
            ]
        ]);
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {  
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()->route('frontend.cancel.payment',app()->getLocale())->with('error', trans('frontend_msg.something_went_wrong'));
        } else {
            return redirect()->route('frontend.checkout',app()->getLocale())->with('error', $response['message'] ?? trans('frontend_msg.something_went_wrong'));
        }
    }

   /**
    *  payment error
   */
    public function paymentCancel(){
        return redirect()->route('frontend.cancel.payment',app()->getLocale())->with('error', $response['message'] ?? trans('frontend_msg.you_have_canceled_payment'));
    }

  /**
    *  payment Success
   */
    public function paymentSuccess(Request $request)
    {
        $provider = new PayPalClient($this->paypal_config());
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
      
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $data = (object)[]; 
            $data->token = $request->token;
            $data->PayerID = $request->PayerID;
            $data->json_response = $response;
            return (new CheckoutController())->paymentSuccess($data);
        } else {
            return redirect()->route('frontend.checkout',app()->getLocale())->with('error', $response['message'] ?? trans('frontend_msg.something_went_wrong'));
        }
    }


    public function paypal_config()
    {
        $setting = getSetting();
        return [
            'mode'    => ($setting->is_live_paypal == 1) ? 'live' : 'sandbox', // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
            'sandbox' => [
                'client_id'         => $setting->paypal_client_id,
                'client_secret'     => $setting->paypal_client_secret,
                'app_id'            => $setting->paypal_app_id,
            ],
            'live' => [
                'client_id'         => $setting->paypal_client_id,
                'client_secret'     => $setting->paypal_client_secret,
                'app_id'            => $setting->paypal_app_id,
            ],
        
            'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'), // Can only be 'Sale', 'Authorization' or 'Order'
            'currency'       => env('PAYPAL_CURRENCY', @$setting->default_currency ?? 'USD'),
            'notify_url'     => env('PAYPAL_NOTIFY_URL', ''), // Change this accordingly for your application.
            'locale'         => env('PAYPAL_LOCALE', 'en_US'), // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
            'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', true), // Validate SSL when creating api client.
        ];
        
    }

}