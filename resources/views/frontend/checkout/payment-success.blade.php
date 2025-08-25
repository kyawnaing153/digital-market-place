@php
    $ASSET_URL = asset('user-theme') . '/';
    $setting = getsetting();
    $price_symbol = $setting->default_symbol ?? '$';
@endphp
@extends('frontend.layout.master')
@section('head_scripts')
    <title>@lang('page_title.Frontend.transaction_success_page_title')</title>
@endsection
@section('content')
    <!--===success payment Section Start===-->
    <div class="tp_payment_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="tp_view_box">
                        <div class="tp_view_text">
                            <h2>@lang('master.payment.payment_status')</h2>
                        </div>
                        <div class="tp_cart_step">
                            <div class="tp_step_box">
                                <a type="button" class="anchor-button"><svg xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid"
                                        width="69" height="47" viewBox="0 0 69 47">
                                        <g>
                                            <circle cx="34.5" cy="12.5" r="12.5" class="cls-1"></circle>
                                            <path
                                                d="M38.659,8.113 L32.260,13.934 L29.554,11.102 L27.764,12.747 L32.136,17.322 L40.322,9.881 L38.659,8.113 Z"
                                                class="cls-2"></path>
                                        </g>
                                    </svg>
                                    <span>@lang('master.payment.add_to_cart')</span></a>
                            </div>
                            <div class="tp_step_box">
                                <a type="button" class="anchor-button"><svg xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid"
                                        width="69" height="47" viewBox="0 0 69 47">

                                        <g>
                                            <circle cx="34.5" cy="12.5" r="12.5" class="cls-1"></circle>
                                            <path
                                                d="M38.659,8.113 L32.260,13.934 L29.554,11.102 L27.764,12.747 L32.136,17.322 L40.322,9.881 L38.659,8.113 Z"
                                                class="cls-2"></path>

                                        </g>
                                    </svg>

                                    <span>@lang('master.payment.checkout')</span>
                                </a>
                            </div>
                            <div class="tp_step_box">
                                <a type="button" class="anchor-button"><svg xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid"
                                        width="38" height="47" viewBox="0 0 38 47">

                                        <g>
                                            <circle cx="19.5" cy="12.5" r="12.5" class="cls-1"></circle>
                                            <path
                                                d="M23.659,8.113 L17.260,13.934 L14.554,11.102 L12.764,12.747 L17.136,17.322 L25.322,9.881 L23.659,8.113 Z"
                                                class="cls-4"></path>

                                        </g>
                                    </svg>

                                    <span>@lang('master.payment.done')</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tp_payment_inner tp_payment_sucess_inner">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-md-12 col-sm-12">
                        <div class="tp_payment_img">
                            <img src="{{ $ASSET_URL }}assets/images/payment.png" alt="">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12">
                        <div class="tp_payment_info tp_payment_sucess tp_pay_manual">
                        
                            @if ($order->status == '0')
                                <h2 >@lang('master.payment.transaction_in_process')</h2>
                                <div class="tp_pay_propara">
                                    <img src="{{ $ASSET_URL . 'assets/images/timer.png' }}" alt="sub-img" width="40px" height="40px">
                                    <p class="">@lang('master.payment.transaction_process_warning')</p>
                                </div>
                            @else
                                <h2>@lang('master.payment.transaction_successful')</h2>
                            @endif


                            <div class="tp_payment_box">
                                <ul>
                                    <li>
                                        <div class="tp_payment_list">
                                            <h4>@lang('master.payment.order_id') :</h4>
                                            <p>{{ @$order->tnx_id }}</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="tp_payment_list">
                                            <h4>@lang('master.payment.order_status') :</h4>
                                            <p>{{ @$order->status_str }}</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="tp_payment_list">
                                            <h4>@lang('master.payment.payment_method') :</h4>
                                            <p>{{ ucfirst(@$order->payment_gateway ?? '-') }}</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="tp_payment_list">
                                            <h4>@lang('master.payment.date') </h4>
                                            <p>{{ date('d M Y h:i:s', strtotime(@$order->created_at)) }}</p>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="tp_payment_list">
                                            <h4>@lang('master.checkout.total')</h4>
                                            <p>{{ $price_symbol . @$order->billing_total }}</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="tp_payment_product">
                                <h3>@lang('master.payment.products')</h3>
                            </div>
                            <div class="tp_trans_btn">
                                <div class="dropdown">

                                    @if ($order->status == 1)
                                        <button class="btn tp_btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            @lang('master.payment.download')
                                        </button>
                                        <ul class="dropdown-menu">
                                            @foreach ($fileArr as $key => $value)
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('frontend.download-file', [app()->getLocale(), 'file_id' => @$value['file_id'], 'tnx_id' => @$tnxId, 'pid' => @$value['product_id']]) }}"
                                                        class=" tp_btn_payment tp_right_space"><span><i
                                                                class="fa fa-download" aria-hidden="true"></i></span>
                                                        {{ @$value['file_name'] }}</a>
                                                        <a class="dropdown-item" href="{{ @$value['file_external_url'] }}" target="_blank" rel="noopener noreferrer">Clcik To Download</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <button class="btn tp_btn " type="button" disabled aria-expanded="false">
                                            @lang('master.payment.download')
                                        </button>
                                    @endif
                                </div>

                                <div class="tp_payment_btn">
                                    <a href="{{ route('frontend.home', app()->getLocale()) }}"
                                        class="tp_btn tp_btn_payment"><span><img
                                                src="{{ $ASSET_URL }}assets/images/home-icon.png" alt="Image"></span>
                                        @lang('master.payment.back_to_home')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--===success payment  Section Start===-->
@endsection
