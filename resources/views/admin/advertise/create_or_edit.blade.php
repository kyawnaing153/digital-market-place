@extends('admin.layouts.app')
@section('head_scripts')
<title>@lang('page_title.Admin.advertise_title')</title>
@endsection
@section('content')
{{-- Add edit of Advertise --}}
<div class="tp_main_content_wrappo">
 <div class="tp_tab_wrappo">
        <ul>
           <li class="active"><a href="#">Edit Banner</a></li>
            <li><a href="{{route('admin.advertise.index')}}">Manage Banner</a></li>
        </ul>
    </div>
     <div class="tp_tab_content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form id="banner-form" action="{{ route('admin.advertise.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="tp_catset_box">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                        <div class="tp_form_wrapper">
                            <label class="mb-2">Image </label>
                            <input type="file" class="form-control" name="image" size="20" id="banner_image"
                                value="{{ @$data->image }}">
                            @if (@$data->image)
                                <input class="form-control" type="hidden" name="image" value="{{ @$data->image }}">
                                <div class="tp_form_wrapper mt-2">
                                    <img src="{{ @$data->image }}">
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="tp_form_wrapper">
                            <label class="mb-2">Link<sup>*</sup></label>
                            <input type="text" class="form-control" name="link"  id="link" placeholder="Enter the link" value="{{ @$data->link }}">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12"> 
                        <div class="tp_form_wrapper">
                            <label class="mb-2">Advertise Name</label>
                            <input type="text" class=" form-control" name="heading"
                                placeholder="Enter the Advertise Name" value="{{@$data->heading }}">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="tp_form_wrapper">
                            <label class="mb-2">Page View</label>
                            <div class="tp_custom_select">
                                <select class="form-select" name="page_name">
                                    <option value="" disabled>Page View</option>
                                    <option value="SearchPage" @if (@$data->page_name == 'SearchPage') selected @endif>Search Page</option>
                                    <option value="SingleProductPage" @if (@$data->page_name == 'SingleProductPage') selected @endif>
                                        Single Product Page
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <input type="hidden" value="{{ @$data->id }}" name="id">
                        <input type="hidden" value="Advertisement" name="type">
                        <div class="mt-2">
                            <button type="submit" class="tp_btn" id="banner-form-btn">Add</button>
                        </div>
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
