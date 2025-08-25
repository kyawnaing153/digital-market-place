<!--===Login Model Popup Start===-->
<div class="modal fade" id="log_modal" tabindex="-1" aria-labelledby="log_modallabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bdr-radius rounded-4 overflow-hidden">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card shadow-none">
                        <div class="card-body">
                            <div class="modal-head">
                                <h2 class="fw-bold mb-2 text-uppercase login-font text-center">@lang('master.login.login_account')
                                </h2>
                                <h5>@lang('master.login.theme_portal_login')</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                <form action="{{ route('frontend.userlogin',app()->getLocale()) }}" method="POST" id="login-form">
                                    @csrf
                                    <div class="login-content">
                                        <div class="tp_input_main">
                                            <p>@lang('master.login.email')</p>
                                            <div class="tp_input">
                                                <input type="text" placeholder="Enter Your Email" name="email">
                                                <img src="{{$ASSET_URL}}assets/images/auth/msg.svg"
                                                    alt="email">
                                            </div>
                                            <label id="email-error" class="error" for="email"></label>

                                            <p>@lang('master.login.password')</p>
                                            <div class="tp_input">
                                                <input type="password" placeholder="Enter Your Password"
                                                    name="password">
                                                <img class="toggle-password"
                                                    src="{{$ASSET_URL}}assets/images/auth/password.svg"
                                                    alt="password">
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
                                                <span><a href="{{ route('frontend.forgot',app()->getLocale()) }}">@lang('master.login.forgot_password')?</a></span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tp_login_btn">
                                        <button type="submit" class="tp_btn" id="login-form-btn">@lang('master.login.login')</button>
                                        <p> @lang('master.login.not_account') <a
                                                href="{{ route('frontend.sign-up',app()->getLocale()) }}" >@lang('master.login.create_account')</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===Login Model Popup End===-->


