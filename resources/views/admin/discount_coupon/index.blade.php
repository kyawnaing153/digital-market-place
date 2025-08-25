@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.discount_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li><a href="{{ route('admin.discount_coupon.create') }}">Add Coupons</a></li>
                <li class="active"><a href="{{ route('admin.discount_coupon.index') }}">Manage Coupons</a> </li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_table_box tp_table_coupon">
                        <div class="tp_product_head_search">
                            @include('admin.common.filters')
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Amount</th>
                                        <th>Expire</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if ($data->count() > 0)
                                        @foreach ($data as $key => $item)
                                            <tr id="table_row_{{ $item->id }}">
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $item->coupon_name }}</td>
                                                <td>{{ $item->coupon_code }}</td>
                                                <td>{{ $item->coupon_amount }}
                                                    {{ $item->coupon_type == 1 ? '%' : 'FLAT' }} </td>
                                                <td>{{ $item->is_lifetime == 1 ? 'LIFETIME' : set_date_with_time($item->end_date) }}
                                                </td>
                                                <td>
                                                    <div class="tp_autoresponder">
                                                        <label class="tp_toggle_label">
                                                            <input id="active_btn_{{ $item->id }}" type="checkbox"
                                                                name="cate_status" value="1"
                                                                onclick="update_single_status('{{ route('discount-coupons.update', $item->id) }}','{{ $item->is_active }}','{{ 'active_btn_' . $item->id }}')"
                                                                @if ($item->is_active == 1) checked @endif>
                                                            <div class="tp_user_check">
                                                                <span></span>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>{{ set_date_with_time($item->created_at) }}</td>
                                                <td>
                                                    <ul>
                                                        <li>
                                                            <a href="{{ route('admin.discount_coupon.edit', $item->id) }}"
                                                                class="tp_edit tp_tooltip" title="Edit"><i
                                                                    class="fa fa-pencil" aria-hidden="true"></i>
                                                                <span class="tp_tooltiptext">
                                                                    <p>Edit</p>
                                                                </span>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="tp_delete tp_tooltip" title="Delete"
                                                                onclick="delete_single_details('{{ route('admin.discount_coupon.destroy', $item->id) }}','{{ $item->id }}')">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                                <span class="tp_tooltiptext">
                                                                    <p>Delete</p>
                                                                </span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="text-center">
                                            <td colspan="8">No Record Found.</td>
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
