@php $price_symbol = getSetting()->default_symbol ?? '$'; @endphp
@php $ASSET_URL = asset('admin-theme').'/'; @endphp
@extends('author.layouts.app')
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li><a href="{{ route('vendor.order.index') }}">Sales List</a> </li>
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
                                    <div class="theme_label">Customer :</div>
                                    <div class="product_info product_name">{{ @$data->getOrder->getUser->full_name }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Customer Email :</div>
                                    <div class="product_info product_name">{{ @$data->getOrder->getUser->email }}</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Product Id :</div>
                                    <div class="product_info product_name">{{ @$data->product_id }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Product:</div>
                                    <div class="product_info product_name">{{ @$data->getSingleProduct->name ?? 'NA' }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Price :</div>
                                    <div class="product_info product_name">{{ $price_symbol . @$data->price }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Admin Commission :</div>
                                    <div class="product_info product_name">{{ $price_symbol . @$data->admin_commission }}
                                    </div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Your Amount :</div>
                                    <div class="product_info product_name">{{ $price_symbol . @$data->vendor_amount ?? 0 }}
                                    </div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Commission Rate :</div>
                                    <div class="product_info product_name">{{ @$data->commission_rate }} @if (getSetting()->commission_type == 0) % @else Flat @endif
                                    </div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Date : </div>
                                    <div class="product_info">{{ set_date_with_time(@$data->created_at) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
