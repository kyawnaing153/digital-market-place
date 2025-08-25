<!DOCTYPE html>
<html lang="en">
@php
	$mUrl = Request::url();
	$setting = getsetting();
	$title = @$setting->site_title;
	$desc = @$setting->site_desc;
	$mKWords = @$setting->site_meta_desc;
	$ASSET_URL = asset('user-theme') . '/';
	$auth_user = Auth::user();
	// $STORAGE_URL =Storage::url('/');
	$mImage = Storage::url(@$setting->preview_image);
@endphp

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	@yield('head_scripts')
	<!-- Favicons -->
	<link href="{{ Storage::url(@$setting->favicon_img) }}" rel="icon">
    <link href="{{ Storage::url(@$setting->favicon_img) }}" rel="apple-touch-icon">
	<link rel="canonical" href="{{ url()->current() }}" />
	<link rel="alternate" hreflang="x-default" href="{{ url()->current() }}" />
	
	<style>
	      :root {
            --theme-color: <?php echo @$setting->primary_color ?? '#3480e5'  ?>;
            --secondary-color: <?php echo @$setting->secondary_color ?? '#585C66' ?>;
            --text-color: <?php echo @$setting->text_color ?? '#53627a' ?>; 
        }
    </style> 
	 <!--=== custom css ===-->
	 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
	 <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{$ASSET_URL}}assets/css/auth.css">
	<link rel="stylesheet" href="{{ $ASSET_URL }}my_assets/buttonLoader.css" />
    <!--=== custom css ===-->
</head>
<body>
	<div class="page">
		<div class="page-main">
			<div id="msg-toast"></div>
			<main id="main">
				@yield('content')
			</main>
		</div>
	</div>
	<!-- BEGIN JAVASCRIPT -->
	<script src="{{ $ASSET_URL }}assets/js/jquery.min.js"></script>
	<script>
		var ASSET_URL = "{{ asset('user-theme').'/' }}";
		var BASE_URL = "{{ url('/').'/'.app()->getLocale() }}/";
		var HAPPY_STRIKER = "{{Storage::url(@$setting->success_icon_img)}}"
		var SAD_STRIKER = "{{Storage::url(@$setting->error_icon_img)}}"
		$('.tp_main_wrapper').css('background-image', 'url({{Storage::url(@$setting->login_sign_bg_img)}})');
	</script>
	<!-- button laoder validation -->
	<script src="{{$ASSET_URL}}my_assets/jquery.buttonLoader.min.js"></script>
	<!-- jquery validation -->
	<script src="{{ $ASSET_URL }}my_assets/jquery.validate.js"></script>
	<script src="{{ $ASSET_URL }}my_assets/jquery-additional-methods.min.js"></script>
	<!-- jquery validation -->
     <!-- auth js -->
	 <script src="{{$ASSET_URL}}my_assets/js/auth.js"></script>
	 <!-- auth js -->
    <script src="{{$ASSET_URL}}my_assets/common.js"></script>
	@yield('scripts')
	 <!--=== End JavaScript ===-->
</body>

</html>
