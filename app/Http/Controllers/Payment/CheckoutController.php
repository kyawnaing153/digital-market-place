<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Frontend\{Product, ProductMeta};
use App\Models\{Order, OrderProduct, Wallet, User};
use Cart, Redirect, Session, Str, Storage, Auth, Hash;
use LaravelDaily\Invoices\Invoice;
use Validator;
use LaravelDaily\Invoices\Classes\{Buyer, InvoiceItem};
use App\Http\Controllers\ADMIN\MailController;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    /**
     * Checkout index page
     */
    public function index()
    {

        if (Cart::instance('default')->count() > 0) {  //if the cart has items
            $subtotal = Cart::instance('default')->subtotal() ?? 0;
            $total = Cart::instance('default')->total() ?? 0;
            $discount = session('coupon')['discount'] ?? 0;
            $newtotal = $total - $discount > 0 ? $total - $discount : 0;

            return view('frontend.checkout.index')->with([
                'total_product' => Cart::instance('default')->count(),
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total_value' => $newtotal,
                'tax' => Cart::instance('default')->tax(),
                'discount_code' => session('coupon')['code'] ?? "",
            ]);
        }
        return redirect()->route('frontend.cart.index', app()->getLocale())->withError('You have nothing in your cart , please add some products first');
    }

    /**
     * common function for managing payment 
     */
    public function store(Request $request)
    {
        #dd('test');
        if (!empty($request->billing_name)) {
            $rules = [
                'billing_email' => 'required|email',
            ];
            $msg['billing_email.required'] = trans('frontend_msg.req_email');
            $msg['billing_email.email'] = trans('frontend_msg.wrong_email_format');
            $validator = Validator::make($request->all(), $rules, $msg);
            if ($validator->fails()) {
                session()->flash("error", $validator->messages()->first());
                return Redirect::back();
            }
        }
        $contents = Cart::instance('default')->content()->map(function ($item) {
            return $item->model->slug . ', ' . $item->qty . ',' . $item->rowId;
        })->values()->toJson();

        try {

            $subtotal = Cart::instance('default')->total() ?? 0;
            $discount = session('coupon')['discount'] ?? 0;
            $newSubtotal = $subtotal - $discount > 0 ? $subtotal - $discount : 0;
            $user = auth()->user() ?? User::where('email', $request->billing_email)->first();
            #dd($user);
            $data['total_amount'] = $newSubtotal;
            $data['contents'] = $contents;
            $data['email'] = $request->billing_email ?? $user->email;
            $data['full_name'] = $request->billing_name ?? $user->full_name;
            $data['reference_number'] = $request->reference_number;
            $data['payment_method'] = $request->gateway;
            $data['phone'] = $user->mobile;

            $data['tnx_id'] = 'TNX' . strtoupper(Str::uuid());
            $data['depositId'] =  substr($data['tnx_id'], 3);
            session()->put('full_name', $request->full_name);

            if (!empty($request->billing_name)) {
                session()->put('billing_name', $request->billing_name);
            }
            if (!empty($request->billing_email)) {
                session()->put('billing_email', $request->billing_email);
            }
            if ($request->gateway != "free") {
                session()->put('gateway', $request->gateway);  //stored payment gateway into session
            }
            #dd($request, $data);
            switch ($request->gateway) {
                case "paypal":
                    return (new PayPalPaymentController())->handlePayment($data);
                    break;
                case "stripe":
                    return (new StripePaymentController())->handlePayment($data);
                    break;
                case "razorpay":
                    return (new RazorpayController())->razorpay($data);
                    break;
                case "pawapay":
                    return (new PawaPayController())->handlePayment($data);
                    break;
                case "flutterWave":
                    return (new FlutterwaveController())->handlePayment($data);
                    break;

                case "free":
                    if ($subtotal > 0) {
                        session()->flash("error", trans('frontend_msg.something_went_wrong'));
                        return Redirect::back();
                    }
                    return $this->paymentSuccess($data);
                    break;
                case "manual":
                    return $this->manualPaymentProcess($data);
                    break;
                default:
                    session()->flash("error", trans('frontend_msg.payment_type_not_found'));
                    return Redirect::back();
            }
            return Redirect::back();
        } catch (Exception $e) {
            return back()->withError('Error ' . $e->getMessage());
        }
    }
    // getting cart contents
    private function getNumbers()
    {
        $discount = session()->get('coupon')['discount'] ?? 0;
        $code = session()->get('coupon')['code'] ?? null;

        $subtotal = Cart::instance('default')->subtotal() ?? 0;
        $total = Cart::instance('default')->total() ?? 0;

        $newTotal = $total - $discount > 0 ? $total - $discount : 0;

        return collect([
            'tax' => Cart::instance('default')->tax(),
            'discount' => $discount,
            'code' => $code,
            'subtotal' => $subtotal,
            'total' => $newTotal
        ]);
    }

    //store record into order table
    private function insertIntoOrdersTable($request, $error)
    {
        #dd(serialize($request['json_response']));
        $order = Order::create([
            'user_id' => auth()->user() ? auth()->user()->id : NULL,
            'tnx_id' => 'TNX' . strtoupper(Str::uuid()),
            'payment_id' => @$request['payment_id'],
            'payer_id' => @$request['payer_id'],
            'status' => @$request['status'] ?? 1,
            'billing_email' => @$request['email'],
            'billing_phone' => @$request['phone'],
            'payment_method' => @$request['payment_method'],
            'payment_gateway' => session()->get('gateway') ?? NULL,
            'billing_discount' => $this->getNumbers()->get('discount'),
            'billing_discount_code' => $this->getNumbers()->get('code'),
            'billing_subtotal' => $this->getNumbers()->get('subtotal'),
            'billing_tax' => $this->getNumbers()->get('tax'),
            'billing_total' => $this->getNumbers()->get('total'),
            'json_response' => !empty($request['json_response']) ? serialize($request['json_response']) : NULL,
            'error' => $error,
        ]);
        #dd(Cart::instance('default')->content());
        /**
         * storing order product on behalf of order ID 
         */

        $setting = getSetting();
        #dd($setting->commission_type);
        $OrderProductArr = $WalletArr = [];

        foreach (Cart::instance('default')->content() as $item) {

            $admin_commission = 0;
            if ($setting->commission_type == 1) { //fixed
                $admin_commission = $item->price - $setting->commission;
            } else if ($setting->commission_type == 0) { //'percent'
                $admin_commission = $item->price * ($setting->commission / 100);
            }
            $vendor_amount = ($item->price - $admin_commission);
            #dd(@$item->options->variants[0]);
            $OrderProductArr[] = [
                'product_id' => $item->model->id,
                'price' => $item->price,
                'order_id' => $order->id,
                'quantity' => $item->qty,
                'variants' => (is_array($item->options->variants) && @$item->options->variants[0]) ? serialize(@$item->options->variants) : Null,
                'vendor_id' => $item->model->user_id,
                'admin_commission' => $admin_commission,
                'vendor_amount' => $vendor_amount,
                'tax_rate' => $setting->tax,
                'commission_rate' => $setting->commission,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            #dd($OrderProductArr);
            if (@$request['status'] == 1) {
                Wallet::create([
                    'user_id' => $item->model->user_id,
                    'type' => "SALE",
                    'credit' => $vendor_amount,
                ]);
            }
        }

        OrderProduct::insert($OrderProductArr);
        return $order;
    }

    //Increse Product sale count
    private function increaseDownloadCounts()
    {
        foreach (Cart::instance('default')->content() as $item) {
            $product = Product::find($item->model->id);
            $product->update(['sale_count' => $product->sale_count + 1]);
        }
    }

    /**
     * after payment success cart items are stored in the database
     */
    public function paymentSuccess($request)
    {
        $data['payment_id'] = $request->token ?? '';
        $data['payer_id'] = $request->PayerID ?? '';
        $data['payment_method'] = @$request->payment_method ?? '';
        $data['email'] = @$request->email ?? '';
        $data['phone'] =  @$request->phone ?? '';
        $data['status'] = 1;
        $data['json_response'] = @$request->json_response;
        $email  = Session::get('billing_email') ?? Auth::user()->email;

        $checkUser = User::where('email', @$email)->first();

        if ($checkUser) {
            $user = $checkUser;
            $isNewUser = false;
        } else {
            $isNewUser = true;
            $password = Str::random(12);
            $user = User::Create([
                'full_name' => session()->get('billing_name'),
                'email' => session()->get('billing_email'),
                'password' => Hash::make($password),
                'is_email_verified' => 1,
                'email_verified_at' => now(),
                'role'  => 1,
                'role_type'  => "USER"
            ]);
        }
        #dd($isNewUser);
        Auth::login($user);
        $order = $this->insertIntoOrdersTable($data, null);
        $this->increaseDownloadCounts();
        Cart::instance('default')->destroy();
        session()->forget('coupon');
        session()->forget('gateway');

        if ($isNewUser) {
            $Maildata =  (object)[
                'type' => "new_user_temp",
                'email' => $user->email,
                'password' => $user->password,
            ];
            (new MailController())->send_mail($Maildata);
        }
        // 🆕 Purchase details mail
        $items = [];
        foreach ($order->getOrderProduct as $op) {
            foreach ($op->getProduct as $p) {
                $items[] = $p->name . " - " . ($p->offer_price ?: $p->price);
            }
        }

        $Maildata = (object)[
            'type'     => "purchase_details",
            'email'    => $user->email,
            'full_name' => $user->full_name,
            'tnx_id'   => $order->tnx_id,
            'total'    => $order->billing_total,
            'items'    => implode(", ", $items),
        ];
        (new MailController())->send_mail($Maildata);
        #dd(new MailController())->send_mail($Maildata);
        $tnxId = @$order->tnx_id ?? '';
        return redirect()->route('frontend.success.transaction', [app()->getLocale(), 'tnxId' => $tnxId]);
    }


    /**
     * after payment success cart items are stored in the database
     */
    public function manualPaymentProcess($request)
    {
        #dd(@$request);
        $data['payment_id'] = '';
        $data['payer_id'] = $request['reference_number'];
        $data['payment_method'] = @$request['payment_method'];
        $data['email'] = @$request['email'];
        $data['phone'] =  @$request['phone'] ?? '';
        $data['status'] = 1;
        #dd($data);
        $order = $this->insertIntoOrdersTable($data, null);
        $this->increaseDownloadCounts();
        Cart::instance('default')->destroy();
        session()->forget('coupon');
        session()->forget('gateway');
        $tnxId = @$order->tnx_id ?? '';
        $this->send_email_invoice($tnxId);
        return redirect()->route('frontend.success.transaction', [app()->getLocale(), 'tnxId' => $tnxId]);
    }

    /**
     * after stored in the database redirect to the transaction success page with the download file
     */
    public function transactionSuccess(Request $request)
    {
        $Order = Order::where(['user_id' => auth()->id(), 'tnx_id' => $request->tnxId])->firstOrFail();
        $newFileArr = [];
        if ($Order->status == 1) //transaction Success
        {
            $OrderProduct = OrderProduct::where('order_id', $Order->id)->get();

            foreach ($OrderProduct as $key => $v1) {
                $ProductMeta = (object) ProductMeta::where('product_id', $v1->product_id)->pluck('value', 'key')->toArray();

                $fileArr = unserialize(@$ProductMeta->multi_file);
                if (!empty($v1->variants)) {
                    $variants = unserialize($v1->variants);
                    foreach ($variants as $key => $v2) {
                        foreach ($fileArr as $key => $v3) {

                            if ($v3['file_price'] == $v2['price_id']  || $v3['file_price'] == "ALL") {
                                $v3['product_id'] = base64url_encode($v1->product_id);
                                #unset($v3['file_external_url']);
                                unset($v3['file_url']);
                                $newFileArr[] = $v3;
                            }
                        }
                    }
                } else {
                    foreach ($fileArr as $key => $v3) {
                        $v3['product_id'] = base64url_encode($v1->product_id);
                        #unset($v3['file_external_url']);
                        unset($v3['file_url']);
                        $newFileArr[] = $v3;
                    }
                }
            }
        }
        $data['tnxId'] = $request->tnxId;
        $data['fileArr'] = $newFileArr;
        $data['order'] = $Order;

        return view('frontend.checkout.payment-success', $data);
    }

    //Download product 
    public function downlaodfile(request $request)
    {

        $Order = Order::where(['user_id' => auth()->id(), 'tnx_id' => $request->tnx_id])->firstOrFail();
        $ProductMeta = (object) ProductMeta::where('product_id', base64_decode($request->pid))->pluck('value', 'key')->toArray();
        $fileArr = unserialize(@$ProductMeta->multi_file);
        foreach ($fileArr as $key => $file) {

            if ($file['file_id'] == $request->file_id) {
                $newfilename = (!empty($file['file_name']) ? $file['file_name'] : '') . '.' . substr($file['file_url'], strrpos($file['file_url'], '.') + 1);

                if (isset($file['file_url']) && !empty($file['file_url'])) {
                    if (Storage::exists($file['file_url'])) {
                        return Storage::download($file['file_url'], $newfilename);
                    }
                    return;
                }
                if (isset($file['file_external_url']) && !empty($file['file_external_url'])) {
                    return Redirect::to($file['file_external_url']);
                }
            }
        }

        return back();
    }

    //if payment has an error redirect to a transaction error page 
    public function transactionError(Request $request)
    {
        return view('frontend.checkout.payment-error');
    }

    //Download invoice 
    public function downlaod_invoice(request $request)
    {
        $order = Order::where(['user_id' => auth()->id(), 'tnx_id' => $request->tnx_id])->firstOrFail();
        $setting = getSetting();

        $user = Auth::user();
        $client = new Buyer([
            'name'          => $setting->site_name,
        ]);
        $customer = new Buyer([
            'name'          => $user->full_name,
            'custom_fields' => [
                'email' => $user->email,
            ],
        ]);

        $item = [];

        foreach ($order->getOrderProduct as $key2 => $items2) {
            foreach ($items2->getProduct as $key3 => $items) {
                dd($items);
                if (!empty($items2->variants)) {
                    $variants = unserialize($items2->variants);
                    foreach ($variants as $v => $v_itmes) {
                        $title = $items->name . ' ' . $v_itmes['option_name'];
                        $item[] =  (new InvoiceItem())->title($title)->pricePerUnit($v_itmes['price'])->taxByPercent($setting->tax);
                    }
                } else {
                    if ($items->is_free == '1') {
                        $pricePerUnit = 0;
                    } else {
                        if (@$items->is_offer != '0') {
                            $pricePerUnit  = $items->offer_price;
                        } else {
                            $pricePerUnit = $items->price;
                        }
                    }

                    $item[] =  (new InvoiceItem())->title($items->name)->pricePerUnit($pricePerUnit)->taxByPercent($setting->tax);
                }
            }
        }

        $logo = Storage::url($setting->my_logo);
        $invoice = Invoice::make();
        $invoice->seller($client);
        if (!empty($order->billing_discount))
            $invoice->totalDiscount($order->billing_discount);
        $invoice->buyer($customer)
            ->date($order->created_at)
            ->dateFormat('d M Y')
            ->currencySymbol($setting->default_symbol)
            ->currencyCode($setting->default_currency)
            ->addItems($item)
            ->totalAmount($order->billing_total + @$order->billing_discount ?? 0);

        return $invoice->download();
    }

    //Download invoice 
    public function view_invoice(request $request)
    {
        $order = Order::where(['user_id' => auth()->id(), 'tnx_id' => $request->tnx_id])->firstOrFail();
        $setting = getSetting();
        #dd('test');

        $user = Auth::user();
        $client = new Buyer([
            'name'          => $setting->site_name,
        ]);
        $customer = new Buyer([
            'name'          => $user->full_name,
            'custom_fields' => [
                'email' => $user->email,
            ],
        ]);

        $item = [];

        foreach ($order->getOrderProduct as $key2 => $items2) {
            foreach ($items2->getProduct as $key3 => $items) {

                if (!empty($items2->variants)) {
                    $variants = unserialize($items2->variants);
                    foreach ($variants as $v => $v_itmes) {
                        $title = $items->name . ' ' . $v_itmes['option_name'];
                        $item[] =  (new InvoiceItem())->title($title)->pricePerUnit($v_itmes['price'])->taxByPercent($setting->tax);
                    }
                } else {
                    if ($items->is_free == '1') {
                        $pricePerUnit = 0;
                    } else {
                        if (@$items->is_offer != '0') {
                            $pricePerUnit  = $items->offer_price;
                        } else {
                            $pricePerUnit = $items->price;
                        }
                    }

                    $item[] =  (new InvoiceItem())->title($items->name)->pricePerUnit($pricePerUnit)->taxByPercent($setting->tax);
                }
            }
        }

        $logo = Storage::url($setting->my_logo);
        $invoice = Invoice::make();
        $invoice->seller($client);
        if (!empty($order->billing_discount))
            $invoice->totalDiscount($order->billing_discount);
        $invoice->buyer($customer)
            ->date($order->created_at)
            ->dateFormat('d M Y')
            ->currencySymbol($setting->default_symbol)
            ->currencyCode($setting->default_currency)
            ->addItems($item)
            ->totalAmount($order->billing_total + @$order->billing_discount ?? 0);
        #dd($invoice->stream());
        return $invoice->stream();
        #return $invoice->download();
    }

    //send invoice as eamil
    public function send_email_invoice(string $tnxId)
    {
        $order = Order::with('getOrderProduct.getProduct')
            ->where(['user_id' => auth()->id(), 'tnx_id' => $tnxId])
            ->firstOrFail();

        $setting = getSetting();
        $user = Auth::user();

        // Send email without attachment, just passing order + user
        Mail::to($user->email)->send(new InvoiceMail($user, $order));

        return back()->with('success', 'Invoice sent to your email.');
    }

    // public function send_email_invoice(string $tnxId)
    // {
    //     $order = Order::where(['user_id' => auth()->id(), 'tnx_id' => $tnxId])->firstOrFail();
    //     $setting = getSetting();
    //     $user = Auth::user();

    //     $client = new Buyer([
    //         'name' => $setting->site_name,
    //     ]);

    //     $customer = new Buyer([
    //         'name'          => $user->full_name,
    //         'custom_fields' => [
    //             'email' => $user->email,
    //         ],
    //     ]);

    //     $item = [];

    //     foreach ($order->getOrderProduct as $items2) {

    //         foreach ($items2->getProduct as $items) {
    //             
    //             if (!empty($items2->variants)) {
    //                 $variants = unserialize($items2->variants);
    //                 foreach ($variants as $v_itmes) {
    //                     $title = $items->name . ' ' . $v_itmes['option_name'];
    //                     $item[] = (new InvoiceItem())
    //                         ->title($title)
    //                         ->pricePerUnit($v_itmes['price'])
    //                         ->taxByPercent($setting->tax);
    //                 }
    //             } else {
    //                 $pricePerUnit = 0;
    //                 if ($items->is_free != '1') {
    //                     $pricePerUnit = @$items->is_offer != '0'
    //                         ? $items->offer_price
    //                         : $items->price;
    //                 }
    //                 $item[] = (new InvoiceItem())
    //                     ->title($items->name)
    //                     ->pricePerUnit($pricePerUnit)
    //                     ->taxByPercent($setting->tax);
    //             }
    //         }
    //     }

    //     $invoice = Invoice::make()
    //         ->seller($client)
    //         ->buyer($customer)
    //         ->date($order->created_at)
    //         ->dateFormat('d M Y')
    //         ->currencySymbol($setting->default_symbol)
    //         ->currencyCode($setting->default_currency)
    //         ->addItems($item);

    //     if (!empty($order->billing_discount)) {
    //         $invoice->totalDiscount($order->billing_discount);
    //     }

    //     $invoice->totalAmount($order->billing_total + ($order->billing_discount ?? 0));

    //     // Save invoice PDF in storage
    //     $pdfPath = 'invoices/invoice_' . $order->tnx_id . '.pdf';
    //     Storage::put($pdfPath, $invoice->stream()->getContent());

    //     if (!Storage::exists($pdfPath)) {
    //         throw new \Exception("Invoice PDF not found at " . $pdfPath);
    //     }
    //     // Send email with invoice attached
    //     Mail::to($user->email)->send(new InvoiceMail($user, $order, $pdfPath));

    //     return back()->with('success', 'Invoice sent to your email.');
    // }
}
