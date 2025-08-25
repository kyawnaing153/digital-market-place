@php
    $ASSET_URL = asset('user-theme') . '/';
    $setting = getSetting();
    $price_symbol = $setting->default_symbol ?? '$';
    $long_content = getSettingLongText();
@endphp
@extends('frontend.layout.master')
@section('head_scripts')
    <title>@lang('page_title.Frontend.user_profile_title')</title>
@endsection
@section('head_css')
    <link rel="stylesheet" href="{{ $ASSET_URL }}assets/css/rating.css" />
@endsection
@section('content')
    <!--===User Profile Section Start===-->
    <div class="tp_propage_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp_propage_head">
                        <h2>@lang('master.user_profile.welcome_back')</h2>
                        <p>@lang('master.user_profile.profile_heading')</p>
                    </div>
                </div>
            </div>
            <div class="row tp_propage_text">
                <div class="col-lg-3 col-md-4 col-sm-4">
                    <div class="nav nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link @if (empty(request('tab'))) active @endif" id="v-pills-profile-tab"
                            data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab"
                            aria-controls="v-pills-profile" aria-selected="true"><i class="fa fa-user"
                                aria-hidden="true"></i>@lang('master.user_profile.my_profile')
                        </button>
                        <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-change_password" type="button" role="tab"
                            aria-controls="v-pills-change_password" aria-selected="true"><i class="fa fa-lock"
                                aria-hidden="true"></i>@lang('master.user_profile.change_password')
                        </button>

                        <button class="nav-link @if (request('tab') == 'chat') active @endif" id="v-pills-chat-tab"
                            data-bs-toggle="pill" data-bs-target="#v-pills-chat" type="button" role="tab"
                            aria-controls="v-pills-chat" aria-selected="false">
                            <i class="fa fa-comments"></i> Chat
                        </button>

                        <button class="nav-link @if (request('tab') == 'my-orders') active @endif" id="v-pills-invoice-tab"
                            data-bs-toggle="pill" data-bs-target="#v-pills-invoice" type="button" role="tab"
                            aria-controls="v-pills-invoice" aria-selected="false"><i class="fa fa-file-text"
                                aria-hidden="true"></i>@lang('master.user_profile.my_order')
                        </button>
                        <button href="#v-pills-download" class="nav-link @if (request('tab') == 'my-downloads') active @endif"
                            id="v-pills-download-tab" data-bs-toggle="pill" data-bs-target="#v-pills-download"
                            role="tab" aria-controls="v-pills-download" aria-selected="false"><i class="fa fa-download"
                                aria-hidden="true"></i>@lang('master.user_profile.my_download')
                        </button>
                        @if (@$long_content->is_checked_author_tab)
                            <button href="#v-pills-become-an-author"
                                class="nav-link @if (request('tab') == 'become-an-author') active @endif "
                                id="v-pills-become-an-author-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-become-an-author" role="tab"
                                aria-controls="v-pills-become-an-author" aria-selected="false"><i class="fa fa-paper-plane"
                                    aria-hidden="true"></i>@lang('master.user_profile.become_an_author')
                            </button>
                        @endif
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-8">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade  @if (empty(request('tab'))) show active @endif"
                            id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <div class="tp_propage_profile_wrapper">
                                <div class="tp_propage_profilehead">
                                    <h3>@lang('master.user_profile.personal_details')</h3>
                                </div>
                                <form action="{{ route('frontend.update_profile', app()->getLocale()) }}" method="Post"
                                    id="update_user_details">
                                    @csrf
                                    <div class="tp_propage_profile_form">
                                        <div class="tp_input_main">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="card-body text-center">
                                                        <div class="tp_user_img">
                                                            <img src="@if (!empty($user->avatar)) {{ $user->avatar }} @endif"
                                                                alt="avatar" title="avatar" class="rounded-circle"
                                                                width="150px" height="150px" id="Imagepreview" />
                                                            <div class="tp_user_edit">
                                                                <i id="OpenImgUpload"
                                                                    class="text-left fa fa-cloud-upload d-block"></i>
                                                            </div>
                                                            <input type="file" name="image" id="imgupload"
                                                                onchange="uploadImage('imgupload')"
                                                                style="display:none" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="tp_input_text">
                                                        <label class="form-label">@lang('master.user_profile.contact_email')</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Your Email" name="email"
                                                            value="{{ @$user->email }}" disabled>

                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="tp_input_text">
                                                        <label class="form-label">@lang('master.user_profile.full_name')</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter full Name" name="full_name"
                                                            value="{{ @$user->full_name }}">

                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="tp_input_text">
                                                        <label class="form-label">@lang('master.user_profile.user_name')</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter User Name" name="username"
                                                            value="{{ @$user->username }}">

                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="tp_input_text">
                                                        <label class="form-label">@lang('master.user_profile.mobile_number')</label>
                                                        <input type="number" class="form-control"
                                                            placeholder="Enter Mobile Number" name="mobile"
                                                            value="{{ @$user->mobile }}">

                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="tp_input_text">
                                                        <label class="form-label">@lang('master.user_profile.country')</label>
                                                        <select class="form-control form-control-lg input-font"
                                                            name="country_id">
                                                            <option value="">@lang('master.user_profile.select_country')</option>
                                                            @foreach ($country as $item)
                                                                <option value="{{ $item->id }}"
                                                                    @if (@$user->country_id == $item->id) selected @endif>
                                                                    {{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="tp_input_text">
                                                        <label class="form-label">@lang('master.user_profile.state')</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Your state" name="state"
                                                            value="{{ @$user->state }}">

                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="tp_input_text">
                                                        <label class="form-label">@lang('master.user_profile.city')</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Your City" name="city"
                                                            value="{{ @$user->city }}">

                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="tp_input_text">
                                                        <label class="form-label">@lang('master.user_profile.address')</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Your Address" name="address"
                                                            value="{{ @$user->address }}">

                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12">
                                                    <button class="btn btn-color btn-lg px-5 py-2 btn-font tp_btn"
                                                        type="submit"
                                                        id="update_user_details_btn">@lang('master.user_profile.update')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-change_password" role="tabpanel"
                            aria-labelledby="v-pills-change_password-tab">
                            <div class="tp_propage_profile_wrapper">
                                <div class="tp_propage_profilehead">
                                    <h3>@lang('master.user_profile.change_password')</h3>
                                </div>
                                <form action="{{ route('frontend.change-password', app()->getLocale()) }}" method="Post"
                                    id="change_password_form_id">
                                    @csrf
                                    <div class="tp_propage_profile_form">
                                        <div class="tp_input_main">
                                            <div class="tp_input_text">
                                                <label class="form-label">@lang('master.user_profile.old_password')</label>
                                                <input type="password" name="old_password" class="form-control"
                                                    placeholder="Enter Your Old Password" />

                                            </div>
                                            <div class="tp_input_text">
                                                <label class="form-label">@lang('master.user_profile.new_password')</label>
                                                <input type="password" name="password" class="form-control"
                                                    placeholder="Enter Your Password" />
                                            </div>
                                            <div class="tp_input_text">
                                                <label class="form-label">@lang('master.user_profile.confirm_password')</label>
                                                <input type="password" name="confirm_password" class="form-control"
                                                    placeholder="Enter Your confirm password" />

                                            </div>
                                            <button class="btn btn-color btn-lg px-5 py-2 btn-font tp_btn" type="submit"
                                                id="change_password_form_id_btn">@lang('master.user_profile.update')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade @if (request('tab') == 'chat') show active @endif" id="v-pills-chat"
                            role="tabpanel" aria-labelledby="v-pills-chat-tab">
                            {{-- left: list, right: window (AJAX-loaded) --}}
                            @include('frontend.chat.index')
                        </div>
                        <div class="tab-pane fade @if (request('tab') == 'my-orders') active @endif" id="v-pills-invoice"
                            role="tabpanel" aria-labelledby="v-pills-invoice-tab">
                            <div class="tp_propage_profile_wrapper">
                                <div class="tp_propage_profilehead tp_propage_invoice">

                                    <h3>@lang('master.billing_details.orders')</h3>
                                </div>
                                <div class="tp_table_box tp_propage_table">
                                    <div class="table-responsive">
                                        <table id="example" class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>@lang('master.billing_details.tnx_number')</th>
                                                    <th>@lang('master.billing_details.amount')</th>
                                                    <th>@lang('master.billing_details.payment_date')</th>
                                                    <th>@lang('master.billing_details.status')</th>
                                                    <th>@lang('master.billing_details.invoice')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($user->getOrders[0]))
                                                    @foreach ($user->getOrders as $key => $items)
                                                        <tr>
                                                            <td>{{ ++$key }}</td>
                                                            <td>{{ $items->tnx_id }}</td>
                                                            <td>{{ $price_symbol }}{{ @$items->billing_total }}</td>
                                                            <td>{{ set_date_format($items->created_at) }}</td>
                                                            <td>
                                                                {{ $items->status_str }}
                                                            </td>
                                                            <td>
                                                                @if ($items->status == 1)
                                                                    <ul>
                                                                        <li><a target="_blank"
                                                                                href="{{ route('frontend.view-invoice', [app()->getLocale(), 'tnx_id' => $items->tnx_id]) }}"
                                                                                class="tp_edit" title="View"><i
                                                                                    class="fa fa-eye"
                                                                                    aria-hidden="true"></i></a>
                                                                            <a target="_blank"
                                                                                href="{{ route('frontend.download-invoice', [app()->getLocale(), 'tnx_id' => $items->tnx_id]) }}"
                                                                                class="tp_edit" title="Download"><i
                                                                                    class="fa fa-file-invoice"
                                                                                    aria-hidden="true"></i></a>
                                                                        </li>
                                                                    </ul>
                                                                @else
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr class="text-center">
                                                        <td colspan="5">@lang('master.billing_details.not_found')</td>
                                                    </tr>
                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade @if (request('tab') == 'my-downloads') show active @endif"
                            id="v-pills-download" role="tabpanel" aria-labelledby="v-pills-download-tab">
                            <div class="tp_propage_profile_wrapper">
                                <div class="tp_propage_profilehead tp_propage_pay">
                                    <h3>@lang('master.billing_details.download')</h3>
                                </div>

                                <div class="tp_propage_download">
                                    <div class="row">
                                        @if (isset($user->getOrders[0]))
                                            @foreach ($user->getOrders as $key => $items1)
                                                @if ($items1->status == 1)
                                                    @foreach ($items1->getOrderProduct as $key2 => $items2)
                                                        @foreach ($items2->getProduct as $key3 => $items)
                                                            @php
                                                                $extension = pathinfo(
                                                                    $items->thumb,
                                                                    PATHINFO_EXTENSION,
                                                                );
                                                            @endphp
                                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                                <div class="tp_pro_downbox">
                                                                    @if ($extension == 'mp4')
                                                                        <div class="tp_download_img">
                                                                            <img src="{{ asset('user-theme/assets/images/videoImage.png') }}"
                                                                                class="tp-animation-img"
                                                                                alt="project-img" />

                                                                        </div>
                                                                    @elseif($extension == 'mp3')
                                                                        <div class="tp_download_img">
                                                                            <img src="{{ asset('user-theme/assets/images/song.png') }}"
                                                                                class="tp-animation-img"
                                                                                alt="project-img" />

                                                                        </div>
                                                                    @else
                                                                        <div class="tp_download_img">
                                                                            <img src="{{ $items->thumb }}"
                                                                                class="tp-animation-img"
                                                                                alt="project-img" />
                                                                        </div>
                                                                    @endif

                                                                    <div class="tp_download_text">
                                                                        <div class="tp_download_text_head">
                                                                            <h5>{{ $items->name }}</h5>
                                                                            <p>by {{ $items->getUser->full_name }}</p>
                                                                        </div>
                                                                        <div class="star_rating">
                                                                            <div class="star_rating">
                                                                                @include(
                                                                                    'frontend.include.rating',
                                                                                    [
                                                                                        'faRating' => true,
                                                                                        'rating' => @$items->rating,
                                                                                    ]
                                                                                )
                                                                            </div>
                                                                        </div>
                                                                        <div class="tp-dwld-toggle">
                                                                            <div class="dropdown">
                                                                                <button class="btn tp_btn dropdown-toggle"
                                                                                    type="button"
                                                                                    data-bs-toggle="dropdown"
                                                                                    aria-expanded="false">
                                                                                    @lang('master.user_profile.download')
                                                                                </button>

                                                                                @php $fileArr = $items->getdownlaodfilelink(@$items2->variants); @endphp
                                                                                @if (count($fileArr) > 0)
                                                                                    <ul class="dropdown-menu">
                                                                                        @foreach ($fileArr as $key => $value)
                                                                                            <li> <a class="dropdown-item"
                                                                                                    href="{{ route('frontend.download-file', [app()->getLocale(), 'file_id' => @$value['file_id'], 'tnx_id' => @$items1->tnx_id, 'pid' => @$value['product_id']]) }}">
                                                                                                    <i class="fa fa-download"
                                                                                                        aria-hidden="true"></i>
                                                                                                    {{ @$value['file_name'] }}
                                                                                                </a>
                                                                                            </li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                @endif
                                                                            </div>

                                                                            <button type="button" data-bs-toggle="modal"
                                                                                data-bs-target="#reviewmodal"
                                                                                class="btn tp_btn tp_rev_btn"
                                                                                onclick="setReview('{{ $items->thumb }}',
                                                                            '{{ $items->slug }}',
                                                                            '{{ @$items1->tnx_id }}',
                                                                            '{{ @$items->getUserProductReview->id }}',
                                                                            '{{ @$items->getUserProductReview->rating }}')
                                                                            ">
                                                                                @lang('master.user_profile.Review')</button>
                                                                        </div>
                                                                        <input type="hidden"
                                                                            id="r_comment_{{ @$items->getUserProductReview->id }}"
                                                                            value="{{ @$items->getUserProductReview->comment }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @else
                                            <p>@lang('master.user_profile.no_download_found')</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade @if (request('tab') == 'become-an-author') show active @endif"
                            id="v-pills-become-an-author" role="tabpanel" aria-labelledby="v-pills-become-an-author-tab">
                            <div class="tp_propage_profile_wrapper tp_pro_author">
                                @if (isset($vendor_request) && !empty($vendor_request))
                                    <div class="" role="alert">
                                        <div class="tp_propage_profilehead">
                                            <h3>@lang('master.Become_an_author.Dear') {{ $user->full_name }}</h3>
                                        </div>

                                        @if ($vendor_request->status == 0)
                                            <div class="tp_auth_sub">
                                                <div class="tp_auth_sub_img">
                                                    <img src="{{ $ASSET_URL . 'assets/images/timer.png' }}"
                                                        alt="sub-img">
                                                </div>
                                                <div class="tp_auth_sub_text">
                                                    <h4>@lang('master.Become_an_author.submitted_request_title')</h4>

                                                    <p> @lang('master.Become_an_author.Our_administrative_team') </p>

                                                    <p> @lang('master.Become_an_author.Once_your_request_is_approved')</p>
                                                    <p> @lang('master.Become_an_author.if_your_have_any_que')
                                                        <span>{{ @$setting->support_email }}</span>.
                                                    </p>
                                                </div>
                                            </div>
                                        @else
                                            <div class="tp_auth_sub tp_auth_cong">
                                                <div class="tp_auth_sub_img">
                                                    <img src="{{ $ASSET_URL . 'assets/images/checked.png' }}"
                                                        alt="sub-img">
                                                </div>
                                                <div class="tp_auth_sub_text">
                                                    <h4>@lang('master.Become_an_author.congratulations_title')</h4>
                                                    <p>
                                                        @lang('master.Become_an_author.manage_approved')<a href="{{ route('vendor.login') }}">
                                                            @lang('master.Become_an_author.my_dashbord') </a>
                                                    </p>

                                                    <p>@lang('master.Become_an_author.to_access_your_dashboard')</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @elseif($user->role == 2)
                                    <div class="tp_auth_sub tp_auth_cong">
                                        <div class="tp_auth_sub_img">
                                            <img src="{{ $ASSET_URL . 'assets/images/checked.png' }}" alt="sub-img">
                                        </div>
                                        <div class="tp_auth_sub_text">
                                            <h4>@lang('master.Become_an_author.congratulations_title')</h4>
                                            <p>
                                                @lang('master.Become_an_author.manage_approved')<a href="{{ route('vendor.login') }}">
                                                    @lang('master.Become_an_author.my_dashbord') </a>
                                            </p>

                                            <p>@lang('master.Become_an_author.to_access_your_dashboard')</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="tp_propage_profilehead">
                                        {!! @$long_content->author_heading_content !!}
                                    </div>

                                    <form action="{{ route('frontend.become-an-vendor-request', app()->getLocale()) }}"
                                        method="Post" id="become_an_author_form_id">
                                        @csrf

                                        @php $que_ans_arr = unserialize(@$long_content->author_quest_ans); @endphp

                                        @if (!empty($que_ans_arr) && count($que_ans_arr) > 0)
                                            @foreach ($que_ans_arr as $key => $val)
                                                <div class="tp_propage_profile_form">
                                                    <div class="tp_input_main tp_pro_auform">
                                                        <h3>{{ $val['question'] }}</h3>

                                                        @foreach ($val['options'] as $k2 => $item)
                                                            <div class="tp_input_text">
                                                                <label class="form-label"> <input type="radio"
                                                                        name="answer[{{ $key }}]"
                                                                        value="{{ $item }}">
                                                                    {{ $item }}</label>
                                                            </div>
                                                        @endforeach

                                                        <label id="answer[{{ $key }}]-error" class="error"
                                                            for="answer[{{ $key }}]"></label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                        <div class="tp_input_text tp_au_check">
                                            <div class="tp_auth_checkbox">


                                                <label class="form-label">
                                                    <input type="checkbox" name="author_terms_condition"
                                                        value="3D models" class="form-check">
                                                    <i class="input-helper"></i>
                                                    @lang('master.Become_an_author.by_continuing_you_agree_to_the') <a
                                                        href="{{ route('frontend.author-terms-and-conditions', app()->getLocale()) }}">
                                                        @lang('master.Become_an_author.author_terms');
                                                    </a></label>
                                            </div>
                                        </div>
                                        <label id="author_terms_condition-error" class="error"
                                            for="author_terms_condition"></label>
                                        <button class="btn btn-color btn-lg px-5 py-2 btn-font tp_btn" type="submit"
                                            id="become_an_author_form_id_btn"> @lang('master.Become_an_author.send_request')</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--=== Section Start===-->
    {{-- Review model --}}
    <div class="modal fade" id="reviewmodal" tabindex="-1" aria-labelledby="reviewmodallabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bdr-radius rounded-4 overflow-hidden">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="card bg-white text-dark shadow-none tp_review_model_wrapper">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            <div class="card-body">
                                <form method="post" class="tp_review_form" id="user_set_review"
                                    action="{{ route('admin.rating.store', app()->getLocale()) }}">
                                    <div class="tp_review_box">
                                        <img id="md-review-img" src="" class="tp-review-img" alt="review-img">
                                        <div class="tp_review_box_data">
                                            <h3>@lang('master.review_model.product')</h3>
                                            <div class="tp_review_star">
                                                <p>@lang('master.review_model.star_rate')</p>

                                                <div class="col">
                                                    <div class="rate">
                                                        <input type="radio" id="star5" class="rate"
                                                            name="rating" value="5" />
                                                        <label for="star5" title="text">@lang('master.review_model.5_stars')</label>
                                                        <input type="radio" checked id="star4" class="rate"
                                                            name="rating" value="4" />
                                                        <label for="star4" title="text">@lang('master.review_model.4_stars')</label>
                                                        <input type="radio" id="star3" class="rate"
                                                            name="rating" value="3" />
                                                        <label for="star3" title="text">@lang('master.review_model.3_stars')</label>
                                                        <input type="radio" id="star2" class="rate"
                                                            name="rating" value="2">
                                                        <label for="star2" title="text">@lang('master.review_model.2_stars')</label>
                                                        <input type="radio" id="star1" class="rate"
                                                            name="rating" value="1" />
                                                        <label for="star1" title="text">@lang('master.review_model.1_stars')</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tp_reviewform_box">
                                        <div class="tp_input_text">
                                            <textarea placeholder="Write a review here... " class="form-control" id="rt_comment" name="comment" rows="3"
                                                cols="50"></textarea>
                                        </div>
                                        <button id="user_set_review_btn"
                                            class="btn btn-color btn-lg px-5 py-2 btn-font tp_btn" type="submit">
                                            @lang('master.review_model.post_review')</button>
                                    </div>
                                    <input type="hidden" name="pid" id="_pid" value="">
                                    <input type="hidden" name="txid" id="_txid" value="">
                                    <input type="hidden" name="rid" id="_rate_id" value="">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('user-theme/my_assets/js/validation.js') }}"></script>
@endsection
