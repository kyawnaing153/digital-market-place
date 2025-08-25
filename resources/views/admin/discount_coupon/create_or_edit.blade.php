@php $ASSET_URL = asset('admin-theme').'/'; @endphp
@extends('admin.layouts.app')
@section('head_scripts')
    {{-- Add/Edit Coupons from --}}
    <title>@lang('page_title.Admin.discount_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li class="active"><a href="{{ route('admin.discount_coupon.create') }}">Add Coupons</a></li>
                <li><a href="{{ route('admin.discount_coupon.index') }}">Manage Coupons</a> </li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form id="coupon-discount" action="{{ route('admin.discount_coupon.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="tp_catset_box">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Coupon Name<sup>*</sup></label>
                                        <input type="text" class="form-control" name="coupon_name" id="coupon_name"
                                            placeholder="Enter coupon name" value="{{ @$data->coupon_name }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Coupon Code<sup>*</sup></label>
                                        <input type="text" class="form-control" name="coupon_code" id="coupon_code"
                                            placeholder="Enter coupon code" value="{{ @$data->coupon_code }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Coupon Amount<sup>*</sup></label>
                                        <input type="number" class="form-control" name="coupon_amount" id="coupon_amount"
                                            placeholder="Enter coupon amount" value="{{ @$data->coupon_amount }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Coupon Type<sup>*</sup></label>
                                        <div class="tp_custom_select">
                                            <select class="form-select" name="coupon_type">
                                                <option value="">Choose Type</option>
                                                <option value="0"{{ @$data->coupon_type == '0' ? 'selected' : '' }}>
                                                    Flat
                                                </option>
                                                <option value="1"{{ @$data->coupon_type == '1' ? 'selected' : '' }}>
                                                    Percentage (%)
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Coupon Description</label>
                                        <textarea class="form-textarea" rows="5" cols="50" spellcheck="false" name="coupon_description"
                                            id="coupon_description" placeholder="Enter description">{{ @$data->coupon_description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Choose Product</label>
                                        <div class="tp_custom_select tp_custom_multiselect">
                                            <select class="form-select multiselect" name="product_id[]" id="multiple-select"
                                                multiple="multiple">
                                                <option value="" disabled>Choose Products</option>
                                                @php $productids = (isset($data->product_id) && !empty(@$data->product_id)) ? json_decode(@$data->product_id) : []; @endphp
                                                @foreach ($product as $item)
                                                    <option value="{{ @$item->id }}"
                                                        @if (in_array($item->id, $productids)) selected @endif>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="tp_inputnote">Downloads this discount can only be applied to. Leave
                                                blank for any.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Choose Product</label>
                                        <div class="tp_custom_select tp_custom_multiselect">
                                            <select class="form-select multiselect" name="cannot_applied_product_id[]"
                                                multiple="multiple">
                                                <option value="" disabled>Choose Products</option>
                                                @php $productids = (isset($data->cannot_applied_product_id) && !empty(@$data->cannot_applied_product_id)) ? json_decode(@$data->cannot_applied_product_id) : []; @endphp
                                                @foreach ($product as $item)
                                                    <option value="{{ @$item->id }}"
                                                        @if (in_array($item->id, $productids)) selected @endif>
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="tp_inputnote">Downloads this discount cannot be applied to. Leave
                                                blank for none.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Start Date</label>
                                        <input type="datetime-local" class="form-control" name="start_date" id="start_date"
                                            placeholder="DD/MM/YYYY" value="{{ @$data->start_date }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">End Date</label>
                                        <input type="datetime-local" class="form-control" name="end_date" id="end_date"
                                            placeholder="DD/MM/YYYY" value="{{ @$data->end_date }}">
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <p class="text-left tp_ortext">(OR)</p>

                                    {{-- <div class="row"> --}}
                                    {{-- <div class="col-md-12"> --}}
                                    <div class="tp_form_wrapper tp_checkmb">
                                        <div class="checkbox">
                                            <input type="hidden" name="is_lifetime" value="0">
                                            <label>
                                                <input type="checkbox" name="is_lifetime" value="1"
                                                    class="form-control"
                                                    @if (@$data->is_lifetime == 1) checked @endif><i
                                                    class="input-helper mr-2"></i>Check / Uncheck to Life Time Coupon
                                                Duration.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <div class="checkbox">
                                            <input type="hidden" name="is_once_per_user" value="0">
                                            <label><input type="checkbox" name="is_once_per_user" value="1"
                                                    class="form-control"
                                                    @if (@$data->is_once_per_user == 1) checked @endif><i
                                                    class="input-helper"></i>Use Once Per User.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Minimum Amount</label>
                                        <input type="number" class="form-control" name="min_amount" id="min_amount"
                                            placeholder="Enter Minimum Amount" value="{{ @$data->min_amount }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="tp_form_wrapper">
                                        <label class="mb-2">Max Uses</label>
                                        <input type="number" class="form-control" name="max_uses" id="max_uses"
                                            placeholder="Enter Max Uses" value="{{ @$data->max_uses }}">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="tp_addcoupon_btn">
                                        <button type="submit" class="tp_btn" id="coupon-discount-btn">Add Discount
                                            Code</button>
                                    </div>

                                    <input type="hidden" value="{{ @$data->id }}" name="id">
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
