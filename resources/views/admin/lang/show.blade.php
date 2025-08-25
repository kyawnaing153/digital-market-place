@extends('admin.layouts.app')
@section('head_scripts')
<title>@lang('page_title.Admin.langugage_title')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li class="active"><a type="button" class="lang-tab" data-target="forntend-lang">Frontend</a></li>
                <li><a type="button" class="lang-tab" data-target="message-lang">Admin Messages</a></li>
                <li><a type="button" class="lang-tab" data-target="fnt-message-lang">Frontend Messages</a></li>
                <li><a type="button" class="lang-tab" data-target="page-title-lang">Page title</a></li>

            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 lang-tab-tar active" id="forntend-lang">
                    <div class="tp_table_box">
                        <div class="table-responsive">
                            <table id="example" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form id="master-form" action="{{ route('admin.lang.store_master_file') }}"
                                        method="POST">
                                        @csrf
                                        @foreach ($master as $k => $v)
                                            <tr>
                                                <td>
                                                    <b>{{ strtoupper(str_replace('_', ' ', $k)) }}</b>
                                                </td>
                                            </tr>
                                            @foreach ($v as $key => $val)
                                                <tr>
                                                    <td><input type="text" class="form-control"
                                                            name="{{ $k }}[{{ $key }}]"
                                                            value="{{ $val }}"></td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                        <tr>
                                            <td>
                                                <div class="mt-2">
                                                    <button type="submit" class="tp_btn"
                                                        onclick="languagefileformValidate('master-form')" id="master-form-btn">Update</button>
                                                </div>
                                            </td>
                                        </tr>
                                        <input type="hidden" name="lang" value="{{ @$lang }}">     
                                    </form>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 lang-tab-tar" id="message-lang">
                    <div class="tp_table_box">
                        <div class="table-responsive">
                            <table id="example" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form id="message-form" action="{{ route('admin.lang.store_message_file') }}"
                                        method="POST">
                                        @csrf
                                        @foreach ($message as $key => $val)
                                            <tr>
                                                <td><input type="text" class="form-control" name="{{ $key }}"
                                                        value="{{ $val }}"></td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td>
                                                <div class="mt-2">
                                                    <button type="submit" class="tp_btn"
                                                        onclick="languagefileformValidate('message-form')" id="master-form-btn">Update</button>
                                                </div>
                                            </td>
                                        </tr>
                                        <input type="hidden" name="lang" value="{{ @$lang }}">
                                    </form>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 lang-tab-tar" id="fnt-message-lang">
                    <div class="tp_table_box">
                        <div class="table-responsive">
                            <table id="example" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form id="fnt-message-form" action="{{ route('admin.lang.store_fnt_message_file') }}"
                                        method="POST">
                                        @csrf
                                        @foreach ($fnt_message as $key => $val)
                                            <tr>
                                                <td><input type="text" class="form-control" name="{{ $key }}"
                                                        value="{{ $val }}"></td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td>
                                                <div class="mt-2">
                                                    <button type="submit" class="tp_btn"
                                                        onclick="languagefileformValidate('fnt-message-form')" id="fnt-message-form-btn">Update</button>
                                                </div>
                                            </td>
                                        </tr>
                                            <input type="hidden" name="lang" value="{{ @$lang }}">
                                    </form>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 lang-tab-tar " id="page-title-lang">
                    <div class="tp_table_box">
                        <div class="table-responsive">
                            <table id="example" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form id="page-title-form" action="{{ route('admin.lang.store_page_title_file') }}"
                                        method="POST">
                                        @csrf
                                        @foreach ($page_title as $k => $v)
                                            <tr>
                                                <td><b>{{ strtoupper(str_replace('_', ' ', $k)) }}</b></td>
                                            </tr>
                                            @foreach ($v as $key => $val)
                                                <tr>
                                                    <td><input type="text" class="form-control"
                                                            name="{{ $k }}[{{ $key }}]"
                                                            value="{{ $val }}"></td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                        <tr>
                                            <td>
                                                <div class="mt-2">
                                                    <button type="submit" class="tp_btn"
                                                        onclick="languagefileformValidate('page-title-form')" id="page-title-form-btn">Update</button>
                                                </div>
                                            </td>
                                        </tr>
                                            <input type="hidden" name="lang" value="{{ @$lang }}">
                                    </form>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="{{ asset('admin-theme/my_assets/js/form-validate.js') }}"></script>
@endsection
