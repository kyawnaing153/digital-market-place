@php $ASSET_URL = asset('user-theme').'/'; @endphp
<!--=== footer Start===-->
<div class="tp_footer_section">
    <div class="container">
        <div class="tp_footer_add">
            <div class="row">
                @if (@$setting->is_checked_email)
                    <div class="col-lg-4 col-md-4">
                        <div class="tp_contact_list">
                            <span class="tp_con_icon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                            <div class="tp_contact_details">
                                <h5>@lang('master.footer.Mail_Us')</h5>
                                <p><a href="mailto:{{ @$setting->company_email }}">{{ @$setting->company_email }}</a></p>
                            </div>
                        </div>
                    </div>
                @endif
                @if (@$setting->is_checked_phone)
                    <div class="col-lg-4 col-md-4">
                        <div class="tp_contact_list">
                            <span class="tp_con_icon"><i class="fa fa-phone" aria-hidden="true"></i></span>
                            <div class="tp_contact_details">
                                <h5>@lang('master.footer.Contact_Number')</h5>
                                <p><a href="skype:{{ @$setting->company_phone }}?call">{{ @$setting->company_phone }}</a></p>
                            </div>
                        </div>
                    </div>
                @endif
                @if (@$setting->is_checked_address)
                    <div class="col-lg-4 col-md-4">
                        <div class="tp_contact_list">
                            <span class="tp_con_icon"><i class="fa fa-street-view" aria-hidden="true"></i></span>
                            <div class="tp_contact_details">
                                <h5>@lang('master.footer.Our_Location')</h5>
                                <p><a href="https://www.google.com/maps/search/?api=1&query={{ urlencode(@$setting->company_adderss) }}">{{ @$setting->company_adderss }} </a></p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <img src="{{ $ASSET_URL }}/assets/images/bottomline.png" alt="">
        </div>
        <div class="tp_address_main">
            <div class="row">
                <div class="col-lg-5 col-md-6 col-sm-6">
                    <div class="tp_footer_box">
                        <img src="{{ Storage::url(@$setting->white_logo) }}" alt="white logo" />
                        @if (@$setting->is_checked_footer_text)
                            <p>
                                {{ @$setting->footer_text }}
                            </p>
                        @endif
                        <img src="{{ $ASSET_URL }}assets/images/footerborder.png" alt="" />
                        <div class="tp_footer_social">
                            <ul>
                                @if (@$setting->is_checked_facebook)
                                    <li>
                                        <a target="_blank" rel="nofollow noreferrer noopener"
                                            href="{{ @$setting->facebook_url }}"><svg xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 6 11.97">
                                                <path
                                                    d="M5.770,-0.011 L4.331,-0.014 C2.715,-0.014 1.671,1.144 1.671,2.937 L1.671,4.297 L0.225,4.297 C0.100,4.297 -0.001,4.407 -0.001,4.541 L-0.001,6.512 C-0.001,6.647 0.100,6.757 0.225,6.757 L1.671,6.757 L1.671,11.731 C1.671,11.865 1.772,11.975 1.897,11.975 L3.784,11.975 C3.909,11.975 4.010,11.865 4.010,11.731 L4.010,6.757 L5.701,6.757 C5.826,6.757 5.927,6.647 5.927,6.512 L5.928,4.541 C5.928,4.477 5.904,4.414 5.862,4.368 C5.819,4.323 5.762,4.297 5.702,4.297 L4.010,4.297 L4.010,3.144 C4.010,2.590 4.133,2.308 4.800,2.308 L5.769,2.307 C5.894,2.307 5.995,2.198 5.995,2.063 L5.995,0.233 C5.995,0.098 5.894,-0.011 5.770,-0.011 Z"
                                                    class="cls-1" />
                                            </svg></a>
                                    </li>
                                @endif
                                @if (@$setting->is_checked_twitter)
                                    <li>
                                        <a target="_blank" rel="nofollow noreferrer noopener"
                                            href="{{ @$setting->twitter_url }}">
                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;"
                                                xml:space="preserve">
                                                <g>
                                                    <path
                                                        d="M11.8,8.5l7-8.1h-1.7l-6.1,7.1L6.2,0.4H0.6l7.3,10.7l-7.3,8.5h1.7l6.4-7.5l5.1,7.5h5.6L11.8,8.5L11.8,8.5z M9.5,11.2
                                                l-0.7-1.1L2.9,1.6h2.5l4.8,6.8l0.7,1.1l6.2,8.9h-2.5L9.5,11.2L9.5,11.2z" />
                                                </g>
                                            </svg>

                                        </a>
                                    </li>
                                @endif
                                @if (@$setting->is_checked_insta)
                                    <li>
                                        <a target="_blank" rel="nofollow noreferrer noopener"
                                            href="{{ $setting->instagram_url }}"><svg xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 13 13">
                                                <path
                                                    d="M12.956,9.188 C12.926,9.879 12.814,10.352 12.654,10.766 C12.316,11.641 11.625,12.332 10.751,12.670 C10.339,12.830 9.864,12.942 9.172,12.972 C8.479,13.003 8.258,13.010 6.491,13.010 C4.725,13.010 4.504,13.003 3.810,12.972 C3.119,12.942 2.646,12.830 2.232,12.670 C1.800,12.507 1.406,12.251 1.081,11.920 C0.751,11.595 0.494,11.203 0.329,10.766 C0.169,10.354 0.057,9.879 0.026,9.188 C-0.004,8.494 -0.012,8.272 -0.012,6.506 C-0.012,4.739 -0.004,4.519 0.029,3.823 C0.060,3.132 0.171,2.658 0.331,2.244 C0.494,1.812 0.751,1.418 1.081,1.093 C1.406,0.760 1.798,0.506 2.235,0.341 C2.646,0.180 3.122,0.068 3.813,0.038 C4.507,0.008 4.728,0.000 6.494,0.000 C8.260,0.000 8.481,0.008 9.178,0.041 C9.869,0.071 10.341,0.183 10.756,0.343 C11.188,0.506 11.581,0.763 11.907,1.093 C12.240,1.418 12.494,1.809 12.659,2.247 C12.819,2.658 12.931,3.134 12.961,3.825 C12.992,4.519 12.994,4.739 12.994,6.506 C12.994,8.272 12.987,8.494 12.956,9.188 ZM11.790,3.884 C11.762,3.251 11.655,2.905 11.566,2.676 C11.462,2.394 11.297,2.140 11.081,1.929 C10.872,1.712 10.616,1.548 10.334,1.444 C10.105,1.354 9.762,1.248 9.127,1.220 C8.443,1.189 8.237,1.182 6.499,1.182 C4.763,1.182 4.557,1.189 3.871,1.220 C3.239,1.248 2.893,1.354 2.664,1.444 C2.382,1.548 2.128,1.712 1.917,1.929 C1.699,2.137 1.534,2.394 1.429,2.676 C1.340,2.905 1.234,3.248 1.206,3.884 C1.175,4.568 1.168,4.776 1.168,6.511 C1.168,8.247 1.175,8.453 1.206,9.140 C1.234,9.773 1.340,10.118 1.429,10.346 C1.534,10.629 1.699,10.884 1.915,11.094 C2.123,11.310 2.380,11.476 2.662,11.580 C2.890,11.668 3.233,11.775 3.869,11.803 C4.552,11.834 4.761,11.841 6.496,11.841 C8.232,11.841 8.438,11.834 9.124,11.803 C9.757,11.775 10.103,11.668 10.331,11.580 C10.898,11.361 11.348,10.911 11.566,10.344 C11.655,10.116 11.762,9.773 11.790,9.137 C11.820,8.451 11.828,8.247 11.828,6.511 C11.828,4.776 11.820,4.570 11.790,3.884 ZM9.968,3.812 C9.537,3.812 9.188,3.463 9.188,3.032 C9.188,2.601 9.537,2.252 9.968,2.252 C10.399,2.252 10.748,2.601 10.748,3.032 C10.748,3.463 10.399,3.812 9.968,3.812 ZM6.494,9.849 C4.649,9.849 3.152,8.352 3.152,6.506 C3.152,4.661 4.649,3.164 6.494,3.164 C8.339,3.164 9.836,4.661 9.836,6.506 C9.836,8.352 8.339,9.849 6.494,9.849 ZM6.494,4.338 C5.297,4.338 4.326,5.309 4.326,6.506 C4.326,7.703 5.297,8.675 6.494,8.675 C7.691,8.675 8.662,7.703 8.662,6.506 C8.662,5.309 7.691,4.338 6.494,4.338 Z"
                                                    class="cls-1" />
                                            </svg></a>
                                    </li>
                                @endif
                                @if (@$setting->is_checked_youtube)
                                    <li>
                                        <a target="_blank" rel="nofollow noreferrer noopener"
                                            href="{{ $setting->youtube_url }}"><svg xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 14.56 10.78">
                                                <path
                                                    d="M13.939,1.046 C13.544,0.291 13.116,0.152 12.243,0.099 C11.372,0.035 9.180,0.008 7.281,0.008 C5.378,0.008 3.186,0.035 2.315,0.098 C1.444,0.152 1.015,0.289 0.616,1.046 C0.209,1.801 0.000,3.101 0.000,5.390 C0.000,5.392 0.000,5.393 0.000,5.393 C0.000,5.395 0.000,5.396 0.000,5.396 L0.000,5.398 C0.000,7.677 0.209,8.986 0.616,9.733 C1.015,10.490 1.443,10.627 2.314,10.690 C3.186,10.745 5.378,10.777 7.281,10.777 C9.180,10.777 11.372,10.745 12.244,10.691 C13.117,10.627 13.545,10.490 13.940,9.735 C14.350,8.988 14.558,7.678 14.558,5.399 C14.558,5.399 14.558,5.396 14.558,5.394 C14.558,5.394 14.558,5.392 14.558,5.391 C14.558,3.101 14.350,1.801 13.939,1.046 ZM5.459,8.330 L5.459,2.456 L10.009,5.393 L5.459,8.330 Z"
                                                    class="cls-1" />
                                            </svg>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="tp_footer_box">
                        <h5>@lang('master.footer.Useful_Links')</h5>
                        <ul>
                            @if (@$setting->is_check_home)
                                <li><a href="{{ route('frontend.home', app()->getLocale()) }}">@lang('master.footer.Home')</a>
                                </li>
                            @endif
                            @if (@$setting->is_check_about)
                                <li><a
                                        href="{{ route('frontend.about-us', app()->getLocale()) }}">@lang('master.footer.About_Us')</a>
                                </li>
                            @endif
                            @if (@$setting->is_check_terms_and_condition)
                                <li><a
                                        href="{{ route('frontend.terms-and-conditions', app()->getLocale()) }}">@lang('master.footer.Terms_of_services')</a>
                                </li>
                            @endif
                            @if (@$setting->is_check_privacy_policy)
                                <li><a
                                        href="{{ route('frontend.privacy-policy', app()->getLocale()) }}">@lang('master.footer.Privacy_Policy')</a>
                                </li>
                            @endif
                            @if (@$setting->is_check_contact)
                                <li><a
                                        href="{{ route('frontend.contact-us', app()->getLocale()) }}">@lang('master.footer.Contact_Us')</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                @if (@$setting->is_checked_newsletter)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="tp_footer_box">
                            <h5>@lang('master.footer.Our_Newsletter')</h5>
                            <p>
                                {{ @$setting->newsletter_text }}
                            </p>
                            <form action="{{ route('frontend.post_newsletter', app()->getLocale()) }}" method="POST"
                                id="newsletter_form">
                                @csrf
                                <div class="tp_newsletter">
                                    <input type="text" placeholder="@lang('master.footer.Enter_your_email')" id="newletter_email"
                                        name="email" />
                                    <button id="newsletter_submit_btn" class="news_post_btn" type="submit"><img
                                            src="{{ $ASSET_URL }}assets/images/news.svg" alt="Icon" />
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="tp_footer_btm">
                    <img src="{{ $ASSET_URL }}assets/images/bottomline.png" alt="bottomline" />
                    <p>Copyright © {{ date('Y') }}, {{ @$setting->copyright_text }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!--=== footer End===-->
