<!DOCTYPE html>
<html lang="en">

<head>
    @php 
     $setting = getsetting();
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
     <style>
        :root {  
            --theme-color: <?php echo @$setting->primary_color ?? '#0ED8D2' ?>;
            --secondary-color: <?php echo @$setting->secondary_color ?? '#585C66' ?>;
        }
        </style> 

    <!-- Styles -->
    <style>
        html {
            line-height: 1.6;
        }
        body {
            margin: 0;
            padding:0;
            box-sizing:border-box;
            font-family: Nunito, sans-serif;
        }
        a {
            background-color: transparent;
            -webkit-text-decoration-skip: objects;
        }
        h1, h2, p,a{
            font-family: Nunito, sans-serif;
        }
        *,
        *::before,
        *::after {
            -webkit-box-sizing: inherit;
            box-sizing: inherit;
        }
        p {
            margin: 0;
        }
        button,
        input {
            overflow: visible;
        }

        button {
            text-transform: none;
        }

        button,
        html [type="button"],
        [type="reset"],
        [type="submit"] {
            -webkit-appearance: button;
        }

        button::-moz-focus-inner,
        [type="button"]::-moz-focus-inner,
        [type="reset"]::-moz-focus-inner,
        [type="submit"]::-moz-focus-inner {
            border-style: none;
            padding: 0;
        }

        button:-moz-focusring,
        [type="button"]:-moz-focusring,
        [type="reset"]:-moz-focusring,
        [type="submit"]:-moz-focusring {
            outline: 1px dotted ButtonText;
        }

        legend {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            color: inherit;
            display: table;
            max-width: 100%;
            padding: 0;
            white-space: normal;
        }

        [type="checkbox"],
        [type="radio"] {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            padding: 0;
        }

        [type="number"]::-webkit-inner-spin-button,
        [type="number"]::-webkit-outer-spin-button {
            height: auto;
        }

        [type="search"] {
            -webkit-appearance: textfield;
            outline-offset: -2px;
        }

        [type="search"]::-webkit-search-cancel-button,
        [type="search"]::-webkit-search-decoration {
            -webkit-appearance: none;
        }

        ::-webkit-file-upload-button {
            -webkit-appearance: button;
            font: inherit;
        }

        menu {
            display: block;
        }

        canvas {
            display: inline-block;
        }

        template {
            display: none;
        }

        [hidden] {
            display: none;
        }

        html {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        button {
            background: transparent;
            padding: 0;
        }

        button:focus {
            outline: 1px dotted;
            outline: 5px auto -webkit-focus-ring-color;
        }

        button,
        [type="button"],
        [type="reset"],
        [type="submit"] {
            border-radius: 0;
        }

        button,
        input {
            font-family: inherit;
        }

        input::-webkit-input-placeholder {
            color: inherit;
            opacity: .5;
        }

        input:-ms-input-placeholder {
            color: inherit;
            opacity: .5;
        }

        input::-ms-input-placeholder {
            color: inherit;
            opacity: .5;
        }

        input::placeholder {
            color: inherit;
            opacity: .5;
        }

        button,
        [role=button] {
            cursor: pointer;
        }

        img{
            max-width:100%;
        }
        button:focus{
            outline:none;
        }
        .tp-404-section {
            display: flex;
            align-items: center;
            justify-content: space-around;
            max-width: 1200px;
            margin: 0 auto;
            height:100vh
        }

       .tp-404-head h1 {
            color: #22292f;
            font-size: 130px;
            font-weight: 900;
            line-height: 1.2;
            margin: 0;
            padding: 0 0 20px;
            position: relative;
        }
        .tp-404-head h1:after {
                position: absolute;
                content: '';
                left: 0;
                bottom: 0px;
                height: 5px;
                width: 100px;
                background: linear-gradient(180deg, var(--theme-color) 0%, var(--secondary-color) 100%);
            }
        .tp-left-heading p{
            font-size:30px;
            color:#606f7b;
            margin:30px 0 40px;
            line-height:1.2;
            font-weight:300;
        }
        .tp-404-btn button {
            font-size: 17px;
            /*color: #3d4852;*/
            text-transform: uppercase;
            max-width: 150px;
            padding: 10px 20px;
            border: 1px solid #dae1e7;
            border-radius: 10px;
            font-weight: 600;
            background:linear-gradient(180deg, var(--theme-color) 0%, var(--secondary-color) 100%);
            color:#fff;
            min-height:50px;
        }
        .tp-404-img {
            position: relative;
        }
        @media(max-width:767px){
            .tp-404-section {
                flex-direction: column;
                height: 100%;
                gap: 30px;
            }
        }
        @media(max-width:480px){
            .tp-404-img img{
                width:auto;
                height:auto;
            }
        }
    </style>
</head>

<body class="antialiased font-sans">
    <div class="tp-404-section">
        <div class="tp-left-section">
            <div class="tp-left-heading">
                <div class="tp-404-head">
                    <h1>@yield('code', __('Oh no'))</h1>
                </div>
                <p class="text-grey-darker text-2xl md:text-3xl font-light mb-8 leading-normal tp-404-msg">
                    @yield('message')
                </p>

                <a href="{{ app('router')->has('frontend.home',app()->getLocale()) ? route('frontend.home',app()->getLocale()) : url('/') }}" class="tp-404-btn">
                    <button type="submit" class="btn">
                        {{ __('Go Home') }}
                    </button>
                </a>
            </div>
        </div>

        <div class="tp-404-img">
            @yield('image')
        </div>
    </div>
</body>

</html>
