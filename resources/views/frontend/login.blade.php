@extends('frontend.layout.login_master')
@section('head_scripts')
    @php
        $ASSET_URL = asset('user-theme') . '/';
        $setting = getsetting();
        $mUrl = Request::url();
        $mImage = Storage::url($setting->preview_image);
        $mTitle = trans('page_title.Frontend.sign_in_title');
        $mDescr = trans('page_title.Frontend.sign_in_desc');
        $mKWords = trans('page_title.Frontend.sign_in_keyword');
        $site_creator = trans('page_title.Frontend.site_creator');
    @endphp
    <title>{{ @$mTitle }}</title>
    <meta name="keywords" content="{{ @$mKWords }}" />
    <meta name="description" content="{{ @$mDescr }}" />

    <meta property=og:locale content="{{ app()->getLocale() }}" />
    <meta property=og:type content=website />
    <meta property="og:site_name" content="{{ $site_creator }}" />
    <meta property="og:title" content="{{ @$mTitle }}" />
    <meta property="og:description" content="{{ @$mDescr }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ @$mImage }}" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta property="twitter:title" content="{{ @$mTitle }}" />
    <meta property="twitter:description" content="{{ @$mDescr }}" />
    <meta property="twitter:url" content="{{ url()->current() }}" />
    <meta property="twitter:image" content="{{ @$mImage }}" />
    <meta name="twitter:site" content="{{ $site_creator }}" />
    <meta name="twitter:creator" content="{{ $site_creator }}" />
@endsection
@section('content')
    <section>
        <!--=== start Main wraapper ===-->
        <div class="tp_main_wrapper">
            <!--===Login Section Start===-->
            <div class="tp_login_section">
                <div class="tp_login_flex">
                    <div class="tp_login_main">
                        <div class="tp_login_auth">
                            <a href="{{ route('frontend.home', app()->getLocale()) }}">
                                <img src="{{ Storage::url($setting->my_logo) }}" alt="logo" />
                            </a>
                            <h1>@lang('master.login.login_account')</h1>
                            <h5>@lang('master.login.theme_portal_login')</h5>
                            <div class="tp_login_form">
                                <form action="{{ route('frontend.userlogin', app()->getLocale()) }}" method="POST"
                                    id="login-form">
                                    @csrf
                                    <div class="login-content">
                                        <div class="tp_input_main">
                                            <p>@lang('master.login.email')</p>
                                            <div class="tp_input">
                                                <input type="text" placeholder="Enter Your Email" name="email">
                                                <img src="{{ $ASSET_URL }}assets/images/auth/msg.svg" alt="" />
                                            </div>
                                            <label id="email-error" class="error" for="email"></label>

                                            <p>@lang('master.login.password')</p>
                                            <div class="tp_input">
                                                <input type="password" placeholder="Enter Your Password" name="password">
                                                <img class="toggle-password"
                                                    src="{{ $ASSET_URL }}assets/images/auth/password.svg"
                                                    style="cursor:pointer" alt="password" />
                                            </div>
                                            <label id="password-error" class="error" for="password"></label>
                                        </div>
                                    </div>
                                    <div class="tp_check_section">
                                        <ul>
                                            <li>
                                                <div class="tp_checkbox">
                                                    <input type="checkbox" id="auth_remember" name="auth_remember"
                                                        value="1">
                                                    <label for="auth_remember">@lang('master.login.remember_me')</label>
                                                </div>
                                                <span><a
                                                        href="{{ route('frontend.forgot', app()->getLocale()) }}">@lang('master.login.forgot_password')</a></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tp_login_btn">
                                        <button type="submit" class="tp_btn" id="login-form-btn">@lang('master.login.login')</button>
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
                                        <p>@lang('master.login.not_account') <a
                                                href="{{ route('frontend.sign-up', app()->getLocale()) }}">@lang('master.login.create_account')</a>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--===Login Section End===-->
        </div>
        <!--=== End Main wraapper ===-->
    </section>
@endsection
@section('scripts')
@endsection
