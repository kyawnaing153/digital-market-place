@php $ASSET_URL = asset('user-theme').'/'; @endphp
@extends('frontend.layout.master')
@section('head_scripts')
    @php
        $mUrl = Request::url();
        $mImage = config('constants.preview_image');
        $mTitle = @$data->meta_title;
        $mDescr = @$data->meta_desc;
        $mKWords = @$data->meta_keywords;
    @endphp

    <title>{{ @$mTitle }}</title>
    <meta name="keywords" content="{{ @$mKWords }}" />
    <meta name="description" content="{{ @$mDescr }}" />

    <meta property=og:locale content="{{ app()->getLocale() }}" />
    <meta property=og:type content=website />
    <meta property="og:site_name" content="Coin Gabbar" />
    <meta property="og:title" content="{{ @$mTitle }}" />
    <meta property="og:description" content="{{ @$mDescr }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ @$mImage }}" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta property="twitter:title" content="{{ @$mTitle }}" />
    <meta property="twitter:description" content="{{ @$mDescr }}" />
    <meta property="twitter:url" content="{{ url()->current() }}" />
    <meta property="twitter:image" content="{{ @$mImage }}" />
    <meta name="twitter:site" content="@themeportal" />
    <meta name="twitter:creator" content="@themeportal" />
@endsection
@section('content')
    <!--===Header Section Start===-->
    <div class="tp_banner_section tp_single_section">
        <div class="container">
            <div class="tp_banner_heading">
                <h2>{{ @$data->heading }}</h2>
                <p>
                    {{ @$data->sub_heading }}
                </p>
            </div>
        </div>
    </div>
    <!--===Header Section End===-->
    <!--===Page Section Start===-->
    <div class="tp_aboutpage_section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp_about_heading">
                        <p>{!! @$data->description !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--===Page Section End===-->
@endsection

