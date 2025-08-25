@extends('admin.layouts.app')
@section('head_scripts')
<title>@lang('page_title.Admin.home_content_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li class="active"><a href="{{ route('admin.home_content.create') }}">Add Content</a></li>
                <li><a href="{{ route('admin.home_content.index') }}">Home Content Manage</a></li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form id="why-choose-us-form" action="{{ route('admin.home_content.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="tp_catset_box">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Image<sup>*</sup></label>
                                <input type="file" class="form-control" name="image" size="20" id="banner_image"
                                    value="{{ @$data->image }}">
                                @if (isset($data->image))
                                    <input class="form-control" type="hidden" name="image" value="{{ @$data->image }}">
                                    <div class="tp_form_wrapper mt-2">
                                        <img src="{{ $data->image }}">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Heading<sup>*</sup></label>
                                <input type="text" class="form-control" name="heading" id="heading"
                                    placeholder="Enter Heading" value="{{ @$data->heading }}">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Sub Heading<sup>*</sup></label>
                                <input type="text" class="form-control" name="sub_heading" id="sub_heading"
                                    placeholder="Enter Sub Heading" value="{{ @$data->sub_heading }}">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Type<sup>*</sup></label>
                                <div class="tp_custom_select">
                                    <select class="form-select" name="type">
                                        <option value="">Select Type</option>
                                        <option value="StartSection" @if (@$data->type == 'StartSection') selected @endif>Start
                                            Section</option>
                                        <option value="WhyChooseSection" @if (@$data->type == 'WhyChooseSection') selected @endif>
                                            Why Choose Section
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="tp_homecontent_btn">
                                <button type="submit" class="tp_btn" id="why-choose-us-form-btn" >Add</button>
                            </div>
                            <input type="hidden" value="{{ @$data->id }}" name="id" id="resource_id">
                        </div>
                    </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="{{ asset('admin-theme/my_assets/js/form-validate.js') }}"></script>
@endsection
