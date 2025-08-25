@php  $ASSET_URL = asset('admin-theme/assets').'/'; @endphp
@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.setting_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <h4 class="tp_heading">Menus</h4>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form id="menu-form" action="{{ route('admin.setting.store') }}" method="POST">
                        <div class="tp_catset_box">
                            <div class="alert alert-info">
                                <strong>Info!</strong> Yes / No to make the frontend menu visible or not.
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Home</label>
                                        <input type="hidden" name="is_check_home"value="0">
                                        <div class="condition-toggle">
                                            <input id="check-active" type="checkbox" name="is_check_home"
                                                value="1" {{ @$data->is_check_home == 1 ? 'checked' : '' }}>
                                            <label for="check-active">
                                                <div class="condition-toggle-switch" data-checked="Yes" data-unchecked="No">
                                                </div>
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">About Us</label>
                                        <input type="hidden" name="is_check_about"value="0">
                                        <div class="condition-toggle">
                                            <input id="check-active-2" type="checkbox" name="is_check_about" value="1"
                                                {{ @$data->is_check_about == 1 ? 'checked' : '' }}>
                                            <label for="check-active-2">
                                                <div class="condition-toggle-switch" data-checked="Yes" data-unchecked="No">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Products</label>
                                        <input type="hidden" name="is_check_product" value="0">
                                        <div class="condition-toggle">
                                            <input id="check-active-3" type="checkbox" name="is_check_product"
                                                value="1" {{ @$data->is_check_product == 1 ? 'checked' : '' }}>
                                            <label for="check-active-3">
                                                <div class="condition-toggle-switch" data-checked="Yes" data-unchecked="No">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Contact Us</label>
                                        <input type="hidden" name="is_check_contact"value="0">
                                        <div class="condition-toggle">
                                            <input id="check-active-4" type="checkbox" name="is_check_contact"
                                                value="1" {{ @$data->is_check_contact == 1 ? 'checked' : '' }}>
                                            <label for="check-active-4">
                                                <div class="condition-toggle-switch" data-checked="Yes" data-unchecked="No">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Terms & Conditions</label>
                                        <input type="hidden" name="is_check_terms_and_condition"value="0">
                                        <div class="condition-toggle">
                                            <input id="check-active-5" type="checkbox" name="is_check_terms_and_condition"
                                                value="1" {{ @$data->is_check_terms_and_condition == 1 ? 'checked' : '' }}>
                                            <label for="check-active-5">
                                                <div class="condition-toggle-switch" data-checked="Yes" data-unchecked="No">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Privacy Policy</label>
                                        <input type="hidden" name="is_check_privacy_policy"value="0">
                                        <div class="condition-toggle">
                                            <input id="check-active-6" type="checkbox" name="is_check_privacy_policy"
                                                value="1" {{ @$data->is_check_privacy_policy == 1 ? 'checked' : '' }}>
                                            <label for="check-active-6">
                                                <div class="condition-toggle-switch" data-checked="Yes"
                                                    data-unchecked="No">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Language</label>
                                        <input type="hidden" name="is_check_language" value="0">
                                        <div class="condition-toggle">
                                            <input id="check-active-7" type="checkbox" name="is_check_language"
                                                value="1" {{ @$data->is_check_language == 1 ? 'checked' : '' }}>
                                            <label for="check-active-7">
                                                <div class="condition-toggle-switch" data-checked="Yes"
                                                    data-unchecked="No">
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="tp_btn" id="menu-form-btn">update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
    @section('scripts')
        <script src="{{ asset('admin-theme/my_assets/js/setting.js') }}"></script>
    @endsection
