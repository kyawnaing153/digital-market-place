@php  $ASSET_URL = asset('admin-theme/assets').'/'; @endphp
@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.setting_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                @foreach ($payment_gateways as $key => $val)
                    @php $name = str_replace(' ', '',$val) @endphp
                    <li class="@if ($loop->first) active @endif">
                        <a type="button" class="setting-tab" data-target="{{ $name  }}"><img
                                src="{{ $ASSET_URL }}images/{{ $name }}.png" alt="{{@$val}}">
                            {{ @$val }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                {{-- paypal-form --}}
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar active" id="PayPal">
                        <form id="paypal-form" action="{{ route('admin.setting.updateSettings') }}" method="POST">
                            @csrf
                            <div class="tp_catset_box">
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Show paypal option to users</label>
                                    <div class="checkbox">
                                        <label>
                                            <input type="hidden" class="form-control" name="is_checked_paypal"
                                                value="0">
                                            <input type="checkbox" class="form-control" name="is_checked_paypal"
                                                value="1" @if (@$data->is_checked_paypal) checked @endif>
                                            <i class="input-helper"></i>Check / Uncheck to Show paypal option to users
                                        </label>
                                    </div>
                                </div>
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Is PayPal Live Credentails</label>
                                    <div class="checkbox">
                                        <label>
                                            <input type="hidden" class="form-control" name="is_live_paypal" value="0">
                                            <input type="checkbox" class="form-control" name="is_live_paypal" value="1"
                                                @if (@$data->is_live_paypal) checked @endif>
                                            <i class="input-helper"></i>Check / Uncheck to Live by default sandbox.
                                        </label>
                                    </div>
                                </div>

                                <div class="tp_form_wrapper">
                                    <label class="mb-2">App ID</label>
                                    <input type="text"class="form-control" name="paypal_app_id" placeholder="Enter App ID"
                                        value="{{ @$data->paypal_app_id }}">
                                </div>
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Paypal Client Id</label>
                                    <input type="text"class="form-control" name="paypal_client_id"
                                        placeholder="Enter Client ID" value="{{ @$data->paypal_client_id }}">
                                </div>
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Paypal Client Secret</label>
                                    <input type="text"class="form-control" name="paypal_client_secret"
                                        placeholder="Enter Client Secret" value="{{ @$data->paypal_client_secret }}">
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="tp_btn" id="paypal-form-btn"
                                        onclick="PaymentformValidate('paypal-form')">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                 {{-- stripe-form    --}}
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar" id="Stripe">
                        <form id="stripe-form" action="{{ route('admin.setting.updateSettings') }}" method="POST">
                            @csrf
                            <div class="tp_catset_box">
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Show Stripe option to users</label>
                                    <div class="checkbox">
                                        <label>
                                            <input type="hidden" class="form-control" name="is_checked_stripe"
                                                value="0">
                                            <input type="checkbox" class="form-control" name="is_checked_stripe"
                                                value="1" @if (@$data->is_checked_stripe) checked @endif>
                                            <i class="input-helper"></i>Check / Uncheck to Show Stripe option to
                                            users</label>
                                    </div>
                                </div>
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Live Stripe Key</label>
                                    <input type="text" class="form-control" name="stripe_public_key"
                                        placeholder="Enter Stripe Key" value="{{ @$data->stripe_public_key }}">
                                </div>
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Live Stripe Secret</label>
                                    <input type="text" class="form-control" name="stripe_secret_key"
                                        placeholder="Enter Stripe Secret" value="{{ @$data->stripe_secret_key }}">
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="tp_btn" id="stripe-form-btn"
                                        onclick="PaymentformValidate('stripe-form')">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                 {{-- Razorpay --}}
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar" id="Razorpay">
                        <form id="razorpay-form" action="{{ route('admin.setting.updateSettings') }}" method="POST">
                            @csrf
                            <div class="tp_catset_box">
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Show Razorpay option to users</label>
                                    <div class="checkbox">
                                        <label>
                                            <input type="hidden" class="form-control" name="is_checked_razorpay"
                                                value="0">
                                            <input type="checkbox" class="form-control" name="is_checked_razorpay"
                                                value="1" @if (@$data->is_checked_razorpay) checked @endif>
                                            <i class="input-helper"></i>Check / Uncheck to Show razorpay option to
                                            users
                                        </label>
                                    </div>
                                </div>
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Razorpay Key</label>
                                    <input type="text" class="form-control" name="razorpay_key"
                                        placeholder="Enter razorpay Key" value="{{ @$data->razorpay_key }}">
                                </div>
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">razorpay Secret</label>
                                    <input type="text" class="form-control" name="razorpay_secret_key"
                                        placeholder="Enter razorpay Scvret" value="{{ @$data->razorpay_secret_key }}">
                                </div>
                                <div class="mt-2">
                                    <button type="submit" class="tp_btn" id="razorpay-form-btn"
                                        onclick="PaymentformValidate('razorpay-form')">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
               {{-- ManualTransfer --}}

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar" id="ManualTransfer">
                        <form id="manual-transfer-form" action="{{ route('admin.setting.updateSettings') }}" method="POST">
                            @csrf
                            <div class="tp_catset_box">
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Show Manual Transfer Details option to users</label>
                                    <div class="checkbox">
                                        <label>
                                            <input type="hidden" class="form-control" name="is_checked_manual_transfer"
                                                value="0">
                                            <input type="checkbox" class="form-control" name="is_checked_manual_transfer"
                                                value="1" @if (@$data->is_checked_manual_transfer) checked @endif>
                                            <i class="input-helper"></i>Check / Uncheck </label>
                                    </div>
                                </div>
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Manual Transfer Details</label>
                                    <textarea class="form-control" rows="4" cols="50" spellcheck="false" placeholder="Enter Manual Transfer Details" name="manual_transfer_details" id="theme-editor">         
                                        {{ @$data->manual_transfer_details }}
                                    </textarea>
                                </div>
                               
                                <div class="mt-2">
                                    <button type="submit" class="tp_btn" id="manual-transfer-form-btn"
                                        onclick="PaymentformValidate('manual-transfer-form')">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                 {{-- flutterwave --}}

                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar" id="FlutterWave">
                        <form id="flutterwave-form" action="{{ route('admin.setting.updateSettings') }}" method="POST">
                            @csrf
                            <div class="tp_catset_box">
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Show Flutterwave option to users</label>
                                    <div class="checkbox">
                                        <label>
                                            <input type="hidden" class="form-control" name="is_checked_flutterwave"
                                                value="0">
                                            <input type="checkbox" class="form-control" name="is_checked_flutterwave"
                                                value="1" @if (@$data->is_checked_flutterwave) checked @endif>
                                            <i class="input-helper"></i>Check / Uncheck </label>
                                    </div>
                                </div>

                                 <div class="tp_form_wrapper">
                                    <label class="mb-2">Flutterwave Key</label>
                                    <input type="text" class="form-control" name="flutterwave_key"
                                        placeholder="Enter FlutterWave Key" value="{{ @$data->flutterwave_key }}">
                                </div>

                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Flutterwave Secret Key</label>
                                    <input type="text" class="form-control" name="flutterwave_secret"
                                        placeholder="Enter FlutteWave secret key" value="{{ @$data->flutterwave_secret }}">
                                </div>
                              
                                <div class="mt-2">
                                    <button type="submit" class="tp_btn" id="flutterwave-form-btn"
                                        onclick="PaymentformValidate('flutterwave-form')">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>    

                {{-- pawapay --}}
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar" id="PawaPay">
                        <form id="pawaPay-form" action="{{ route('admin.setting.updateSettings') }}" method="POST">
                            @csrf
                            <div class="tp_catset_box">
                                <div class="tp_form_wrapper">
                                    <label class="mb-2">Show pawapay option to users</label>
                                    <div class="checkbox">
                                        <label>
                                            <input type="hidden" class="form-control" name="is_checked_pawapay"
                                                value="0">
                                            <input type="checkbox" class="form-control" name="is_checked_pawapay"
                                                value="1" @if (@$data->is_checked_pawapay) checked @endif>
                                            <i class="input-helper"></i>Check / Uncheck </label>
                                    </div>
                                </div>

                                 <div class="tp_form_wrapper">
                                    <label class="mb-2">pawaPay Token</label>
                                    <input type="text" class="form-control" name="pawapay_token"
                                        placeholder="Enter pawaPay Token" value="{{ @$data->pawapay_token }}">
                                </div>

                                <div class="mt-2">
                                    <button type="submit" class="tp_btn" id="pawaPay-form-btn"
                                        onclick="PaymentformValidate('pawaPay-form')">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('scripts')
        <script src="{{ asset('admin-theme/my_assets/js/setting.js') }}"></script>
    @endsection
