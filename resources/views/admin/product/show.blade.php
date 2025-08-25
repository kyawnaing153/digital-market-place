@php $price_symbol = getSetting()->default_symbol ?? '$'; @endphp
@php $ASSET_URL = asset('admin-theme').'/'; @endphp
@extends('admin.layouts.app')
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li><a href="{{ route('admin.product.index') }}">Products</a> </li>
                <li class="active"><a href="#">Attached Files</a> </li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_catset_box tp_catset_singleuser">
                        <div role="tabpanel" class="tab-pane active" id="info">
                            <div class="th_content_section">
                                <div class="table-responsive">
                                    <table id="example" class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>File Name</th>
                                                <th>Link</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($productMeta->multi_file) && !empty($productMeta->multi_file))
                                                @php
                                                    $fileArr = unserialize($productMeta->multi_file);
                                                @endphp
                                                @foreach ($fileArr as $key => $value)
                                                    <tr>
                                                        <td>{{ ++$key }}</td>
                                                        <td>{{ $value['file_name'] }}</td>
                                                        <td>
                                                            @if (@$value['file_url'])
                                                                <a class="tp_btn"
                                                                    href="{{ route('admin.product.download', ['file_url' => @$value['file_url'], 'file_name' => $value['file_name']]) }}">
                                                                    Download
                                                                </a>
                                                            @else
                                                                <a class="tp_btn" target="_blank"
                                                                    href="{{ $value['file_external_url'] }}">
                                                                    Download
                                                                </a>
                                                            @endif
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7" class="text-center">No Record Found.</td>
                                                </tr>
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_catset_box tp_catset_singleuser">
                        <form id="update-product-status-form"
                            action="{{ route('admin.product.update_product_review_status') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                <div class="col-md-12 col-lg-12">
                                    <div class="tp_form_wrapper">
                                        <div class="col tp_form_wrapper">
                                            <label class="mb-2">Status</label>
                                            <select name="status" class="from-control">
                                                <option value="0" @if ($data->status == 0) selected @endif>
                                                    Pending</option>
                                                <option value="1" @if ($data->status == 1) selected @endif>
                                                    Accept</option>
                                                <option value="2" @if ($data->status == 2) selected @endif>
                                                    Review</option>
                                                <option value="3" @if ($data->status == 3) selected @endif>
                                                    Reject</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12">
                                    <div class="tp_form_wrapper">
                                        <div class="col tp_form_wrapper">
                                            <label class="mb-2">Note</label>
                                            <textarea class="form-textarea" rows="5" cols="50" spellcheck="false" name="note"
                                                placeholder="Enter note">{{ @$data->note }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <button class="btn tp_btn" id="update-product-status-form-btn">Update</button>
                            </div>
                            <input name="id" value="{{ $data->id }}" type="hidden">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('admin-theme/my_assets/js/form-validate.js') }}"></script>
@endsection
