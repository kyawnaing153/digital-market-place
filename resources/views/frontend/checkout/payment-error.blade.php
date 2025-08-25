@php $ASSET_URL = asset('user-theme').'/'; @endphp
@extends('frontend.layout.master')
@section('head_scripts')
    <title>@lang('page_title.Frontend.transaction_error_page_title')</title>
@endsection
@section('content')
    <!--===error payment  Section Start===-->
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
                                <a href="{{ route('frontend.cart.index', app()->getLocale()) }}"><svg xmlns="http://www.w3.org/2000/svg"
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
                            <div class="tp_step_box tp_step_box_border_red">
                                <a href="{{ route('frontend.checkout', app()->getLocale()) }}"><svg xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid"
                                        width="69" height="47" viewBox="0 0 69 47">

                                        <g>
                                            <circle cx="34.5" cy="12.5" r="12.5" class="cls-1"></circle>
                                            <path
                                                d="M38.659,8.113 L32.260,13.934 L29.554,11.102 L27.764,12.747 L32.136,17.322 L40.322,9.881 L38.659,8.113 Z"
                                                class="cls-2"></path>

                                        </g>
                                    </svg>

                                    <span>@lang('master.payment.checkout')</span></a>
                            </div>
                            <div class="tp_step_box">
                                <a  type="button" class="anchor-button"><svg xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid"
                                        width="25" height="25" viewBox="0 0 25 25">

                                        <g>
                                            <circle cx="12.5" cy="12.5" r="12.5" class="cls-6" />
                                            <path
                                                d="M17.523,15.586 L14.446,12.500 L17.533,9.423 L15.592,7.476 L12.505,10.553 L9.429,7.466 L7.481,9.407 L10.558,12.494 L7.472,15.570 L9.412,17.517 L12.499,14.441 L15.575,17.527 L17.523,15.586 Z"
                                                class="cls-5" />
                                        </g>
                                    </svg>
                                    <span>@lang('master.payment.done')</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tp_payment_inner">
                <div class="row">
                    <div class="col-lg-7 col-md-12 col-sm-12">
                        <div class="tp_payment_img">
                            <img src="{{ $ASSET_URL }}assets/images/payment1.png" alt="">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12">
                        <div class="tp_payment_info">
                            <h2>@lang('master.payment.transaction_unsuccessful')</h2>
                            <div class="tp_payment_para">
                                <p>{!! session()->get('error') !!} </p>
                                <p>@lang('master.payment.please_try_again')</p>
                            </div>
                            <div class="tp_payment_btn">
                                <a href="{{ route('frontend.checkout', app()->getLocale()) }}"
                                    class="tp_btn tp_btn_payment tp_right_space"><span><img
                                            src="{{ $ASSET_URL }}assets/images/reload-icon.png" alt="Image"></span>
                                    @lang('master.payment.try_again')</a>
                                <a href="{{ route('frontend.home', app()->getLocale()) }}"
                                    class="tp_btn tp_btn_payment"><span><img
                                            src="{{ $ASSET_URL }}assets/images/home-icon.png"
                                            alt="Image"></span>@lang('master.payment.back_to_home')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--===error payment Section Start===-->
@endsection
@section('scripts')
@endsection
