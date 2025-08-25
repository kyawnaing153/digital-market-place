@php  $ASSET_URL = asset('admin-theme').'/'; @endphp
@extends('author.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.product_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <h4 class="tp_heading">
                @if (isset($data->id))
                    Edit
                @else
                    Add
                @endif Products (Step 1)
            </h4>
            @if (isset($data->id) && !@empty($data->id))
                <div class="tp_form_wrapper ">
                    <ul>
                        <li class="active"><a href="{{ route('vendor.product.edit', ['id' => $data->id]) }}">Edit (Step 1)</a>
                        </li>
                        <li><a href="{{ route('vendor.product.edit.step2', ['id' => $data->id]) }}">Edit (Step 2)</a></li>
                    </ul>
                </div>
            @endif
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_catset_box_wrapper">
                        <div class="tp_catset_box tp_pro_step1">
                            <div class="alert alert-info">
                                <strong>Info!</strong> Fill in those details which you want, remember fields
                                with
                                (*) are mandatory. The empty fields will not show up to the user.
                            </div>
                            <form action="{{ route('vendor.product.store.step1') }}" id="product-first-step-form"
                                method="POST">
                                @csrf
                                <div class="row">

                                    <div class="col-lg-12 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Name<sup>*</sup></label>
                                            <input type="text" class="form-control generate-slug"
                                                placeholder="Enter Name" name="name" value="{{ @$data->name }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Choose a type<sup>*</sup></label>
                                            <div class="tp_custom_select tp_select_product">
                                                <select class="form-control" name="product_type">
                                                    <option selected value="">Choose</option>
                                                    @php $productType = ['AUDIO','Source Code','TEXT','OTHER'] @endphp
                                                    @foreach ($productType as $item)
                                                        <option value="{{ $item }}"
                                                            @if (@$data->product_type == $item) selected @endif>
                                                            {{ $item }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label id="product_type-error" class="error" for="product_type"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">URL Name (Slug)<sup>*</sup></label>
                                            <input type="text" class="form-control append-slug" name="slug"
                                                placeholder="Enter URL Name (Slug)" value="{{ @$data->slug }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper tp_pro_selectcat">
                                            <label class="mb-2">Product Category<sup>*</sup></label>
                                            <div class="tp_custom_select tp_select_product">
                                                <select class="form-select" aria-label="" name="category_id">
                                                    <option value="">Choose category</option>
                                                    @if (!empty($all_category))
                                                        @foreach ($all_category as $row)
                                                            <option value="{{ $row->id }}"
                                                                @if (@$data->category_id == $row->id) selected @endif>
                                                                {{ $row->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <label id="category_id-error" class="error" for="category_id"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Product Sub Category<sup>*</sup></label>
                                            <div class="tp_custom_select tp_select_product">
                                                <select class="form-select" name="sub_category_id">
                                                    <option value="">Choose sub category</option>
                                                    @if (!empty($sub_category))
                                                        @foreach ($sub_category as $row)
                                                            <option value="{{ $row->id }}"
                                                                @if (@$data->sub_category_id == $row->id) selected @endif>
                                                                {{ $row->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <label id="sub_category_id-error" class="error"
                                                    for="sub_category_id"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="tp_form_wrapper tp_form_textarea">
                                            <label class="mb-2">Short Description<sup>*</sup></label>
                                            <textarea rows="5" cols="50" spellcheck="true" class="form-textarea" placeholder="Enter Short Description"
                                                name="short_desc">{{ @$data->short_desc }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="tp_form_wrapper tp_form_textarea">
                                            <label class="mb-2">Tags<sup>*</sup></label>
                                            <textarea rows="5" cols="50" spellcheck="true" class="form-textarea" placeholder="Enter Tags" name="tags"
                                                placeholder="Separate each tag by comma (,)">{{ @$data->tags }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="tp_form_wrapper tp_form_mb">
                                            <label class="mb-2">Description<sup>*</sup></label>
                                            <textarea rows="8" spellcheck="true" class="form-textarea" placeholder="Enter Description" name="description"
                                                id="theme-editor" placefolder="Paste HTML content here">{{ @$data->description }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Is Active</label>
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="1" class="form-control"
                                                        name="is_active"
                                                        @if (@$data->is_active == 1) checked @endif><i
                                                        class="input-helper"></i>Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Live preview link<sup>*</sup></label>
                                            <input type="text" class="form-control"
                                                placeholder="Enter Live Preview Link" name="preview_link"
                                                placeholder="On ssl server non ssl link will not show in iframe"
                                                value="{{ @$data->preview_link }}">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                       <div class="tp_seo_head">
                                            <h5>Product Attributes</h5>
                                            <hr>
                                        </div>
                                        <div class="alert alert-info ">
                                            <p><b>Example:</b>
                                            <p>
                                            <p><b>Key : Value </b></p>
                                            <p><b>High Resolution</b> : Yes/No</p>
                                            <p><b>Compatible Browsers</b> : Firefox, Safari, Opera, Chrome, Edge, etc.
                                            </p>
                                            <p><b>Files Included</b> HTML, CSS, PHP, SQL, etc. </p>
                                            <p><b>Software Framework:</b> Laravel, Vue.js, React, etc. </p>
                                            <p><b>Software Version:</b> Versions of frameworks or platforms used.</p>
                                        </div>
                                        <div id="p-d-body">
                                            @if (@$data->product_details[0])
                                                @foreach (@$data->product_details as $key => $val)
                                                    <div class="row align-items-center child-items" id="p-field">
                                                        <div class="col-md-5">
                                                            <div class="tp_form_wrapper">
                                                                <label class="mb-2">Key</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter Key" name="product_key[]"
                                                                    value="{{ @$val['key'] }}" placeholder="Enter Key">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="tp_form_wrapper">
                                                                <label class="mb-2">Value</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Enter Value" name="product_value[]"
                                                                    value="{{ @$val['value'] }}"
                                                                    placeholder="Enter value">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="field-button add_btn tp_form_wrapper">
                                                                @if ($loop->first)
                                                                    <button type="button" id="add_more_product_detail"
                                                                        class="btn-sm btn-primary float-end mt-4"><i
                                                                            class="fa fa-plus"></i>
                                                                    </button>
                                                                @else
                                                                    <button type="button"
                                                                        class="btn-sm btn-danger float-end mt-4 remove-p-d"><i
                                                                            class="fa fa-trash"></i>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="row align-items-center child-items" id="p-field">
                                                    <div class="col-md-5">
                                                        <div class="tp_form_wrapper">
                                                            <label class="mb-2">Key</label>
                                                            <input type="text" class="form-control"
                                                                name="product_key[]" value=""
                                                                placeholder="Enter Key">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="tp_form_wrapper">
                                                            <label class="mb-2">Value</label>
                                                            <input type="text" class="form-control"
                                                                name="product_value[]" value=""
                                                                placeholder="Enter value">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="field-button tp_form_wrapper">
                                                            <button type="button" id="add_more_product_detail"
                                                                class="btn-sm btn-primary float-end mt-4"><i
                                                                    class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="tp_seo_head">
                                            <h5>SEO Points</h5>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Meta Title<sup>*</sup></label>
                                            <input type="text" class="form-control" placeholder="Enter Title"
                                                name="meta_title" value="{{ @$data->meta_title }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Meta keywords<sup>*</sup></label>
                                            <input type="text" class="form-control" placeholder="Enter keywords"
                                                name="meta_keywords" value="{{ @$data->meta_keywords }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="tp_form_wrapper">
                                            <label class="mb-2">Meta Description<sup>*</sup></label>
                                            <input type="text" class="form-control" placeholder="Enter description"
                                                name="meta_desc" value="{{ @$data->meta_desc }}">
                                        </div>
                                    </div>
                                    <input type="hidden" name="product_id" value="{{ @$data->id }}">
                                    @if (isset($data->id) && !@empty($data->id))
                                        <button id="product-first-step-form-btn" type="submit" class="tp_btn">Update
                                            (Step 1)</button>
                                    @else
                                        <button id="product-first-step-form-btn" type="submit" class="tp_btn">Add (Step
                                            1)</button>
                                    @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('admin-theme/my_assets/js/product_step_one.js') }}"></script>
@endsection
