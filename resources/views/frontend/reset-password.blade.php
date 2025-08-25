@extends('frontend.layout.login_master')
@section('head_scripts')
@php
    $ASSET_URL = asset('user-theme').'/';
    $mUrl = Request::url();
    $mImage = Storage::url(getSettingShortValue('preview_image'));
    $mTitle = trans('page_title.Frontend.reset_password_title');
    $mDescr = trans('page_title.Frontend.reset_password_desc');
    $mKWords = trans('page_title.Frontend.reset_password_keyword');
    $site_creator = trans('page_title.Frontend.site_creator');
@endphp
<title>{{ @$mTitle }}</title>
<meta name="keywords" content="{{ @$mKWords }}" />
<meta name="description" content="{{ @$mDescr }}" />

<meta property=og:locale content="{{ app()->getLocale() }}" />
<meta property=og:type content=website />
<meta property="og:site_name" content="" />
<meta property="og:title" content="{{ @$mTitle }}" />
<meta property="og:description" content="{{ @$mDescr }}" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:image" content="{{ @$mImage }}" />

<meta name="twitter:card" content="summary_large_image" />
<meta property="twitter:title" content="{{ @$mTitle }}" />
<meta property="twitter:description" content="{{ @$mDescr }}" />
<meta property="twitter:url" content="{{ url()->current() }}" />
<meta property="twitter:image" content="{{ @$mImage }}" />
<meta name="twitter:site" content="" />
<meta name="twitter:creator" content="" />
@endsection
@section('content')
<section>
<!--=== start Main wraapper ===-->
<div class="tp_main_wrapper">
    <!--===Reset Password Section Start===-->
    <div class="tp_login_section">
        <div class="tp_login_flex">
            <div class="tp_login_main">
                <div class="tp_login_auth">
                    <img src="{{Storage::url(getSettingShortValue('my_logo'))}}" alt="logo" />
                    <h1>@lang('master.reset_password.welcome_back_to') <span>@lang('master.reset_password.theme_portal')</span></h1>
                    <h5>@lang('master.reset_password.reset_link')</h5>
                    <form id="reset-password-form" action="{{route('frontend.post-reset-password',app()->getLocale())}}" method="post">
                        <div class="tp_login_form">
                           @csrf
                            <div class="login-content">
                                <div class="tp_input_main">
                                    <p>@lang('master.reset_password.new_pasword')</p>
                                    <div class="tp_input">
                                        <input type="password" placeholder="Enter New Password" name="password">
                                        <img class="toggle-password"
                                            src="{{$ASSET_URL }}assets/images/auth/password.svg" style="cursor:pointer" alt="password" />
                                    </div>
                                    <label id="password-error" class="error" for="password" ></label>
                                    <p>@lang('master.reset_password.confirm_password')</p>
                                    <div class="tp_input">
                                        <input type="password" placeholder="Enter Confirm Password" name="confirmpassword">
                                        <img class="toggle-password"
                                            src="{{$ASSET_URL }}assets/images/auth/password.svg" style="cursor:pointer" alt="password" />
                                    </div>
                                    <label id="confirmpassword-error" class="error" for="confirmpassword"></label>
                                </div>
                            </div>
                            <div class="tp_login_btn">
                                <button type="submit" class="tp_btn" id="reset-password-form-btn">@lang('master.reset_password.update')</button>
                                <p>@lang('master.reset_password.already_account') <a href="{{ route('frontend.sign-in',app()->getLocale()) }}">@lang('master.reset_password.login')</a></p>
                            </div>
                        </div>
                        <input type="hidden" name="token" value="{{@$token}}">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--===Reset Password Section End===-->
</div>
<!--=== End Main wraapper ===-->
</section>
@endsection
@section('scripts')
@endsection
