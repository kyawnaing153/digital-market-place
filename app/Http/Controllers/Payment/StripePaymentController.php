<?php

namespace App\Http\Controllers\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Cart,Auth;
use App\Models\Frontend\Product;
class StripePaymentController extends Controller
{
   /**
    * stripe form page
   */
    public $stripe;
    public function __construct()
    {
        $this->stripe = new \Stripe\StripeClient(config('services.STRIPE_SECRET_KEY'));
    }
    public function stripe($request): View
    {
        $setting = getSetting();
        if (Cart::instance('default')->count() ==  0) {
            redirect()->route('frontend.cart.index',app()->getLocale());
        }
        if($setting->is_checked_stripe == 0){  //setting stripe is not checked
            redirect()->route('frontend.cart.index',app()->getLocale());
        }
        $data['stripe_public_key'] = $setting->stripe_public_key;
        $symbol = $setting->default_symbol ?? '$';
        $data['total_amount'] = @$symbol.$request['total_amount'];
        return view('frontend.gateways.stripe',$data);
    }
      
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
  
     public function handlePayment($request)
    {
        try {
                
                $user = Auth::user();
                $setting = getSetting();
                if($setting->is_checked_stripe == 1){
                 $contents = Cart::instance('default')->content()->map(function ($item) {
                    return $item->model->name . ', ' . $item->qty;
                })->values()->toJson();

                $subtotal = Cart::instance('default')->subtotal() ?? 0;
                $discount = session('coupon')['discount'] ?? 0;
                $newSubtotal = $subtotal - $discount > 0 ? $subtotal - $discount : 0;

                $stripeLineItems = [
                    'price_data' => [
                        'currency' => $setting->default_currency ?? 'USD',
                        'product_data' => [
                            'name' => $user->full_name ?? $request['full_name'],
                            'description' => "Order",
                        ],
                        'unit_amount' => $newSubtotal * 100,
                    ],
                    'quantity' => 1,
                ];

                $data = [
                    'payment_method_types' => ['card'],
                    'line_items' => [$stripeLineItems],
                    'locale' => 'auto',
                    'customer_email' => $user->email ?? $request['email'],
                    'metadata' => [
                        'transactionType' => 'Stripe',
                        'user_id' => $user->id,
                    ],                    
                    'mode' => 'payment',
                    'success_url' => route('frontend.success.payment',app()->getLocale()).'?session_id={CHECKOUT_SESSION_ID}',
                ];

               $session = $this->stripe->checkout->sessions->create($data);
               session()->put('stripe_session_id',$session->id);
               return redirect()->to($session->url);
             }
        }catch (\Exception $e) {
            return redirect()->to($request->checkout_url ?? '/')->withError('error ' . $e->getMessage());
        }
        return redirect()->to($request->checkout_url ?? '/')->with('error', trans('frontend_msg.something_went_wrong'));
    }

//success
    public function success(Request $request)
    {
        $stripe_session_id = session()->get('stripe_session_id');
        $data = $this->stripe->checkout->sessions->retrieve(
            $request->session_id
        );
        
        if(!empty($data) && isset($request->session_id) && $request->session_id == $stripe_session_id)
        {
            if($data->payment_status == 'paid'){
               
                $request->status = 'success';
                $request->subscription_id= $data->subscription;
                $request->stripe_session_id = $stripe_session_id;
                 return (new CheckoutController())->paymentSuccess($request); //redirect to payment success 
            }else {
                    return response()->route('frontend.cancel.payment');
                }
        }

    }
}