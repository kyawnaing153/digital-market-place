@extends('admin.layouts.app')
@section('head_scripts')
<title>@lang('page_title.Admin.langugage_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li class="active"><a href="{{ route('admin.lang.create') }}">Add Language</a></li>
                <li><a href="{{ route('admin.lang.index') }}">Manage Language</a></li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form id="add-language-form" action="{{ route('admin.lang.store') }}" method="POST">
                        @csrf
                        <div class="tp_catset_box tp_select_lang">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Add new language<sup>*</sup></label>
                                <input class="form-control" type="text" class="form-control" name="name"
                                    value="{{ @$data->name }}" placeholder="Enter Language ex. english ">
                            </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Short Name<sup>*</sup></label>
                                <input class="form-control" type="text" class="form-control" name="short_name"
                                    value="{{ @$data->short_name }}" placeholder="Enter short name ex. en">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <button type="submit" class="tp_btn mt-2"
                                onclick="languageformValidate('add-language-form')" id="add-language-form-btn">Add</button>
                            <input class="form-control" type="hidden" class="form-control" name="id"
                                value="{{ @$data->id }}">
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
