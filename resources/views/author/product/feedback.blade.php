@extends('author.layouts.app')
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li><a href="{{ route('vendor.product.index') }}">Products List</a> </li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_catset_box tp_catset_singleuser">
                        <div role="tabpanel" class="tab-pane active" id="info">
                            <div class="th_content_section">

                                <div class="th_product_detail">
                                    <div class="theme_label">Status :</div>
                                    <div class="product_info product_name">{{ @$data->status_str }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Note :</div>
                                    <div class="product_info product_name">{!! @$data->note ?? 'NA' !!}</div>
                                </div>
                    
                                <div class="th_product_detail">
                                    <div class="theme_label">Last Modified : </div>
                                    <div class="product_info">{{ !empty(@$data->last_modified) ? set_date_with_time(@$data->last_modified) : 'Pending'; }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
