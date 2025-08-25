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
                                    <div class="theme_label">Email :</div>
                                    <div class="product_info product_name">{{ @$data->getUser->email }}</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Type :</div>
                                    <div class="product_info product_name">{{ $data->type }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Credit :</div>
                                    <div class="product_info product_name">{{  $price_symbol. $data->credit ?? 0 }}
                                    </div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Debit :</div>
                                    <div class="product_info product_name">{{  $price_symbol . $data->debit ?? 0}}
                                    </div>
                                </div>
                        
                                <div class="th_product_detail">
                                    <div class="theme_label">Created Date : </div>
                                    <div class="product_info">{{ set_date_with_time(@$data->created_at) }}</div>
                                </div>
                                @if($data->type == "WITHDRAW")
                                    <div class="th_product_detail">
                                        <div class="theme_label">Status :</div>
                                        <div class="product_info product_name">{{ @$data->status_str}}
                                        </div>
                                    </div>
                                    <div class="th_product_detail">
                                        <div class="theme_label">Note :</div>
                                        <div class="product_info product_name">{{ @$data->note ?? '-'}}
                                        </div>
                                    </div>

                                    <div class="th_product_detail">
                                        <div class="theme_label">Updated Date : </div>
                                        <div class="product_info">{{ set_date_with_time(@$data->updated_at) }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
