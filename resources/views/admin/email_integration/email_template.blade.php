@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.email_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li class="active">
                    <a type="button" class="setting-tab" data-target="SMTP-settings">SMTP Setting</a>
                </li>
                <li>
                    <a type="button" class="setting-tab" data-target="email-setting">Basic Email Setting</a>
                </li>
                <li>
                    <a type="button" class="setting-tab" data-target="registration-template">Registration Template</a>
                </li>
                <li>
                    <a type="button" class="setting-tab" data-target="forget-password-template">Forget Password
                        Template</a>
                </li>
                <li>
                    <a type="button" class="setting-tab" data-target="new-user-template">Add New User Template</a>
                </li>

            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <!-- SMTP Settings -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar active" id="SMTP-settings">
                    <div class="tp_catset_box">
                        <form id="smtp-setting-form" class="setting-form"
                            action="{{ route('admin.email_templates_store') }}" method="POST">
                            <div class="alert alert-info">
                                <strong>Info!</strong> Uncheck use SMTP to send email checkbox if
                                you want default php mail server.
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Use SMTP to send email</label>
                                        <div class="checkbox">
                                            <input type="hidden" name="is_checked_smtp" value="0">
                                            <label><input type="checkbox" class="form-control" name="is_checked_smtp"
                                                    value="1"{{ @$data->is_checked_smtp == 1 ? 'Checked' : '' }} /><i
                                                    class="input-helper"></i>Click to Uncheck / Check</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12 col-sm-12">
                                <div class="tp_form_wrapper">
                                <label class="mb-2">SMTP Host</label>
                                <input type="text" class="form-control" placeholder="Enter SMTP Host" name="smtp_host"value="{{ @$data->smtp_host }}" />
                            </div>
                            </div>
                            <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="tp_form_wrapper">
                                <label class="mb-2">SMTP Port</label>
                                <input type="text" class="form-control" placeholder="Enter SMTP Port" name="smtp_port"
                                    value="{{ @$data->smtp_port }}" />
                            </div>
                            </div>
                            <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Use Encryption</label>
                                <div class="checkbox">
                                    <input type="hidden"name="is_checked_encry" value="0">
                                    <label><input type="checkbox"class="form-control" name="is_checked_encry"
                                            value="1"{{ @$data->is_checked_encry == 1 ? 'Checked' : '' }} /><i
                                            class="input-helper"></i>Click to Uncheck / Check</label>
                                </div>
                            </div>
                            </div>
                            <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="tp_form_wrapper">
                                <label class="mb-2">SMTP Encryption</label>
                                <input type="text" class="form-control" name="smtp_encry" placeholder="Enter SMTP Encryption"
                                    value="{{ @$data->smtp_encry }}" />
                            </div>
                            </div>
                            <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Use Authentication</label>
                                <div class="checkbox">
                                    <input type="hidden"name="is_checked_smtp_auth" value="0">
                                    <label>
                                        <input type="checkbox" class="form-control" name="is_checked_smtp_auth"
                                            value="1" {{ @$data->is_checked_smtp_auth == 1 ? 'Checked' : '' }} /><i
                                            class="input-helper"></i>Click to Uncheck / Check
                                    </label>
                                </div>
                            </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="tp_form_wrapper">
                                <label class="mb-2">SMTP Username</label>
                                <input type="text" class="form-control" name="smtp_username" placeholder="Enter SMTP Username"
                                    value="{{ @$data->smtp_username }}" />
                            </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="tp_form_wrapper">
                                <label class="mb-2">SMTP Password</label>
                                <input type="text" class="form-control" name="smtp_password" placeholder="Enter SMTP Password"
                                    value="{{ @$data->smtp_password }}" />
                            </div>
