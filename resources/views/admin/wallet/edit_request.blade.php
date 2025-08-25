@php $price_symbol = getSetting()->default_symbol ?? '$'; @endphp
@php $ASSET_URL = asset('admin-theme').'/'; @endphp
@extends('admin.layouts.app')
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li><a href="{{ route('admin.wallet.index') }}">User Wallet</a> </li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_catset_box tp_catset_singleuser">
                        <div role="tabpanel" class="tab-pane active" id="info">
                            <div class="th_content_section">

                                <div class="th_product_detail">
                                    <div class="theme_label">Id :</div>
                                    <div class="product_info product_name">{{ @$data->id }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">User Id :</div>
                                    <div class="product_info product_name">{{ @$data->user_id }}</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Name :</div>
                                    <div class="product_info product_name">{{ @$data->getUser->full_name }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Name :</div>
                                    <div class="product_info product_name">{{ @$data->getUser->full_name }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Email :</div>
                                    <div class="product_info product_name">{{ @$data->getUser->email }}</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Withdraw Amount :</div>
                                    <div class="product_info product_name">{{ $price_symbol . @$data->debit }}</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Date : </div>
                                    <div class="product_info">{{ @$data->created_at }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <h3 >Bank Details</h3>
                                </div>
                               

                                <div class="th_product_detail">
                                    <div class="theme_label">Account Holder Name :</div>
                                    <div class="product_info product_name">{{ @$user_details->account_holder_name }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Bank Name :</div>
                                    <div class="product_info product_name">{{ @$user_details->bank_name }}</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Bank Account Number :</div>
                                    <div class="product_info product_name">{{ @$user_details->bank_account_number }}</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">IFSC Code : </div>
                                    <div class="product_info">{{ @$user_details->ifsc_code }}</div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tp_tab_content ">
  
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_catset_box tp_catset_singleuser">
                        <form id="update-request-form" action="{{ route('admin.wallet.update_request') }}"
                            method="POST" enctype="multipart/form-data">
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
                                                    Paid</option>
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
                                <button type="submit" class="btn tp_btn"
                                    id="update-request-form-btn">Update</button>
                            </div>

                            <input name="id" value="{{$data->id}}" type="hidden">
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
