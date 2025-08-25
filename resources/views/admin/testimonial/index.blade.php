@extends('admin.layouts.app')
@section('head_scripts')
<title>@lang('page_title.Admin.testimonial_page_title')</title>
@endsection
@section('content')
<div class="tp_main_content_wrappo">
    <div class="tp_tab_wrappo">
        <ul>
            <li><a href="{{ route('admin.testimonial.create') }}">Add Testimonial</a></li>
            <li class="active"><a href="{{ route('admin.testimonial.index') }}">Manage Testimonial</a></li>
        </ul>
    </div>
    <div class="tp_tab_content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="tp_table_box tp_table_testimonial">
                    <div class="table-responsive">
                        <table id="example" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Show Designation</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($data->count() > 0)
                                    @foreach ($data as $key => $item)
                                        <tr id="table_row_{{ $item->id }}">
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->designation }}</td>
                                            <td>{{ $item->is_checked_designation == 1 ? 'YES' : 'NO' }} </td>
                                            <td>{{ $item->message }} </td>
                                            <td>
                                                <div class="tp_autoresponder">
                                                    <label class="tp_toggle_label">
                                                        <input id="active_btn_{{ $item->id }}" type="checkbox"
                                                            name="cate_status" value="1"
                                                            onclick="update_single_status('{{ route('testimonial.update', $item->id) }}','{{ $item->is_active }}','{{ 'active_btn_' . $item->id }}')"
                                                            @if ($item->is_active == 1) checked @endif>
                                                        <div class="tp_user_check">
                                                            <span></span>
                                                        </div>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li><a href="{{ route('admin.testimonial.edit', $item->id) }}"
                                                            class="tp_edit tp_tooltip" title="Edit"><i class="fa fa-pencil"
                                                                aria-hidden="true"></i>
                                                                <span class="tp_tooltiptext">
                                                                    <p>Edit</p>
                                                                </span>
                                                            </a></li>
                                                    <li><a href="#" class="tp_delete tp_tooltip" title="Delete"
                                                            onclick="delete_single_details('{{ route('admin.testimonial.destroy', $item->id) }}',{{ $item->id }})"><i
                                                                class="fa fa-trash" aria-hidden="true"></i>
                                                                <span class="tp_tooltiptext">
                                                                    <p>Delete</p>
                                                                </span>
                                                            </a></li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="text-center">
                                        <td colspan="7">No Record Found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection