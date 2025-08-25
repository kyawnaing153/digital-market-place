@extends('admin.layouts.app')
@section('head_scripts')
<title>@lang('page_title.Admin.advertise_title')</title>
@endsection
{{-- list of Advertise --}}
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li class="active"><a href="{{ route('admin.advertise.index') }}">Advertise Manage</a></li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_table_box tp_table_advertise">
                        <div class="table-responsive">
                            <table id="example" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Advertise Name</th>
                                        <th>Page Name</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data->count() > 0)
                                        @foreach ($data as $key => $item)
                                            <tr id="table_row_{{ $item->id }}">
                                                <td>{{ ++$key }}</td>
                                                <td><img src="{{ $item->image }}" width="200px" height="auto"></td>
                                                <td>{{ $item->heading }}</td>
                                                <td>{{ $item->page_name }}</td>
                                                <td>{{ $item->type }}</td>
                                                <td>
                                                    <div class="tp_autoresponder">
                                                        <label class="tp_toggle_label">
                                                            <input id="active_btn_{{ $item->id }}" type="checkbox"
                                                                name="cate_status" value="1"
                                                                onclick="update_single_status('{{ route('admin.home_content.update', $item->id) }}','{{ $item->is_active }}','{{ 'active_btn_' . $item->id }}')"
                                                                @if ($item->is_active == 1) checked @endif>
                                                            <div class="tp_user_check">
                                                                <span></span>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </td>
                                            <td>
                                                <ul>
                                                    <li>
                                                <a href="{{ route('admin.advertise.edit', $item->id) }}"
                                                    class="tp_edit tp_tooltip" title="Edit"><i
                                                        class="fa fa-pencil" aria-hidden="true"></i><span
                                                        class="tp_tooltiptext">
                                                        <p>Edit</p>
                                                    </span></a>
                                                </li>
                                                <ul>
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