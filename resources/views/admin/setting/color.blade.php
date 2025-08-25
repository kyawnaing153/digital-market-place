@php  $ASSET_URL = asset('admin-theme/assets').'/'; @endphp
@extends('admin.layouts.app')
@section('page_title', __('page_title.Admin.setting_title'))
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li><a href="#" class="setting-tab" data-target="s3-setting">@lang('master.Setting.Color')</a></li>
        </div>
        <div class="tp_tab_content">
            <div class="row">

                <!-- color Settings -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="setting-tab-tar active" id="s3-setting">
                        <form id="color-form" action="{{ route('admin.setting.updateSettings') }}" method="POST">
                            @csrf
                            <div class="tp_catset_box">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper colorpicker-wrapper">
                                            <label class="mb-2">@lang('master.Setting.primary_color') (#3480e5)</label>
                                            <div class="colorpicker-fields">
                                                <input class=" pickerinput form-control" type="text" name="primary_color"
                                                    value="{{ @$data->primary_color }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper colorpicker-wrapper">
                                            <label class="mb-2">@lang('master.Setting.Secondary_Color') (#585C66)</label>
                                            <div class="colorpicker-fields">
                                                <input class="pickerinput form-control" type="text"
                                                    name="secondary_color" value="{{ @$data->secondary_color }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper colorpicker-wrapper">
                                            <label class="mb-2">@lang('master.Setting.Text_Color')(#53627a)</label>
                                            <div class="colorpicker-fields">
                                                <input class="pickerinput form-control" type="text" name="text_color"
                                                    value="{{ @$data->text_color }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper colorpicker-wrapper">
                                            <label class="mb-2">@lang('master.Setting.Body_Color')(#eff5fc)</label>
                                            <div class="colorpicker-fields">
                                                <input class="pickerinput form-control" type="text" name="body_color"
                                                    value="{{ @$data->body_color }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="tp_seo_btn">
                                            <button type="submit" class="tp_btn"
                                                id="color-form-btn">@lang('master.storage.update')</button>
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
        $(document).ready(function() {
            formValidate('color-form');
        });
    </script>

@endsection
