@extends('admin.layouts.app')
@section('head_scripts')
    <title>@lang('page_title.Admin.vendor_page_setting')</title>
@endsection
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <h4 class="tp_heading">Consent Form Setting</h4>
        </div>
        <div class="tp_tab_content">
            <form id="vendor-form" action="{{ route('admin.vendor.add_edit_content') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="tp_catset_box">

                            <div class="tp_form_wrapper">
                                <label class="mb-2">Show Become an author Tab</label>
                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" name="is_checked_author_tab" value="0">
                                        <input class="form-control" type="checkbox" value="1"
                                            name="is_checked_author_tab"@if (@$data->is_checked_author_tab == 1) checked @endif>
                                        <i class="input-helper"></i>Click to Show Become an author Tab.
                                    </label>
                                </div>
                            </div>
                            <div class="tp_form_wrapper">
                                <label class="mb-2">Heading Content</label>
                                <textarea class="form-control" rows="4" cols="50" spellcheck="false" placeholder="Enter Heading Content"
                                    name="author_heading_content" id="theme-editor">         
                                {{ @$data->author_heading_content }}
                                </textarea>
                            </div>

                            <div id="que-parent">
                                @php $que_ans_arr = unserialize($data->author_quest_ans); @endphp

                                @foreach ($que_ans_arr as $key => $val)
                                    <div class="que-parent">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="tp_form_wrapper">
                                                        <label class="mb-2">Question</label>
                                                        <input type="text" class=" form-control" name="question[]"
                                                            placeholder="Enter Question" value="{{ $val['question'] }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="field-button que-add-button">
                                                        @if ($key == 0)
                                                            <button type="button" id="add_more_question_ans"
                                                                class="btn-sm btn-primary float-end mt-4"><i
                                                                    class="fa fa-plus"></i>
                                                            </button>
                                                        @else
                                                            <div class="field-button">
                                                                <button type="button"
                                                                    class="btn-sm btn-danger float-end mt-4 remove-ques"><i
                                                                        class="fa fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div id="option-body" class="option-body">
                                            @foreach ($val['options'] as $k2 => $item)
                                                <div class="row options-op">
                                                    <div class="col-lg-6 col-md-6">
                                                        <div class="tp_form_wrapper">
                                                            <label class="mb-2">Option</label>
                                                            <input type="text" class="form-control options"
                                                                name="options{{ $key + 1 }}[]"
                                                                placeholder="Enter Option" value="{{ $item }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        @if ($k2 == 0)
                                                            <div class="field-button option-add-btn">
                                                                <button type="button" id="add_more_options"
                                                                    class="btn-sm btn-primary float-end mt-4"><i
                                                                        class="fa fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        @else
                                                            <div class="field-button">
                                                                <button type="button"
                                                                    class="btn-sm btn-danger float-end mt-4 remove-p-d"><i
                                                                        class="fa fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                            <button type="submit" class="tp_btn" id="vendor-form-btn">update</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <input type="hidden" id="total_que" value="{{ count($que_ans_arr) }}">
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('admin-theme/my_assets/js/form-validate.js') }}"></script>
    <script src="{{ asset('admin-theme/my_assets/js/author-content.js') }}"></script>
@endsection
