@extends('author.layouts.app')
@section('content')
@section('head_scripts')
    <title>@lang('page_title.Admin.my_profile_title')</title>
@endsection
<div class="tp_main_content_wrappo">
    <div class="tp_tab_wrappo">
        <h4 class="tp_heading">My Profile</h4>
    </div>
    <div class="tp_tab_content tp_auth_acc">
        <div class="row">
            <div class="col-lg-3">
                <div class="tp_auth_proimg">
                    <div class="tp_auth_userimg">
                       
                            <div class="tp_upload_area tp_upload_userimg">
                                <div class="tp_pic_wrapper tp_img_div auth_img">
                                    <img class="rounded-pill"
                                        src="@if (!empty(@$data->avatar)) {{ @$data->avatar }} @endif"
                                        alt="user-img" height="120px" width="120px" id="Imagepreview">
                                </div>
                                <div class="tp_upload_pic_thumb">
                                    <label class="upload_button">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px"
                                                fill="#fff" viewBox="0 0 32 32" xmlns:v="https://vecta.io/nano">
                                                <path
                                                    d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956zm-3.457 8.663a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z" />
                                            </svg>
                                        </span>
                                        {{-- <input type="hidden" name="auth_img" value=""> --}}
                                        {{-- <input name="auth_img" class="file_upload image" type="file"
                                            accept="image/*"> --}}
                                            <input type="file" name="image" id="imgupload" class="file_upload image"
                                                                onchange="uploadImage('imgupload')" accept="image/*"/>
                                    </label>
                                </div>
                            </div>
                      
                    </div>
                    <div class="tp_auth_usertext">
                        <h3>{{@$data->full_name}}</h3>
                        <p>Author</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="tp_auth_details">
                    <div class="tp_tab_wrappo tp_auth_tab">
                        <ul>
                            <li class="active"><a href="#" class="setting-tab" data-target="basic-detail">Basic
                                    Details</a></li>
                            <li><a href="#" class="setting-tab" data-target="acc-setting">Account
                                    Settings</a></li>
                        </ul>

                    </div>
                    <div class="tp_auth_tabcontent">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="setting-tab-tar active" id="basic-detail">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="tp_profile_form_wrapper">
                                                <form id="my-profile" action="{{ route('vendor.update_profile') }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-6">
                                                            <div class="tp_form_wrapper form-group">
                                                                <label for="formFirst" class="mb-2">Full Name</label>
                                                                <input id="formFirst" type="text" class="form-control"
                                                                    placeholder="Full Name" name="full_name"
                                                                    value="{{ @$data->full_name }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6">
                                                            <div class="tp_form_wrapper form-group">
                                                                <label for="username" class="mb-2">User Name</label>
                                                                <input id="username" type="text" class="form-control"
                                                                    placeholder="User Name" name="username"
                                                                    value="{{ @$data->username }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6">
                                                            <div class="tp_form_wrapper form-group">
                                                                <label for="emailAddress" class="mb-2">Email</label>
                                                                <input id="emailAddress" type="text" class="form-control"
                                                                    placeholder="Enter your email" name="email"
                                                                    value="{{ @$data->email }}" readonly="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6">
                                                            <div class="tp_form_wrapper form-group ">
                                                                <label for="phoneNumber" class="mb-2">Phone</label>
                                                                <input id="phoneNumber" type="number" class="form-control"
                                                                    placeholder="Enter phone number" name="mobile"
                                                                    value="{{ @$data->mobile }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="tp_form_wrapper">
                                                                <label for="old_password" class="mb-2">Current
                                                                    password</label>
                                                                <input name="old_password" id="old_password" type="password"
                                                                    class="form-control"
                                                                    placeholder="Enter Your Current Password">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="tp_form_wrapper tp_form_mb">
                                                                <label for="NewPassword" class="mb-2">New password</label>
                                                                <input id="NewPassword" type="text" name="password"
                                                                    class="form-control" placeholder="Enter New Password">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="tp_form_wrapper">
                                                                <label for="confirmPass" class="mb-2">Confirm
                                                                    password</label>
                                                                <input id="confirmPass" name="confirm_password"
                                                                    type="password" class="form-control"
                                                                    placeholder="Enter New Password">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mt-4">
                                                        <button type="submit" class="btn tp_btn"
                                                            id="my-profile-btn">Update</button>
                                                    </div>
                                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                                    <input type="hidden" name="avatar" id="image"
                                                        value="{{ @$data->avatar }}">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="setting-tab-tar" id="acc-setting">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="tp_profile_form_wrapper">
                                                <form id="my-account-details-form"
                                                    action="{{ route('vendor.users.additionalInfo') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-6">
                                                            <div class="tp_form_wrapper">
                                                                <label class="mb-2">Account Holder Name</label>
                                                                <input type="text" class="form-control"
                                                                    name="account_holder_name"
                                                                    placeholder="Enter Account Holder Name"
                                                                    value="{{ @$additional_data->account_holder_name }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6">
                                                            <div class="tp_form_wrapper">
                                                                <label class="mb-2">Bank Name</label>
                                                                <input type="text" class="form-control" name="bank_name"
                                                                    placeholder="Enter Full Name"
                                                                    value="{{ @$additional_data->bank_name }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6">
                                                            <div class="tp_form_wrapper">
                                                                <label class="mb-2">Bank Account Number</label>
                                                                <input type="text" class="form-control"
                                                                    name="bank_account_number"
                                                                    placeholder="Enter Bank Account Number"
                                                                    value="{{ @$additional_data->bank_account_number }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6">
                                                            <div class="tp_form_wrapper form-group">
                                                                <label for="formFirst" class="mb-2">IFSC Code</label>
                                                                <input id="formFirst" type="text" class="form-control"
                                                                    placeholder="Enter IFSC Code" name="ifsc_code"
                                                                    value="{{ @$additional_data->ifsc_code }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mt-4">
                                                        <button type="submit" class="btn tp_btn"
                                                            id="my-account-details-form-btn">Update</button>
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
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('admin-theme/my_assets/js/form-validate.js') }}"></script>
@endsection
