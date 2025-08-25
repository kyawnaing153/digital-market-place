<!DOCTYPE html>
<html>
<head>
    @php
        $ASSET_URL = asset('user-theme') . '/';
    @endphp
    <title>@lang('page_title.Frontend.stripe_page_title')</title>
    <link rel="stylesheet" href="{{ $ASSET_URL }}assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ $ASSET_URL }}assets/css/gateway.css" />
</head>

<body>
    <!--===Stripe Payment Start===-->
    <div class="stripe-panel-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="panel panel-default credit-card-box">
                        <h1 class="panel-head">@lang('master.stripe.stripe_payment')</h1>
                        <div class="panel-heading display-table">
                            <h2 class="panel-title">@lang('master.stripe.checkout_forms')</h2>
                        </div>
                        <div class="panel-body">
                            <form id='checkout-form' method='POST'
                                action="{{ route('frontend.stripe.handle', app()->getLocale()) }}">
                                @csrf
                                <input type='hidden' name='stripeToken' id='stripe-token-id'>
                                <br>
                                <div id="card-element" class="form-control"></div>
                                <div id="card-errors" role="alert"></div>
                                <button id='pay-btn' onclick="createToken()" class="btn btn-success mt-3"
                                    type="button" style="margin-top: 20px; width: 100%;padding: 7px;">PAY
                                    {{ @$total_amount }}
                                </button>
                            </form>
                            <input type='hidden' name='stripe_public_key' id='stripe_public_key' value="{{ $stripe_public_key }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!--===Stripe Payment End===-->
</body>
<script src="{{ $ASSET_URL }}assets/js/jquery.min.js"></script>
<script src="{{ $ASSET_URL }}assets/js/bootstrap.bundle.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>
<script src="{{ $ASSET_URL }}my_assets/gateways/stripe.js"></script>

</html>
