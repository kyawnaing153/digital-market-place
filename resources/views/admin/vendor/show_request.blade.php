@extends('admin.layouts.app')
@section('head_scripts')
<title>@lang('page_title.Admin.vendor_title')</title>
@endsection
@section('content')
<div class="tp_main_content_wrappo">
    <div class="tp_tab_wrappo">
        <ul>
            <li ><a href="{{ route('admin.vendor.get_request') }}"> Request List</a> </li>
            <li class="active"><a href="#">Show Request</a></li>
        </ul>
    </div>
    <div class="tp_tab_content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="tp_catset_box tp_catset_singleuser">
                    @if ($data->avatar)
                        <div class="tp_create_userimg">
                            <img class="rounded-pill" src="@if (!empty(@$data->getUser->avatar)) {{ @$data->getUser->avatar }} @endif"
                                alt="user-img" height="120px" width="120px">
                        </div>
                    @endif
                    <div role="tabpanel" class="tab-pane active" id="info">
                        <div class="th_content_section">
                            <div class="th_product_detail">
                                <div class="theme_label">Full Name :</div>
                                <div class="product_info product_name">{{ @$data->getUser->full_name }}</div>
                            </div>
                            <div class="th_product_detail">
                                <div class="theme_label">Email :</div>
                                <div class="product_info status">{{ @$data->getUser->email }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">Mobile Number : </div>
                                <div class="product_info">{{ @$data->getUser->mobile }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">Address : </div>
                                <div class="product_info">{{ @$data->getUser->address }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">City : </div>
                                <div class="product_info">{{ @$data->getUser->city }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">State : </div>
                                <div class="product_info">{{ @$data->getUser->state }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">Country : </div>
                                <div class="product_info">{{ @$data->getUser->getCountry->name }}</div>
                            </div>

                            <div class="th_product_detail">
                                <div class="theme_label">User Status : </div>
                                <div class="product_info">{{ (@$data->getUser->is_active == 1) ?'Active':'Inactive';}}</div>
                            </div>
                            <div class="th_product_detail">
                                <div class="theme_label">Answers : </div>
                                <div class="product_info">
                                    @foreach (json_decode(@$data->answers) as $item)
                                    <p>{{ @$item}}</p>
                                    @endforeach
                                </div>
                            </div>
                            <div class="th_product_detail">
                                <div class="theme_label">Request Date: </div>
                                <div class="product_info">{{ @$data->created_at }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection