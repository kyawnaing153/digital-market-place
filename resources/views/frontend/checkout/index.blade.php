@php
    $ASSET_URL = asset('user-theme') . '/';
    $setting = getsetting();
    $price_symbol = $setting->default_symbol ?? '$'; //default price symbol
@endphp
@extends('frontend.layout.master')
@section('head_scripts')
    <title>@lang('page_title.Frontend.checkout_page_title')</title>
@endsection
@section('content')
    <!--===checkout Section Start===-->
    <div class="tp_singlepage_section tp_secure_checkout_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp_view_box">
                        <div class="tp_view_text">
                            <h2>@lang('master.checkout.secure_checkout')</h2>
                        </div>
                        <div class="tp_cart_step">
                            <div class="tp_step_box">
                                <a href="{{ route('frontend.cart.index', app()->getLocale()) }}"><svg
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        preserveAspectRatio="xMidYMid" width="69" height="47" viewBox="0 0 69 47">
                                        <g>
                                            <circle cx="34.5" cy="12.5" r="12.5" class="cls-1" />
                                            <path
                                                d="M38.659,8.113 L32.260,13.934 L29.554,11.102 L27.764,12.747 L32.136,17.322 L40.322,9.881 L38.659,8.113 Z"
                                                class="cls-1" />
                                        </g>
                                    </svg>

                                    <span>@lang('master.checkout.add_to_cart')</span></a>
                            </div>
                            <div class="tp_step_box">
                                <a type="button" class="anchor-button"><svg xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid"
                                        width="69" height="47" viewBox="0 0 69 47">
                                        <g>
                                            <circle cx="34.5" cy="12.5" r="12.5" class="cls-1" />
                                            <path
                                                d="M38.659,8.113 L32.260,13.934 L29.554,11.102 L27.764,12.747 L32.136,17.322 L40.322,9.881 L38.659,8.113 Z"
                                                class="cls-2" />
                                        </g>
                                    </svg>
                                    <span>@lang('master.checkout.product_checkout')</span></a>
                            </div>
                            <div class="tp_step_box">
                                <a type="button" class="anchor-button"><svg xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid"
                                        width="38" height="47" viewBox="0 0 38 47">
                                        <g>
                                            <circle cx="19.5" cy="12.5" r="12.5" class="cls-3" />
                                            <path
                                                d="M23.659,8.113 L17.260,13.934 L14.554,11.102 L12.764,12.747 L17.136,17.322 L25.322,9.881 L23.659,8.113 Z"
                                                class="cls-4" />
                                        </g>
                                    </svg>
                                    <span>@lang('master.checkout.done')</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- payment details -->
            <div class="tp_payment_details_wrapper">
                <div class="row">
                    <div class="col-lg-7 col-md-12 col-sm-12">
                        <div class="tp_payment_details_box">
                            <h2>@lang('master.checkout.payment_details')</h2>
                            @if (session()->has('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session()->get('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <form id="checkoutform"action="{{ route('frontend.checkout.store', app()->getLocale()) }}"
                                method="POST">
                                @csrf
                                <div class="row">
                                    @if ($total = Cart::instance('default')->subtotal() > 0)
                                        @if (@$setting->is_checked_paypal)
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="tp_form_field_radio tp_top_space_none">
                                                    <p>@lang('master.checkout.PayPal')</p>
                                                    <div class="tp_img_position">
                                                        <img src="{{ $ASSET_URL }}assets/images/paypal.png"
                                                            alt="">
                                                    </div>
                                                    <div class="tp_custom_radio_btn">
                                                        <label>
                                                            <input type="radio" name="gateway" value="paypal">
                                                            <span class="tp_radio_round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if (@$setting->is_checked_stripe)
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="tp_form_field_radio tp_top_space_none">
                                                    <p>@lang('master.checkout.Stripe')</p>
                                                    <div class="tp_img_position">
                                                        <img src="{{ $ASSET_URL }}assets/images/stripe.png"
                                                            alt="">
                                                    </div>
                                                    <div class="tp_custom_radio_btn">
                                                        <label>
                                                            <input type="radio" name="gateway" value="stripe">
                                                            <span class="tp_radio_round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if (@$setting->is_checked_razorpay)
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="tp_form_field_radio tp_top_space_none">
                                                    <p>@lang('master.checkout.Razorpay')</p>
                                                    <div class="tp_img_position">
                                                        <img src="{{ $ASSET_URL }}assets/images/razorpay.png"
                                                            alt="">
                                                    </div>
                                                    <div class="tp_custom_radio_btn">
                                                        <label>
                                                            <input type="radio" name="gateway" value="razorpay">
                                                            <span class="tp_radio_round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if (@$setting->is_checked_flutterwave)
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="tp_form_field_radio tp_top_space_none">
                                                    <p>@lang('master.checkout.FlutterWave')</p>
                                                    <div class="tp_img_position">
                                                        <img src="{{ $ASSET_URL }}assets/images/flutterwave.png"
                                                            alt="">
                                                    </div>
                                                    <div class="tp_custom_radio_btn">
                                                        <label>
                                                            <input type="radio" name="gateway" value="flutterWave">
                                                            <span class="tp_radio_round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if (@$setting->is_checked_manual_transfer)
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="tp_form_field_radio tp_top_space_none">
                                                    <p>@lang('master.checkout.Manual_Transfer')</p>
                                                    <div class="tp_img_position">
                                                        <img src="{{ $ASSET_URL }}assets/images/manual_transfer.png"
                                                            alt="">
                                                    </div>
                                                    <div class="tp_custom_radio_btn">
                                                        <label>
                                                            <input type="radio" name="gateway" value="manual">
                                                            <span class="tp_radio_round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if (@$setting->is_checked_pawapay)
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <div class="tp_form_field_radio tp_top_space_none">
                                                    <p>@lang('master.checkout.PawaPay')</p>
                                                    <div class="tp_img_position">
                                                        <img src="{{ $ASSET_URL }}assets/images/pawapay.png"
                                                            alt="">
                                                    </div>
                                                    <div class="tp_custom_radio_btn">
                                                        <label>
                                                            <input type="radio" name="gateway" value="pawapay">
                                                            <span class="tp_radio_round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        <div class="mt-4 mb-4">
                                            <p>@lang('master.checkout.no_payment_required')</p>
                                            <input type="hidden" name="gateway" value="free">
                                        </div>
                                    @endif

                                </div>
                                <label id="gateway-error" class="error" for="gateway"></label>
                                <div class="col-lg-12 col-md-12 col-sm-12 d-none" id="manual_transfer_details">
                                    <div class="tp_manual_tranfer">
                                        {!! @$setting->manual_transfer_details !!}
                                    </div>
                                    <div class="tp_form_field tp_trans_refer">
                                        <input type="text" name="reference_number" placeholder="Enter Reference no."
                                            class="form-group">
                                        <label class="control-label">@lang('master.checkout.Enter_Reference_no')</label>
                                    </div>
                                    <label id="reference_number-error" class="error" for="reference_number"></label>
                                </div>

                                @if (Auth::check())
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <h2>@lang('master.user_profile.personal_details')<h2>
                                                <div class="">
                                                    <div class="tp_input_main">

                                                        <div class="tp_input">
                                                            <input type="text" name="billing_name"
                                                                placeholder="Enter Name" class="form-group"
                                                                value="{{ Auth::check() ? trim(auth()->user()->full_name) : '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="tp_input_main">

                                                        <div class="tp_input">
                                                            <input type="text" name="billing_email"
                                                                placeholder="Enter Email" class="form-group"
                                                                value="{{ Auth::check() ? trim(auth()->user()->email) : '' }}">
                                                        </div>
                                                        <label id="billing_email-error" class="error"
                                                            for="billing_email"></label>
                                                    </div>
                                                </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <button type="submit" onclick="validatecheckout('checkoutform')"
                                            id="checkoutform_btn" class="tp_btn tp_btn_full_width">
                                            @if ($total > 0)
                                                @lang('master.checkout.pay_nd_continue')
                                            @else
                                                @lang('master.checkout.continue')
                                            @endif
                                        </button>
                                    </div>
                                @else
                                    <!-- Content for guests (not logged-in users) -->
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <h2>Please log in to see your profile details.</h2>
                                        <a href="{{ route('frontend.sign-in', app()->getLocale()) }}" class="tp_btn tp_btn_full_width">Login</a>
                                    </div>
                                @endif

                            </form>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12">
                        <div class="tp_payment_details_box tp_payment_order_details_box">
                            <h2>@lang('master.checkout.order_details')</h2>
                            <div class="tp_order_list">
                                <div class="tp_order_left">
                                    <p>@lang('master.checkout.total_products')</p>
                                    <p>@lang('master.checkout.sub_total')</p>
                                    <p>@lang('master.checkout.tax')</p>
                                    <p>@lang('master.checkout.discount')</p>
                                </div>
                                <div class="tp_order_left tp_text_right">
                                    <p>{{ @$total_product ?? 0 }}</p>
                                    <p>{{ $price_symbol . @$subtotal ?? 0 }}</p>
                                    <p>{{ $price_symbol . @$tax ?? 0 }}</p>
                                    @if (session()->has('coupon'))
                                        <div class="d-flex tp_delete_order">
                                            <p>{{ @$discount_code }} - {{ $price_symbol }}{{ @$discount ?? 0 }}
                                            <form action="{{ route('frontend.coupon.destroy', app()->getLocale()) }}"
                                                method="POST">
                                                @csrf()
                                                @method('DELETE')
                                                <button type="submit" class="btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                            </p>
                                        </div>
                                    @else
                                        <p>- {{ $price_symbol }}{{ @$discount ?? 0 }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="tp_order_list tp_order_list_border_top">
                                <div class="tp_order_left">
                                    <p>@lang('master.checkout.total')</p>
                                </div>
                                <div class="tp_order_left tp_text_right">
                                    <p>{{ $price_symbol . @$total_value }}</p>
                                </div>
                            </div>
                        </div>

                        @if ($total > 0)
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <form id="coupon_apply_form"
                                    action="{{ route('frontend.coupon.apply', app()->getLocale()) }}" method="POST">
                                    <div class="tp_form_code">
                                        <div class="tp_form_code_text">
                                            <h2>@lang('master.checkout.discount_code')</h2>
                                        </div>
                                        <div class="tp_form_code_coupon">
                                            <div class="">
                                                <input type="text" class="form-control"
                                                    placeholder="Enter Discount Code" name="coupon_code">
                                            </div>
                                            <div>
                                                <button type="submit" id="coupon_apply_form_btn"
                                                    onclick="couponCodeApply('coupon_apply_form')"
                                                    class="tp_btn">@lang('master.checkout.apply')</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--===checkout Section End===-->
@endsection
@section('scripts')
@endsection