</div>
                            
                            </div>
                            
                          
                        
                          
                          
                          
                            
                           
                            <div class="mt-2">
                                <button type="submit" class="tp_btn" id="smtp-setting-form-btn">Update</button>
                            </div>
                            <div class="alert alert-info" style="margin: 20px 0px 0px 0px">
                                <strong>Info!</strong> Please use SMTP before reading your SMTP
                                provider's manual carefully.
                            </div>
                        </form>
                    </div>
                </div>
                </div>
                <!-- Email settings -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar"id="email-setting">
                    <div class="tp_catset_box">
                        <form id="email-setting-form" class="setting-form"
                            action="{{ route('admin.email_templates_store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12">
                                <div class="tp_form_wrapper">
                                <label class="mb-2">Show logo in email</label>
                                <div class="checkbox">
                                    <input type="hidden" value="0" name="is_checked_logo_on_mail">
                                    <label><input type="checkbox" name="is_checked_logo_on_mail" class="form-control"
                                            value="1"@if (@$data->is_checked_logo_on_mail == 1) checked @endif /><i
                                            class="input-helper"></i>Click to Show logo in email</label>
                                </div>
                            </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-12">
                                <div class="tp_form_wrapper">
                                <label class="mb-2">From Name</label>
                                <input type="text" name="from_name" class="form-control" placeholder="Enter From Name"
                                    value="{{ @$data->from_name }}" />
                            </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-12">
                                <div class="tp_form_wrapper">
                                <label class="mb-2">From Address Email</label>
                                <input type="text" name="form_address" class="form-control" placeholder="Enter From Address Email"
                                    value="{{ @$data->form_address }}" />
                            </div>
</div>
<div class="col-lg-12 col-md-12 col-12">
    <div class="tp_form_wrapper">
        <label class="mb-2">Show Reply-To email</label>
        <div class="checkbox">
            <input type="hidden" value="0" name="is_checked_reply_email">
            <label><input type="checkbox" name="is_checked_reply_email" class="form-control"
                    value="1"@if (@$data->is_checked_reply_email == 1) checked @endif /><i
                    class="input-helper"></i>Click to Show Reply-To email</label>
        </div>
    </div>
</div>
<div class="col-lg-6 col-md-12 col-12">
    <div class="tp_form_wrapper">
        <label class="mb-2">Reply-to email</label>
        <input type="text" name="reply_email" class="form-control" placeholder="Enter Repply-to Email"
            value="{{ @$data->reply_email }}" />
    </div>
</div>
<div class="col-lg-6 col-md-12 col-12">
    <div class="tp_form_wrapper">
        <label class="mb-2">Email on which you wish to receive Contact page
            queries/support</label>
        <input type="text" name="support_email" class="form-control" placeholder="Enter Email which you receive in contact page"
            value="{{ @$data->support_email }}" />
    </div>
