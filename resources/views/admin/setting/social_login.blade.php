@php $ASSET_URL = asset('admin-theme').'/'; @endphp
@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.setting_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li class="active"><a type="button" class="setting-tab" data-target="facebook-setting"><i class="fa fa-facebook"></i> Facebook</a></li>
                <li><a type="button" class="setting-tab" data-target="google-setting"><i class="fa fa-google"></i> Google </a></li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 setting-tab-tar active" id="facebook-setting">
                    <form id="facebook-form" method="POST"action="{{ route('admin.setting.post-social') }}">
                        @csrf
                        <div class="tp_catset_box">
                            <div class="tp_form_wrapper">
                                <label>Show Facebook option to users</label>
                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" name="is_check_facebook_login" value="0">
                                        <input type="checkbox" name="is_check_facebook_login" value="1"
                                            class="form-control"{{ @$data->is_check_facebook_login == 1 ? 'checked' : '' }}><i
                                            class="input-helper"></i>Check / Uncheck </label>
                                </div>
                            </div>
                            <div class="tp_form_wrapper tp_form_mb">
                                <label>Client Id</label>
                                <input type="text" class="form-control"name="facebook_client_id"
                                    value="{{ @$data->facebook_client_id }}" placeholder="Enter Client Id">
                            </div>
                            <div class="tp_form_wrapper tp_form_mb">
                                <label>Client Secret</label>
                                <input type="text" class="form-control"name="facebook_client_secret"
                                    value="{{ @$data->facebook_client_secret }}" placeholder="Enter Client Secret">
                            </div>
                            <button type="submit" class="tp_btn" onclick="socialformvalidate('facebook-form')"
                                id="facebook-form-btn">update</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 setting-tab-tar  setting-tab-google"
                    id="google-setting">
                    <form id="google-form" method="POST"action="{{ route('admin.setting.post-social') }}">
                        @csrf
                        <div class="tp_catset_box">
                            <div class="tp_form_wrapper">
                                <label>Show Google option to users</label>
                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" name="is_check_google_login" value="0">
                                        <input type="checkbox" name="is_check_google_login" value="1"
                                            class="form-control"{{ @$data->is_check_google_login == 1 ? 'checked' : '' }}><i
                                            class="input-helper"></i>Check / Uncheck
                                    </label>
                                </div>
                            </div>
                            <div class="tp_form_wrapper tp_form_mb">
                                <label>Client Id</label>
                                <input type="text" class="form-control" name="google_client_id"
                                    value="{{ @$data->google_client_id }}" placeholder="Enter Client Id">
                            </div>
                            <div class="tp_form_wrapper tp_form_mb">
                                <label>Client Secret</label>
                                <input type="text" class="form-control"name="google_client_secret"
                                    value="{{ @$data->google_client_secret }}" placeholder="Enter Client Secret">
                            </div>
                            <button type="submit" class="tp_btn" id="google-form-btn"
                                onclick="socialformvalidate('google-form')">update</button>
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
