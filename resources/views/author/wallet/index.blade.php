@php
    $ASSET_URL = asset('admin-theme/assets') . '/';
    $price_symbol = getSetting()->default_symbol ?? '$';
    $min_withdraw = getSetting()->min_withdraw ?? 0;
@endphp
@extends('author.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.wallet_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <h4 class="tp_heading">Wallet History</h4>
        </div>

        <div class="tp_tab_content">
            <div class="tp_shortinfo tp_transaction_box tp_trans_wallet mb-30">
                <ul>
                    <li>
                        <div class="tp_infobox fine">
                            <div class="tp_infobox_img">
                                <img src="{{ $ASSET_URL }}images/wallet.svg" alt="wallet">
                            </div>
                            <div class="tp_infobox_content">
                                <p>Available Balance</p>
                                <h3 class="tp_orangedark_color">{{ @$price_symbol . (@$total_amount ?? 0) }}</h3>
                                
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="tp_infobox danger">
                            <div class="tp_infobox_img">
                                <img src="{{ $ASSET_URL }}images/withdrawal.svg" alt="withdrawal">
                            </div>
                            <div class="tp_infobox_content">
                                <p>Withdraw Amount</p>
                                <h3 class="tp_orangedark_color">{{ @$price_symbol . (@$withdraw_amount ?? 0) }}</h3>
                                
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="tp_prohead_btn">
                    <button class="tp_btn" data-bs-toggle="modal" data-bs-target="#withdraw_modal">
                        Withdraw</button>
                </div>
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
                                        <th>Type</th>
                                        <th>Credit</th>
                                        <th>Debit</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data->count() > 0)
                                        @foreach ($data as $key => $item)
                                            <tr id="table_row_{{ $item->id }}">
                                                <td>{{ ++$key }}</td>
                                                <td>
                                                    @if($item->type == "WITHDRAW")  
                                                    <span class="text-danger"> {{$item->type}} <span>
                                                    @else
                                                    <span class="text-success"> {{$item->type}} <span>
                                                    @endif
                                                </td>
                                                <td>{{ $price_symbol .  @$item->credit }}</td>
                                                <td>{{ $price_symbol . $item->debit }}</td>
                                                
                                                <td>{{ $item->created_at }}</td>
                                                <td>{{ ($item->type == "WITHDRAW") ? $item->status_str : 'Credited'}}</td>
                                                <td>
                                                    <ul>
                                                        <li><a href="{{ route('vendor.wallet.show', $item->id) }}"
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

    {{-- Connect Model Form --}}
    <div class="modal fade theme_modal" id="withdraw_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content tp_email_integrations">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Withdraw Funds</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="add_user_form">
                        <!-- Sendiio -->
                        <form action="{{ route('vendor.wallet.store') }}"
                            method="post"  id="withdraw-form">
                            <div class="form-group">
                                <label class="ap_label">Available Balance</label>
                                {{ $price_symbol . (@$total_amount ?? 0) }}
                            </div>

                            <div class="form-group">
                                <label class="ap_label">Enter Amount </label>
                                <input type="text" name="amount"
                                    placeholder="Enter amount  Min. {{ $price_symbol. $min_withdraw}}" class="form-control">
                            </div>
                          
                            <div class="mt-2">
                                <button type="submit" class="tp_btn"
                                     id="withdraw-form-btn" onclick="withdrawValidation('withdraw-form',{{$min_withdraw }},{{$total_amount ?? 0 }})">Continue to Withdraw</button>
                            </div>
                            <input type="hidden" name="form" value="sendiio">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Connect Model Form End --}}
@endsection
@section('scripts')
<script src="{{ asset('admin-theme/my_assets/js/form-validate.js') }}"></script>
@endsection
