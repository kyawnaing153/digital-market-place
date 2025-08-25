<!DOCTYPE html>
<html lang="en">

<head>
    <!--=== meta tags ===-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $mUrl = Request::url();
        $STORAGE_URL = Storage::url('/');
        $setting = getsetting();
        $ASSET_URL = asset('user-theme') . '/';
        $auth_user = Auth::user();
        $fav_icon = Storage::url(@$setting->favicon_img);
    @endphp
    @yield('head_scripts')
    <!-- Favicons -->
    <link href="{{ $fav_icon }}" rel="icon">
    <link href="{{ $fav_icon }}" rel="apple-touch-icon">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <style>
        :root {
            --theme-color: <?php echo @$setting->primary_color ?? '#3480e5'; ?>;
            --secondary-color: <?php echo @$setting->secondary_color ?? '#585C66'; ?>;
            --text-color: <?php echo @$setting->text_color ?? '#53627a'; ?>;
            --background: <?php echo @$setting->body_color ?? '#eff5fc'; ?>;
            --bgcolour: <?php echo @$setting->body_color ?? '#eff5fc'; ?>;
            --theme-color-rgb: <?php echo hexToRgb(@$setting->primary_color ?? '#3480e5'); ?>;
            --secondary-color-rgb: <?php echo hexToRgb(@$setting->secondary_color ?? '#585C66'); ?>;
        }
    </style>

    <!--=== custom css ===-->
    <link rel="stylesheet" href="{{ $ASSET_URL }}assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ $ASSET_URL }}assets/css/swiper.min.css" />
    <link rel="stylesheet" href="{{ $ASSET_URL }}assets/css/magnific-popup.css" />
    <link rel="stylesheet" href="{{ $ASSET_URL }}assets/css/nice-select.css" />
    <link rel="stylesheet" href="{{ $ASSET_URL }}assets/css/animate.css" />
    {{-- <link rel="stylesheet" href="{{ $ASSET_URL }}assets/css/font-awesome.min.css" /> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ $ASSET_URL }}assets/css/style.css" />
    <link rel="stylesheet" href="{{ $ASSET_URL }}my_assets/buttonLoader.css" />
    <!--=== custom css ===-->
    @yield('head_css')

</head>

<body class="">
    <div class="loader">
        <div class="spinner">
            <img src="{{ Storage::url(@$setting->pre_loader_img) }}" alt="loader" />
        </div>
    </div>
    <div class="page">
        <div class="page-main">
            <div id="msg-toast"></div>
            <div class="tp_header_section">
                @include('frontend.layout.nav', [
                    'setting' => $setting,
                    'STORAGE_URL' => $STORAGE_URL,
                    'auth_user' => $auth_user,
                ])
                @include('frontend.layout.inner_header', [
                    'setting' => $setting,
                    'STORAGE_URL' => $STORAGE_URL,
                ])
            </div>
            <main id="main">
                @yield('content')
            </main>
        </div>
        @include('frontend.layout.footer', ['setting' => $setting, 'STORAGE_URL' => $STORAGE_URL])
        @if (!$auth_user)
            @include('frontend.include.login-popup', ['ASSET_URL' => $ASSET_URL])
        @endif
    </div>

    <!--===Bottom To Top===-->
    <div class="tp_top_icon">
        <a id="button" class="show">
            <svg xmlns="http://www.w3.org/2000/svg" width="17.031" height="10" viewBox="0 0 17.031 10">
                <path
                    d="M12.232,10.010 C12.234,10.010 12.236,10.010 12.237,10.010 C12.489,10.010 12.740,9.886 12.965,9.649 C14.203,8.347 15.439,7.045 16.672,5.739 C17.127,5.257 17.130,4.751 16.682,4.277 C15.441,2.961 14.197,1.650 12.951,0.341 C12.738,0.117 12.486,-0.006 12.241,-0.006 C12.022,-0.006 11.815,0.090 11.642,0.272 C11.266,0.670 11.291,1.213 11.707,1.657 C12.050,2.022 12.394,2.384 12.738,2.746 L13.415,3.461 C13.458,3.508 13.496,3.559 13.541,3.622 L13.878,4.069 L1.040,4.069 C0.954,4.067 0.870,4.066 0.785,4.075 C0.366,4.117 0.032,4.467 -0.010,4.907 C-0.051,5.342 0.198,5.748 0.582,5.873 C0.737,5.923 0.918,5.931 1.091,5.932 C4.409,5.935 7.728,5.934 11.048,5.934 L13.040,5.934 L13.999,5.934 L13.034,6.948 C12.578,7.428 12.146,7.882 11.717,8.336 C11.298,8.781 11.266,9.325 11.634,9.723 C11.807,9.909 12.013,10.009 12.232,10.010 Z"
                    class="cls-1" />
            </svg>
        </a>
    </div>
    <!--===Bottom To Top===-->
    <!-- BEGIN JAVASCRIPT -->
    <!--=== Optional JavaScript ===-->
    <script src="{{ $ASSET_URL }}assets/js/jquery.min.js"></script>
    <script src="{{ $ASSET_URL }}assets/js/bootstrap.bundle.min.js"></script>
    <script src="{{ $ASSET_URL }}assets/js/popper.min.js"></script>
    <script src="{{ $ASSET_URL }}assets/js/isotope.pkgd.min.js"></script>
    <script src="{{ $ASSET_URL }}assets/js/jquery.magnific-popup.min.js"></script>
    <script src="{{ $ASSET_URL }}assets/js/swiper.min.js"></script>
    <script src="{{ $ASSET_URL }}assets/js/jquery.nice-select.min.js"></script>
    <script src="{{ $ASSET_URL }}assets/js/custom.js"></script>
    <!--=== Optional JavaScript ===-->
    <!-- jquery validation -->
    <script src="{{ $ASSET_URL }}my_assets/jquery.validate.js"></script>
    <script src="{{ $ASSET_URL }}my_assets/jquery-additional-methods.min.js"></script>

    <!-- echo script -->
    <script type="module" src="{{ asset('js/bootstrap.js') }}"></script>

    <!-- jquery validation -->
    <script>
        var ASSET_URL = "{{ asset('user-theme') . '/' }}";
        var BASE_URL = "{{ url('/') . '/' . app()->getLocale() }}/";
        var HAPPY_STRIKER = "{{ Storage::url(@$setting->success_icon_img) }}"
        var SAD_STRIKER = "{{ Storage::url(@$setting->error_icon_img) }}"
        var autoSearch = "{{ __('master.home.search_template_here') }}";
    </script>
    <script src="{{ $ASSET_URL }}my_assets/jquery.buttonLoader.js"></script>
    <script src="{{ $ASSET_URL }}my_assets/common.js"></script>
    @if (!$auth_user)
        <script src="{{ $ASSET_URL }}my_assets/js/auth.js"></script>
    @endif
    @yield('scripts')
</body>

</html>