</div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-12">
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Please, check this Checkbox if you are going to use another language
                                    then
                                    English</label>
                                <div class="checkbox">
                                    <input type="hidden" value="0" name="is_checked_other_lang_on_mail">
                                    <label><input type="checkbox" name="is_checked_other_lang_on_mail"
                                            class="form-control"
                                            value="1"{{ @$data->is_checked_other_lang_on_mail == 1 ? 'Checked' : '' }} /><i
                                            class="input-helper"></i>Click to Use Language</label>
                                </div>
                            </div>
                        </div>
                            <button type="submit" class="tp_btn" id="email-setting-form-btn">Update</button>
                        </form>
                    </div>
                </div>
                </div>
                <!-- Registration Template settings -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar" id="registration-template">
                    <div class="tp_catset_box">
                        <form id="template-setting-form" class="setting-form"
                            action="{{ route('admin.email_templates_store') }}" method="POST">
                            <div class="alert alert-info">
                                <strong>Info!</strong> Use below shortcodes.
                            </div>
                            <p>[username] : To use Registered User's Name</p>
                            <p>[linktext] : Activation link will appear here</p>
                            <p class="mb-3">[break] : To break the line</p>
                            <div class="alert alert-info">
                                <strong>Info!</strong> Use above shortcodes.
                            </div>
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Template text</label>
                                <textarea rows="8"cols="50" spellcheck="false" class="form-textarea" placeholder="Enter Template Text" name="registration_template">{{ @$data->registration_template }}</textarea>
                            </div>
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Activation link text</label>
                                <input type="text" class="form-control" placeholder="Enter Activation Link Text"
                                    name="reg_link_text"value="{{ @$data->reg_link_text }}" />
                            </div>
                            <div class="mt-2 tp_emailupdate_btn">
                                <button type="submit" class="tp_btn" id="template-setting-form-btn">Update</button>
                            </div>
                        </form>
                        <form action="{{ route('admin.email.sendmail') }}" id="testing-reg-temp-form" method="POST">
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Enter email to send a test email.</label>
                                <div class="tp_input_grp">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-8">
                                            <div class="tp_form_wrapper">
                                                <input type="text" class="form-control" name="email" id="email" 
                                                    value="" placeholder="Enter Email">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-4">
                                            <button type="submit" class="tp_btn" id="testing-reg-temp-form-btn"
                                                onclick="testMail('testing-reg-temp-form')">Send <i
                                                    class="fa fa-paper-plane " aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="type" value="registration_test">
                        </form>
                    </div>
                </div>
                </div>
                <!-- Forget Password Template settings -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar" id="forget-password-template">
                        <div class="tp_catset_box">
                            <form id="forget-password-template-form" class="setting-form"
                                action="{{ route('admin.email_templates_store') }}" method="POST">
                                <div class="alert alert-info">
                                    <strong>Info!</strong> Use below shortcodes.
                                </div>
                                <p>[username] : To use User's Name</p>
                                <p>[linktext] : Reset password link will appear here</p>
                                <p class="mb-3">[break] : To break the line</p>
                                <div class="alert alert-info">
                                    <strong>Info!</strong> Use above shortcodes.
                                </div>
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Template text</label>
                                    <textarea rows="8" cols="50" spellcheck="false" class="form-textarea" placeholder="Enter Template Text" name="forget_password_template">{{ @$data->forget_password_template }}</textarea>
                                </div>
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Forgot password link text</label>
                                    <input type="text" class="form-control" name="forget_pass_link_text" placeholder="Enter Forget Passsword Link Text"
                                        value="{{ @$data->forget_pass_link_text }}" />
                                </div>
                                <div class="mt-2 tp_emailupdate_btn">
                                    <button type="submit" class="tp_btn"
                                        id="forget-password-template-form-btn">Update</button>
                                </div>
                            </form>
                            <form action="{{ route('admin.email.sendmail') }}" id="testing-forget-password-form"
                                method="POST">
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Enter email to send a test email.</label>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-8">
                                            <div class="tp_form_wrapper">
                                                <input type="text" class="form-control" name="email" id="email" placeholder="Enter Email To Send A Test Email"
                                                    value="" placeholder="Enter Email">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-4">
                                            <button type="submit" class="tp_btn" id="testing-forget-password-form-btn"
                                                onclick="testMail('testing-forget-password-form')">Send <i
                                                    class="fa fa-paper-plane " aria-hidden="true"></i></button>
                                        </div>

                                    </div>
                                    <input type="hidden" class="form-control" name="type"
                                        value="forget_password_test">
                            </form>
                        </div>
                    </div>
                </div>
                <!-- New User Template -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar"id="new-user-template">
                    <div class="tp_catset_box">
                        <form id="new-user-template-form" class="setting-form"
                            action="{{ route('admin.email_templates_store') }}" method="POST">
                            <div class="alert alert-info">
                                <strong>Info!</strong> Use below shortcodes.
                            </div>
                            <p>[email] : User's Email</p>
                            <p>[password] : Password</p>
                            <p>[website_link] : Website link</p>
                            <p class="mb-3">[break] : To break the line</p>
                            <div class="alert alert-info">
                                <strong>Info!</strong> Use above shortcodes.
                            </div>
                            <div class="tp_form_wrapper tp_form_mb">
                                <label class="mb-2">Template text</label>
                                <textarea rows="8" cols="50" spellcheck="false" class="form-textarea" placeholder="Enter Template Text" name="new_user_template">{{ @$data->new_user_template }}</textarea>
                            </div>

                            <div class="mt-2 tp_emailupdate_btn">
                                <button type="submit" class="tp_btn" id="new-user-template-form-btn">Update</button>
                            </div>
                        </form>
                        <form action="{{ route('admin.email.sendmail') }}" id="testing-new-user-temp-form"
                            method="POST">
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Enter email to send a test email.</label>
                                <div class="tp_input_grp">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-8">
                                            <div class="tp_form_wrapper">
                                                <input type="text" class="form-control" name="email" id="email"
                                                    value="" placeholder="Enter Email">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-4">
                                            <button type="submit" class="tp_btn" id="testing-new-user-temp-form-btn"
                                                onclick="testMail('testing-new-user-temp-form')">Send <i
                                                    class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="type" value="new_user_temp_test">
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('admin-theme/my_assets/js/form-validate.js') }}"></script>
@endsection
