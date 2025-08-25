@extends('frontend.layout.login_master')
@section('head_scripts')
@php
    $ASSET_URL = asset('user-theme').'/';
    $setting = getsetting();
    $mUrl = Request::url();
    $mImage = Storage::url($setting->preview_image);
    $mTitle = trans('page_title.Frontend.sign_up_title');
    $mDescr = trans('page_title.Frontend.sign_up_desc');
    $mKWords = trans('page_title.Frontend.sign_up_keyword');
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
    <!--===Signup Section Start===-->
    <div class="tp_login_section">
        <div class="tp_login_flex">
            <div class="tp_login_main">
                <div class="tp_login_auth">
                    <a href="{{ route('frontend.home',app()->getLocale()) }}">
                        <img src="{{Storage::url($setting->my_logo)}}" alt="logo" />
                    </a>
                    <h1>@lang('master.register.welcome_back_to_theme_portal')</h1>
                    <h5>@lang('master.register.please_register_to_continue_your_account')</h5>
                    <div class="tp_login_form">
                        <form id="registration-form" action="{{ route('frontend.usersignup',app()->getLocale()) }}" method="post">
                            <div class="login-content">
                               @csrf
                                <div class="tp_input_main">
                                    <p>@lang('master.register.name')</p>
                                    <div class="tp_input">
                                        <input type="text" placeholder="Enter Your Name" name="name"
                                            >
                                        <img src="{{$ASSET_URL}}assets/images/auth/user.svg" alt="user" />
                                    </div>
                                    <label id="name-error" class="error" for="name"></label>
                                    <p>@lang('master.register.email_address')</p>
                                    <div class="tp_input">
                                        <input type="text" placeholder="Enter Your Email" name="email"
                                            >
                                        <img src="{{$ASSET_URL}}assets/images/auth/msg.svg" alt="email" />
                                    </div>
                                    <label id="email-error" class="error" for="email"></label>
                                    <p>@lang('master.register.password')</p>
                                    <div class="tp_input">
                                        <input type="password" placeholder="Enter Your password" name="password"
                                            >
                                        <img class="toggle-password" src="{{$ASSET_URL}}assets/images/auth/password.svg" style="cursor:pointer" alt="password" />
                                    </div>
                                    <label id="password-error" class="error" for="password" ></label>
                                    <p>@lang('master.register.confirm_password')</p>
                                    <div class="tp_input">
                                        <input type="password" placeholder="Enter Confirm Password"
                                            name="confirmpassword">
                                        <img class="toggle-password" src="{{$ASSET_URL}}assets/images/auth/password.svg" style="cursor:pointer" alt="password" />
                                    </div>
                                    <label id="confirmpassword-error" class="error" for="confirmpassword"></label>
                                </div>

                            </div>
                            <div class="tp_login_btn">
                                <button type="submit" class="tp_btn" id="registration-form-btn">@lang('master.register.sign_up')</button>
                                <div class="tp_socialbtn_wrapper">
                                    @if (@$setting->is_check_facebook_login || @$setting->is_check_google_login)
                                    <!--=== Socail login ===-->
                                        <span>Or</span>
                                        <div class="tp_social_btn">

                                            @if (@$setting->is_check_facebook_login)
                                                <a href="{{ route('frontend.login.google') }}" class="tp_btn"
                                                    id="">
                                                    <i class="fa fa-google" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                        
                                            @if (@$setting->is_check_google_login)
                                                <a href="{{ route('frontend.login.facebook') }}" class="tp_btn"
                                                    id="">
                                                    <i class="fa fa-facebook" aria-hidden="true"></i>
                                                </a>
                                            @endif

                                        </div>
                                        <!--=== Socail login ===-->
                                    @endif
                                </div>
                                <p>@lang('master.register.already_have_an_account') <a href="{{ route('frontend.sign-in',app()->getLocale()) }}">@lang('master.register.login')</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--===Signup Section End===-->
</div>
<!--=== End Main wraapper ===-->
</section>
@endsection
@section('scripts')
@endsection
