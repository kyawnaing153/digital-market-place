@php
    $ASSET_URL = asset('admin-theme/assets') . '/';
    $price_symbol = getSetting()->default_symbol ?? '$';
@endphp
@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.wallet_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <h4 class="tp_heading">Users Wallet History</h4>
        </div>

        <div class="tp_tab_content">
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
                                        <th>Vendor Name</th>
                                        <th>Vendor Email</th>
                                        <th>Type</th>
                                        <th>Credit</th>
                                        <th>Debit</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data->count() > 0)
                                        @foreach ($data as $key => $item)
                                            <tr id="table_row_{{ $item->id }}">
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $item->getUser->full_name }}</td>
                                                <td>{{ $item->getUser->email }}</td>
                                                <td>{{ $item->type }}</td>
                                                <td>{{ $price_symbol . @$item->credit }}</td>
                                                <td>{{ $price_symbol . $item->debit }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>
                                                    <ul>
                                                        <li><a href="{{ route('admin.wallet.show', $item->id) }}"
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
