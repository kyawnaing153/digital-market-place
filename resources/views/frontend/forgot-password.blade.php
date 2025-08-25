@extends('frontend.layout.login_master')
@section('head_scripts')
@php
    $ASSET_URL = asset('user-theme').'/';
    $mUrl = Request::url();
    $mImage = Storage::url(getSettingShortValue('preview_image'));
    $mTitle = trans('page_title.Frontend.forgot_password_title');
    $mDescr = trans('page_title.Frontend.forgot_password_desc');
    $mKWords = trans('page_title.Frontend.forgot_password_keyword');
    $site_creator = trans('page_title.Frontend.site_creator');

@endphp
<title>{{ @$mTitle }}</title>
<meta name="keywords" content="{{ @$mKWords }}" />
<meta name="description" content="{{ @$mDescr }}" />
<meta property=og:locale content="{{ app()->getLocale() }}" />
<meta property=og:type content=website />
<meta property="og:site_name" content="{{$site_creator}}"/>
<meta property="og:title" content="{{ @$mTitle }}" />
<meta property="og:description" content="{{ @$mDescr }}" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:image" content="{{ @$mImage }}" />
<meta name="twitter:card" content="summary_large_image" />
<meta property="twitter:title" content="{{ @$mTitle }}" />
<meta property="twitter:description" content="{{ @$mDescr }}" />
<meta property="twitter:url" content="{{ url()->current() }}" />
<meta property="twitter:image" content="{{ @$mImage }}" />
<meta name="twitter:site" content="{{$site_creator}}" />
<meta name="twitter:creator" content="{{$site_creator}}" />
@endsection
@section('content')
<section>
<!--=== start Main wraapper ===-->
<div class="tp_main_wrapper">
    <!--===Forgot Section Start===-->
    <div class="tp_login_section">
        <div class="tp_login_flex">
            <div class="tp_login_main">
                <div class="tp_login_auth">
                    <a href="{{ route('frontend.home',app()->getLocale()) }}">
                        <img src="{{  Storage::url(getSettingShortValue('my_logo'))}}" alt="logo" />
                    </a>
                    <h1>@lang('master.forgot_password.welcome_back_to') <span>@lang('master.forgot_password.theme_portal')</span></h1>
                    <h5>@lang('master.forgot_password.reset_link')</h5>
                    <form id="forgot-form" action="{{ route('frontend.post-forgot',app()->getLocale()) }}" method="post">
                        <div class="tp_login_form">
                            @csrf
                            <div class="login-content">
                                <div class="tp_input_main">
                                    <label>@lang('master.forgot_password.email_address')</label>
                                    <div class="tp_input tp_input_border0">
                                        <input type="text" placeholder="Enter Your Email" name="email" id="email">
                                        <img src="{{$ASSET_URL}}assets/images/auth/msg.svg" alt="Email" />
                                    </div>
                                    <label id="email-error" class="error" for="email"></label>
                                </div>
                            </div>
                            <div class="tp_login_btn">
                                <button type="submit" class="tp_btn" id="forgot-form-btn">@lang('master.forgot_password.send_password')</button>
                                <p>@lang('master.forgot_password.already_account') <a href="{{ route('frontend.sign-in',app()->getLocale()) }}">@lang('master.forgot_password.login')</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--===Forgot Section End===-->
</div>
<!--=== End Main wraapper ===-->
</section>
@endsection 
@section('scripts')
@endsection
