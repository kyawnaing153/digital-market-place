<!DOCTYPE html>
<html lang="en">
<head>
    @php
        $ASSET_URL = asset('admin-theme/assets') . '/';
        $auth_user = Auth::user();
        $setting = getsetting();
        $title = @$setting->site_title;
        $desc = @$setting->site_meta_desc;
        $mKWords = @$setting->site_meta_keywords;
    @endphp
    <!-- Meta data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta name="keywords" content="{{ @$mKWords }}" />
    <meta name="description" content="{{ @$desc }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="MobileOptimized" content="320" />
    <!-------- Favicon Link -------->
    <link rel="shortcut icon" href="{{   Storage::url(@$setting->favicon_img)  }}" />
    <link href="{{   Storage::url(@$setting->favicon_img) }}" rel="apple-touch-icon">
    <style>
           :root {
            --theme-color: <?php echo @$setting->primary_color ?? '#3480e5' ?>;
            --secondary-color: <?php echo @$setting->secondary_color ?? '#585C66' ?>;
            --tp-text-color: <?php echo @$setting->text_color ?? '#53627a' ?>;
            --tp-body-bg-color:<?php echo @$setting->body_color ?? '#eff5fc' ?>;
        }
    </style>
    <!-------- Style-sheet Start -------->
    <link rel="stylesheet" type="text/css" href="{{ $ASSET_URL }}css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ $ASSET_URL }}css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="{{asset('admin-theme/my_assets/select2.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ $ASSET_URL }}css/style.css" />
    <link rel="stylesheet" type="text/css" href="{{ $ASSET_URL }}css/dropzone.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ $ASSET_URL }}css/dropzone-custom.css"/>
    <link rel="stylesheet" href="{{ asset('admin-theme/my_assets/iziToast.min.css') }}">
    <!-- button laoder validation -->
    <link rel="stylesheet" href="{{ asset('user-theme/my_assets/buttonLoader.css') }}">
    @yield('head_scripts')
</head>
<body>
    <!-------- Loader Start -------->
    @if ($setting->pre_loader_img)
    <div class="loader">
        <div class="spinner">
            <img src="{{   Storage::url(@$setting->pre_loader_img) }}" alt="loader" />
        </div>
    </div>
    @endif
     <!-------- Loader End -------->
    <!-------- Main Wrappo Start -------->
    <div class="ts_message_popup">
        <p class="ts_message_popup_text"></p>
    </div>
    <!-- Page -->
    <div class="tp_main_wrappo">
        @include('author.layouts.menu', ['ASSET_URL' => $ASSET_URL, 'auth_user' => $auth_user])
        <div class="tp_main_structure">
            @include('author.layouts.header',['setting' => $setting,'primary_color'=> @$setting->primary_color ?? '#3480e5'])
            @yield('content')
        </div>
    </div>
    <!-- BEGIN JAVASCRIPT -->
    <!-- Back to top -->
    <a href="#top" id="back-to-top"><i class="fe fe-chevrons-up"></i></a>

    <!-------- Main JS file Start -------->

    <script type="text/javascript" src="{{ $ASSET_URL }}js/jquery.min.js"></script>
    <script type="text/javascript" src="{{ $ASSET_URL }}js/bootstrap.min.js"></script>
    <script src="{{asset('admin-theme/my_assets/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{ $ASSET_URL }}js/custom.js"></script>
    <script type="text/javascript" src="{{ $ASSET_URL }}ckeditor5/ckeditor.js"></script>
    <script type="text/javascript" src="{{ $ASSET_URL }}js/form-editor.js"></script>
    <script type="text/javascript" src="{{ $ASSET_URL }}js/custome-dropzone.js"></script>
    <script type="text/javascript" src="{{ $ASSET_URL }}js/dropzone.min.js"></script>
    <!-- jquery validation -->
    <script src="{{asset('user-theme/my_assets/jquery.validate.js')}}"></script>
    <script src="{{asset('user-theme/my_assets/jquery-additional-methods.min.js')}}"></script>
    <script src="{{ asset('admin-theme/my_assets/iziToast.min.js') }}"></script>
    <!-- button laoder validation -->
	<script src="{{asset('user-theme/my_assets/jquery.buttonLoader.min.js')}}"></script>
    <script src="{{asset('admin-theme/my_assets/common.js') }}"></script>
    
    <script>
        var ASSET_URL = "{{ asset('admin-theme') . '/' }}";
        var BASE_URL = "{{ url('/') }}";
        var prev_max_file_upload_size = "{{ @$setting->prev_max_file_upload_size ?? 1 }}";
        var prev_allowed_file_extensions = "{{ @$setting->prev_file_upload_extensions ?? 'image/*' }}";
        var prev_max_files  = "{{ @$setting->prev_max_files ?? 5 }}";
        var max_upload_size = "{{ @$setting->max_upload_size ?? 1 }}";
        var thumb_img_size = "{{ @$setting->thumb_img_size ?? 1 }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
