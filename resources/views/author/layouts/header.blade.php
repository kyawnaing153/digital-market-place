<!--=== Start Header===-->
<div class="tp_header_wrappo">
    <div class="tp_header">
        <div class="tp_header_inner_wrapper">
            <div class="tp_welcome">
                <p>Hi, {{ @$auth_user->full_name }}</p>
            </div>
            <div class="tp_preview_box_wrapper">
                <div class="tp_profile_box">
                    <span>ad</span>
                    <div class="tp_profile_open">
                        <ul>
                            <li><a href="{{ route('vendor.profile') }}"><i class="fa fa-lock" aria-hidden="true"></i>
                                    Profile</a></li>
                            <li><a href="{{ route('vendor.logout') }}"><i class="fa fa-power-off"
                                        aria-hidden="true"></i>logout</a></li>
                        </ul>
                    </div>
                </div>
                <div class="tp_priview_box">
                    <p><a href="{{ route('frontend.home', app()->getLocale()) }}" target="_blank">Preview Site
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20" height="19">
                                <path
                                    d="M0 0 C6.6 0 13.2 0 20 0 C20 5.28 20 10.56 20 16 C18.02 16.33 16.04 16.66 14 17 C14.66 17.66 15.32 18.32 16 19 C12.04 19 8.08 19 4 19 C4.66 18.34 5.32 17.68 6 17 C4.02 16.67 2.04 16.34 0 16 C0 10.72 0 5.44 0 0 Z M1 2 C1 4.64 1 7.28 1 10 C6.94 10 12.88 10 19 10 C19 7.36 19 4.72 19 2 C17.17883997 0.17883997 14.69328236 0.8676492 12.2734375 0.86328125 C11.14808594 0.86908203 11.14808594 0.86908203 10 0.875 C9.24976563 0.87113281 8.49953125 0.86726563 7.7265625 0.86328125 C4.06393883 0.52324459 4.06393883 0.52324459 1 2 Z M1 12 C1 12.66 1 13.32 1 14 C3.64 14 6.28 14 9 14 C9 13.34 9 12.68 9 12 C6.36 12 3.72 12 1 12 Z M11 12 C11 12.66 11 13.32 11 14 C13.64 14 16.28 14 19 14 C19 13.34 19 12.68 19 12 C16.36 12 13.72 12 11 12 Z M9 16 C9 16.66 9 17.32 9 18 C9.66 18 10.32 18 11 18 C11 17.34 11 16.68 11 16 C10.34 16 9.68 16 9 16 Z "
                                    fill="var(--theme-color)" transform="translate(0,0)" />
                                <path
                                    d="M0 0 C0.66 0 1.32 0 2 0 C1.1875 1.9375 1.1875 1.9375 0 4 C-0.99 4.33 -1.98 4.66 -3 5 C-1.125 1.125 -1.125 1.125 0 0 Z "
                                    fill="{{ $primary_color }}" transform="translate(9,3)" />
                                <path
                                    d="M0 0 C0.66 0 1.32 0 2 0 C1.67 0.99 1.34 1.98 1 3 C0.34 3 -0.32 3 -1 3 C-0.67 2.01 -0.34 1.02 0 0 Z "
                                    fill="{{ $primary_color }}" transform="translate(11,5)" />
                            </svg>
                        </a></p>
                </div>
                <div class="tp_menu">
                    <div class="menu_toggle">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--=== End Header ===-->
