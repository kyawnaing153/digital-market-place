@php
$ASSET_URL = asset('admin-theme/assets') . '/';
$price_symbol = getSetting()->default_symbol ?? '$'; 
@endphp
@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.order_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <h4 class="tp_heading">Transactions</h4>
        </div>

        <div class="tp_tab_content">
            <div class="tp_shortinfo tp_transaction_box mb-30">
                <ul>
                    <li>
                        <div class="tp_infobox fine">
                            <div class="tp_infobox_img">
                                <img src="{{ $ASSET_URL }}images/today-revenue.svg" alt="today-revenue">
                            </div>
                            <div class="tp_infobox_content">
                                <p>Today's Revenue</p>
                                <h3 class="tp_orangedark_color">{{ @$price_symbol . @$today_revenue }}</h3>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="tp_infobox progres">
                        <div class="tp_infobox_img">
                        <img src="{{ $ASSET_URL }}images/weekly-revenue.svg" alt="weekly-revenue">
                            </div>
                        <div class="tp_infobox_content">
                            <p>Weekly Revenue</p>
                            <h3 class="tp_orangedark_color">{{ @$price_symbol . @$weekly_revenue }}</h3>
                        </div>
                        </div>
                    </li>
                    <li>
                        <div class="tp_infobox primary">
                        <div class="tp_infobox_img">
                        <img src="{{ $ASSET_URL }}images/monthly-revenue.svg" alt="monthly-revenue">
                            </div>
                        <div class="tp_infobox_content">
                        <p>Monthly Revenue</p>
                            <h3 class="tp_orangedark_color">{{ @$price_symbol .@$monthly_revenue }}</h3>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="tp_infobox success">
                        <div class="tp_infobox_img">
                        <img src="{{ $ASSET_URL }}images/total-revenue.svg" alt="total-revenue">
                            </div>
                            <div class="tp_infobox_content">
                            <p>Total Revenue</p>
                                <h3 class="tp_orangedark_color">{{@$price_symbol . @$total_revenue }}</h3>
                            </div>
                        </div>
                    </li>
                    </ul>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_table_box">
                        <div class="tp_product_head_search tp_transaction_order">
                            @include('admin.common.filters')
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer</th>
                                        <th>Gateway</th>
                                        <th>Total</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data->count() > 0)
                                        @foreach ($data as $key => $item)
                                            <tr id="table_row_{{ $item->id }}">
                                                <td>{{ $item->id }}</td>
                                                <td>{{ @$item->getUser->full_name }}</td>
                                                <td>{{ $item->payment_gateway ?? 'NA' }}</td>
                                                <td>{{ $price_symbol . $item->billing_total }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>
                                                    {{ $item->status_str }}
                                                </td>
                                                <td>
                                                    <ul>
                                                        <li><a href="{{ route('admin.order.show', $item->id) }}"
                                                                class="tp_view tp_tooltip" title="View">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                                <span class="tp_tooltiptext">
                                                                    <p>View</p>
                                                                </span>
                                                            </a>
                                                        </li>
                                                    </ul>
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
                            <div class="tp-pagination-wrapper">
                                {{ @$data->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
