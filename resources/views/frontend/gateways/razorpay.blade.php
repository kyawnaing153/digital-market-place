 <!DOCTYPE html>
 <html>
 <head>
     @php
         $ASSET_URL = asset('user-theme') . '/';
     @endphp
     <title>@lang('page_title.Frontend.razorpay_page_title')</title>
     <link rel="stylesheet" href="{{ $ASSET_URL }}assets/css/bootstrap.min.css" />
     <link rel="stylesheet" href="{{ $ASSET_URL }}assets/css/gateway.css" />
 </head>
 <body>
 <div class="panel panel-default">
     <div class="panel-body">
       
            <a href="{{ route('frontend.checkout', app()->getLocale()) }}" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></a>
        
         <h1 class="panel-head">@lang('master.gateways.Razorpay_Payment')</h1>
         <div class="text-center">
             <form action="{{ route('razorpay.make.payment', app()->getLocale()) }}" method="POST">
                 @csrf
                 <script src="https://checkout.razorpay.com/v1/checkout.js" 
                     data-key="{{ @$razorpay_key }}"
                     data-amount="{{ @$total_amount }}" 
                     data-buttontext="Pay Now {{ @$symbol . @$total_amount_view }}"
                     data-name="{{ getsetting()->site_name }}" 
                     data-description="Order"
                     data-image="{{ Storage::url(getSettingShortValue('my_logo')) }}" 
                     data-prefill.name="{{ auth()->user()->full_name ?? @$full_name  }}"
                     data-prefill.email="{{ auth()->user()->email ?? @$email }}" data-theme.color="#216fff"
                     ></script>
             </form>
         </div>
     </div>
 </div>
</body>
 <script src="{{ $ASSET_URL }}assets/js/jquery.min.js"></script>
 <script>
     $(window).on('load', function() {
         $('.razorpay-payment-button').click();
     });
 </script>
 </html>
