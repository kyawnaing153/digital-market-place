<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('user-theme/assets/css/email_succ_page.css') }}" />
</head>
<body>
    <div class="card">
        @if (isset($success) && $success == true)
            <div class="tp_success">
                <i class="checkmark">✓</i>
            </div>
            <h1 class="success">Success</h1>
        @else
            <div class="tp_success">
                <span class="crossmark">X</span>
            </div>
            <h1 class="error">Error</h1>
        @endif

        <p>{{ @$message }}</p>

        <div class="btn-wrapper">
            <a class="btn" href="{{ route('frontend.home', app()->getLocale()) }}">Home</a>
            <a class="btn" href="{{ route('frontend.sign-in', app()->getLocale()) }}">Login</a>
        </div>
    </div>
</body>
</html>
