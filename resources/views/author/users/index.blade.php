@extends('author.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.user_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li class="active"><a href="{{ route('vendor.users.index') }}">Customer List</a> </li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_table_box">
                        <div class="tp_product_head_search">
                            @include('admin.common.filters')
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if ($data->count() > 0)
                                        @foreach ($data as $key => $item)
                                            <tr id="table_row_{{ $item->id }}">
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $item->full_name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>
                                                    <ul>
                                                        <li><a href="{{ route('vendor.users.show', $item->id) }}"
                                                                class="tp_view tp_tooltip" title="View"><i
                                                                    class="fa fa-eye" aria-hidden="true"></i>
                                                                <span class="tp_tooltiptext">
                                                                    <p>View</p>
                                                                </span>
                                                            </a></li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="text-center">
                                            <td colspan="5">No Record Found.</td>
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
