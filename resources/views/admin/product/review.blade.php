@php  $ASSET_URL = asset('admin-theme').'/'; @endphp
@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.product_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li><a href="{{ route('admin.product.index') }}">Manage Product</a> </li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_table_box">
                        <div class="table-responsive">
                            <table id="example" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Rate</th>
                                        <th>Comment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data->count() > 0)
                                        @foreach ($data as $key => $item)
                                            <tr id="table_row_{{ $item->id }}">
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $item->getUser->full_name }}</td>
                                                <td>{{ @$item->rating }}</td>
                                                <td>{{ @$item->comment }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="text-center">
                                            <td colspan="4">No Review Found.</td>
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
@section('scripts')
@endsection
