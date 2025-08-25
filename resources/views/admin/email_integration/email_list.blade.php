@extends('admin.layouts.app')
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <h4 class="tp_heading">Subscribed Emails</h4>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_table_box">
                        <div class="table-responsive">
                            <table class="table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Email</th>
                                        <th>Created At</th>
                                    </tr>
                                    <thead>
                                    <tbody>
                                        @if ($data->count() > 0)
                                            @foreach ($data as $key => $item)
                                                <tr id="table_row_{{ $item->id }}">
                                                    <td>{{ ++$key }}</td>
                                                    <td>{{ $item->email }}</td>
                                                    <td>{{ $item->created_at }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3">No Record Found.</td>
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
