@php 
$ASSET_URL = asset('user-theme').'/';
$setting = getsetting(); 
@endphp
@extends('frontend.layout.master')
@section('content')
    <!--===Header Section Start===-->
    <div class="tp_banner_section tp_single_section">
        <div class="container">
            <div class="tp_banner_heading">
                <h2>@lang('master.header.Contact_Us')</h2>
                <p>
                    @lang('master.contact_us.heading')
                </p>
            </div>
        </div>
    </div>
    <!--===Header Section End===-->
    <!--===Contactus Section Start===-->
    <div class="tp_singlepage_section tp_contact_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-5 align-self-center">
                    <div class="tp_contact_box">
                        <h4>@lang('master.contact_us.contact_information')</h4>
                        <div class="tp_contact_detail">
                            <p>@lang('master.contact_us.email_address')</p>
                            <span>{{@$setting->company_email}}</span>
                        </div>
                        <div class="tp_contact_detail">
                            <p>@lang('master.contact_us.number')</p>
                            <span>{{@$setting->company_phone}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-8 col-md-7 align-self-center">
                    <div class="tp_leave_section">
                        <div class="tp_reply_form">
                            <h4>@lang('master.contact_us.here_to_help')</h4>
                            <form method="POST" action="{{ route('frontend.post-contact-us',app()->getLocale()) }}" id="frmContactUs">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="tp_input_box">
                                            <label>@lang('master.contact_us.name')</label>
                                            <div class="tp_input">
                                                <input type="text" placeholder="Enter Name" name="name"
                                                class="form-control" id="name" placeholder="Your Name" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="tp_input_box">
                                            <label>@lang('master.contact_us.email')</label>
                                            <div class="tp_input">
                                                <input type="email" name="email" id="email" placeholder="Your Email"
                                                placeholder="Enter Email" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="tp_input_box">
                                            <label>@lang('master.contact_us.message')</label>
                                            <div class="tp_input">
                                                <textarea name="message" rows="5" placeholder="Message" placeholder="Enter Message"></textarea>
                                            </div>
                                        </div>
                                        <div class="">
                                            <button type="submit" class="tp_btn" id="frmContactUs_btn" >@lang('master.contact_us.submit')</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--===Contactus Section End===-->
@endsection
@section('scripts')
    <script src="{{asset('user-theme/my_assets/js/validation.js')}}"></script>
@endsection
