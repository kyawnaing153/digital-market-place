@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.product_sub_category_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li><a href="{{ route('admin.subcategory.create') }}">Add Sub Category</a></li>
                <li class="active"><a href="{{ route('admin.subcategory.index') }}">Manage Sub Categories</a></li>
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
                                        <th>Sub Category Name</th>
                                        <th>Category</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data->count() > 0)
                                        @foreach ($data as $key => $item)
                                            <tr id="table_row_{{ $item->id }}">
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ @$item->getCategory->name }}</td>
                                                <td>
                                                    <ul>
                                                        <li>
                                                            <a href="{{ route('admin.subcategory.edit', $item->id) }}"
                                                                class="tp_edit tp_tooltip" title="Edit">
                                                                <i class="fa fa-pencil" aria-hidden="true">
                                                                </i>
                                                                <span class="tp_tooltiptext">
                                                                    <p>Edit</p>
                                                                </span>
                                                            </a>
                                                        </li>
                                                        <li><a href="#" class="tp_delete tp_tooltip" title="Delete"
                                                                onclick="delete_single_details('{{ route('admin.subcategory.destroy', $item->id) }}',{{ $item->id }})"><i
                                                                    class="fa fa-trash" aria-hidden="true"></i>
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
