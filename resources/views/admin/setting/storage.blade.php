@php  $ASSET_URL = asset('admin-theme/assets').'/'; @endphp
@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.setting_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li class="active"><a href="#" class="setting-tab" data-target="local-setting">@lang('master.storage.Storage')</a></li>
                <li><a href="#" class="setting-tab" data-target="s3-setting">@lang('master.storage.s3')</a></li>
                <li><a href="#" class="setting-tab" data-target="wasabi-setting">@lang('master.storage.Wasabi')</a></li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">

                <!-- s3 Settings -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar active" id="local-setting">
                        <form id="driver-form-setting" action="{{ route('admin.setting.updateSettings') }}" method="POST">
                            @csrf
                            <div class="tp_catset_box">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">@lang('master.storage.Storage_type')<sup>*</sup></label>
                                            <div class="tp_custom_select">
                                                <select class="form-select" name="FILESYSTEM_DISK">
                                                    @php $disk = ['local'=>'local','s3'=>'S3','wasabi'=>'Wasabi'] @endphp
                                                    @foreach ($disk as $key => $val)
                                                        <option value="{{ $key }}"
                                                            @if (@$data->FILESYSTEM_DISK == $key) selected @endif>
                                                            {{ $val }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="tp_seo_btn">
                                            <button type="submit" class="tp_btn" id="driver-form-setting-btn"
                                                >@lang('master.storage.update')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- s3 Settings -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar" id="s3-setting">
                        <form id="aws-s3-form" action="{{ route('admin.setting.updateSettings') }}" method="POST">
                            @csrf
                            <div class="tp_catset_box">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">@lang('master.storage.Aws_Access_Key')</label>
                                            <input class="form-control" type="text" placeholder="Enter Aws Access key"
                                                name="AWS_ACCESS_KEY_ID" value="{{ @$data->AWS_ACCESS_KEY_ID }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">@lang('master.storage.Aws_Secret_Key')</label>
                                            <input class="form-control" type="text" placeholder="Enter Aws secret key"
                                                name="AWS_SECRET_ACCESS_KEY" value="{{ @$data->AWS_SECRET_ACCESS_KEY }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">@lang('master.storage.Aws_Region')</label>
                                            <input class="form-control" type="text" placeholder="Enter Aws Region"
                                                name="AWS_DEFAULT_REGION" value="{{ @$data->AWS_DEFAULT_REGION }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">@lang('master.storage.Aws_Bucket_Name')</label>
                                            <input class="form-control" type="text" placeholder="Enter Aws Bucket Name"
                                                name="AWS_BUCKET" value="{{ @$data->AWS_BUCKET }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">@lang('master.storage.Aws_URL')</label>
                                            <input class="form-control" type="text" placeholder="Enter Aws URL"
                                                name="AWS_URL" value="{{ @$data->AWS_URL }}">
                                        </div>
                                    </div>


                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">@lang('master.storage.Aws_Endpoint')</label>
                                            <input class="form-control" type="text" placeholder="Aws Endpoint"
                                                name="AWS_ENDPOINT" value="{{ @$data->AWS_ENDPOINT }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="tp_seo_btn">
                                            <button type="submit" class="tp_btn" id="aws-s3-form-btn"
                                                >@lang('master.storage.update')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- wasabi Settings -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar" id="wasabi-setting">
                        <form id="wasabi-form" action="{{ route('admin.setting.updateSettings') }}" method="POST">
                            @csrf
                            <div class="tp_catset_box">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">@lang('master.storage.Wasabi_Access_Key')</label>
                                            <input class="form-control" type="text"
                                                placeholder="Enter wasabi access key" name="WASABI_KEY"
                                                value="{{ @$data->WASABI_KEY }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">@lang('master.storage.Wasabi_Secret_Key')</label>
                                            <input class="form-control" type="text"
                                                placeholder="Enter wasabi secret key" name="WASABI_SECRET"
                                                value="{{ @$data->WASABI_SECRET }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">@lang('master.storage.Wasabi_Region')</label>
                                            <input class="form-control" type="text" placeholder="Enter wasabi region"
                                                name="WASABI_REGION" value="{{ @$data->WASABI_REGION }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">@lang('master.storage.Wasabi_Bucket_Name')</label>
                                            <input class="form-control" type="text"
                                                placeholder="Enter wasabi bucket name" name="WASABI_BUCKET"
                                                value="{{ @$data->WASABI_BUCKET }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">@lang('master.storage.Wasabi_Endpoint')</label>
                                            <input class="form-control" type="text"
                                                placeholder="Enter wasabi endpoint" name="WASABI_ENDPOINT"
                                                value="{{ @$data->WASABI_ENDPOINT }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="tp_seo_btn">
                                            <button type="submit" class="tp_btn" id="wasabi-form-btn"
                                               >@lang('master.storage.update')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('admin-theme/my_assets/js/setting.js') }}"></script>
    <script>
        $(document).ready(function(){
            formValidate('driver-form-setting');
            formValidate('aws-s3-form');
            formValidate('wasabi-form');
        });
    </script>
@endsection
