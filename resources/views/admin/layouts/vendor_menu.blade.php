<!--=== start side bar ===-->
<div class="tp_sidebar">
    <div class="sidebar-top-wrapper">
        <a href="{{ route('vendor.dashboard') }}">
            <img src="{{ Storage::url(getSettingShortValue('my_logo')) }}" alt="logo" />
        </a>
    </div>
    <div class="tp_sidebar_manu">
        <ul class="tp_mainmenu">
            <li>
                <a href="{{ route('vendor.dashboard') }}">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" fill="#2a3547"
                            viewBox="0 0 491.5 491.5" xmlns:v="https://vecta.io/nano">
                            <path
                                d="M445.4 33.8H261.1V15.4c0-8.7-6.7-15.4-15.4-15.4s-15.4 6.7-15.4 15.4v18.4H46.1c-8.7 0-15.4 6.7-15.4 15.4v257.5h430.1V49.2c0-8.8-6.7-15.4-15.4-15.4zm30.8 298.5H15.4c-8.2 0-15.4 7.2-15.4 15.4 0 8.7 6.7 15.4 15.4 15.4h199.2L124 458.8c-5.6 6.1-5.6 15.9.5 21.5s15.9 5.6 21.5-.5l84.5-89.1v85.5c0 8.7 6.7 15.4 15.4 15.4s15.4-6.7 15.4-15.4v-85.5l84.5 89.1c5.6 6.1 15.4 6.7 21.5.5 6.1-5.6 6.7-15.4.5-21.5L277 363h199.2c8.7 0 15.4-6.7 15.4-15.4s-6.7-15.3-15.4-15.3h0z" />
                        </svg>
                    </span>
                    <p>My Board</p>
                </a>
            </li>
            <li class="has-sub-menu @if (Route::is('vendor.product.*') || Route::is('vendor.subcategory.*') || Route::is('vendor.pro_category.*')) active @endif ">
                <a>
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 468 468" width="18px" height="18px"
                            fill="#2a3547" xmlns:v="https://vecta.io/nano">
                            <path
                                d="M0 191.1l168.9 96.7 43.9-55.1-177.9-93.9L0 191.1zm254.7 41.4l44.1 55.3L468 190.9 432.6 135l-177.9 97.5zM60.6 121.4l173.1 91.4 173.4-95.1-173-81.7-173.5 85.4zM44.1 339.1l176 92.9V267.5L183 314.1c-4.2 5.3-11.6 6.7-17.5 3.4L44.1 247.9v91.2zm203.4-71.6v164l176-96.7v-87l-121.4 69.5c-5.9 3.4-13.3 1.9-17.5-3.4l-37.1-46.4z" />
                        </svg>
                    </span>
                    <p>Products</p> 
                </a>
                <ul class="tp_submenu">
                    <li @if (Route::is('vendor.pro_category.*')) class="active" @endif><a
                            href="{{ route('vendor.pro_category.index') }}">Categories</a></li>
                    <li @if (Route::is('vendor.subcategory.*')) class="active" @endif><a
                            href="{{ route('vendor.subcategory.index') }}">Sub Categories</a></li>

                    <li @if (Route::is('vendor.product.*')) class="active" @endif><a
                            href="{{ route('vendor.product.index') }}">Products</a></li>
                </ul>
            </li>

            <li @if (Route::is('vendor.discount_coupon.*')) class="active" @endif>
                <a href="{{ route('vendor.discount_coupon.index') }}">
                    <span class="">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="18px" height="18px"
                            fill="#2a3547" xmlns:v="https://vecta.io/nano">
                            <path
                                d="M478 262.6c-2.1-4.2-2.1-9.1 0-13.3l19.1-39.1c10.6-21.8 2.2-47.7-19.2-59l-38.4-20.4c-4.1-2.2-7-6.1-7.8-10.7l-7.5-42.8A44.46 44.46 0 0 0 374 40.9L330.9 47c-4.6.7-9.3-.8-12.6-4.1L287 12.6c-17.4-16.8-44.7-16.8-62.1 0l-31.3 30.2c-3.3 3.3-8 4.8-12.6 4.1l-43.1-6.1c-24-3.4-46 12.6-50.2 36.5l-7.5 42.8c-.8 4.6-3.7 8.6-7.8 10.7L34 151.2c-21.4 11.3-29.8 37.3-19.2 59L34 249.4c2.1 4.2 2.1 9.1 0 13.3l-19.1 39.1c-10.6 21.8-2.2 47.7 19.2 59l38.4 20.4c4.1 2.2 7 6.1 7.8 10.7l7.5 42.8c3.8 21.7 22.4 36.9 43.8 36.9 2.1 0 4.2-.1 6.4-.5l43.1-6.1c4.6-.7 9.3.8 12.6 4.1l31.3 30.2c8.7 8.4 19.9 12.6 31 12.6 11.2 0 22.3-4.2 31-12.6l31.3-30.2c3.4-3.3 8-4.8 12.6-4.1l43.1 6.1c24 3.4 46-12.6 50.2-36.5l7.5-42.8c.8-4.6 3.7-8.6 7.8-10.7l38.4-20.4c21.4-11.3 29.8-37.3 19.2-59L478 262.6h0zM196.9 123.1c29.9 0 54.1 24.3 54.1 54.1s-24.3 54.1-54.1 54.1-54.1-24.3-54.1-54.1 24.3-54.1 54.1-54.1h0zM169 363.9c-2.9 2.9-6.7 4.3-10.4 4.3s-7.6-1.4-10.4-4.3c-5.8-5.8-5.8-15.1 0-20.9L343 148.1c5.8-5.8 15.1-5.8 20.9 0s5.8 15.1 0 20.9L169 363.9zm146.1 25c-29.9 0-54.1-24.3-54.1-54.1s24.3-54.1 54.1-54.1c29.9 0 54.1 24.3 54.1 54.1s-24.3 54.1-54.1 54.1zm0-78.8c-13.6 0-24.6 11-24.6 24.6s11 24.6 24.6 24.6 24.6-11 24.6-24.6-11.1-24.6-24.6-24.6zM196.9 152.6c-13.6 0-24.6 11-24.6 24.6s11 24.6 24.6 24.6 24.6-11 24.6-24.6c0-13.5-11-24.6-24.6-24.6z" />
                        </svg>
                    </span>
                    <p>Discount Coupon</p>
                </a>
            </li>

            <li class="has-sub-menu  @if (Route::is('vendor.users.*')) active @endif">
                <a><span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" fill="#2a3547"
                            viewBox="0 0 512 512" xmlns:v="https://vecta.io/nano">
                            <path
                                d="M438.1 273.3h-39.6c4 11 6.2 23 6.2 35.4v149.6a45.07 45.07 0 0 1-2.5 14.8h65.5c24.5 0 44.3-19.9 44.3-44.3v-81.6c0-40.7-33.2-73.9-73.9-73.9zm-330.8 35.4c0-12.4 2.2-24.4 6.2-35.4H73.9C33.2 273.3 0 306.5 0 347.2v81.6c0 24.5 19.9 44.3 44.3 44.3h65.5c-1.7-4.7-2.5-9.7-2.5-14.8V308.7h0zm194-73.9h-90.5c-40.8 0-73.9 33.2-73.9 73.9v149.6a14.77 14.77 0 0 0 14.8 14.8h208.8a14.77 14.77 0 0 0 14.8-14.8V308.7c-.1-40.7-33.3-73.9-74-73.9zM256 38.8c-49 0-88.9 39.9-88.9 88.9 0 33.2 18.3 62.3 45.4 77.5 12.9 7.2 27.7 11.4 43.4 11.4s30.6-4.1 43.4-11.4c27.1-15.2 45.4-44.3 45.4-77.5.2-49-39.7-88.9-88.7-88.9h0zM99.9 121.7c-36.7 0-66.5 29.8-66.5 66.5s29.8 66.5 66.5 66.5c9 0 17.9-1.8 26.2-5.4 13.9-6 25.4-16.6 32.5-29.9 5.1-9.6 7.8-20.3 7.8-31.2 0-36.7-29.8-66.5-66.5-66.5zm312.2 0c-36.7 0-66.5 29.8-66.5 66.5 0 10.9 2.7 21.6 7.8 31.2 7.1 13.3 18.6 23.9 32.5 29.9 8.3 3.6 17.2 5.4 26.2 5.4 36.7 0 66.5-29.8 66.5-66.5s-29.9-66.5-66.5-66.5z" />
                        </svg>
                    </span>
                    <p>customer</p>
                </a>
                <ul class="tp_submenu">
                    <li><a href="{{ route('admin.users.index') }}">Users List</a></li>
                </ul>
            </li>
            <li class="has-sub-menu">
                <a>
                    <span class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" fill="#2a3547"
                            viewBox="0 0 32 32" xmlns:v="https://vecta.io/nano">
                            <path
                                d="M31 12c0 .3-.1.5-.3.7l-6 6c-.2.2-.4.3-.7.3-.1 0-.3 0-.4-.1-.4-.1-.6-.5-.6-.9v-3h-9a.94.94 0 0 1-1-1v-4a.94.94 0 0 1 1-1h9V6c0-.6.5-1 1-1 .3 0 .5.1.7.3l6 6c.2.2.3.4.3.7zm-13 5H9v-3c0-.4-.2-.8-.6-.9-.4-.2-.8-.1-1.1.2l-6 6c-.2.2-.3.4-.3.7s.1.5.3.7l6 6c.2.2.4.3.7.3.1 0 .3 0 .4-.1.4-.1.6-.5.6-.9v-3h9a.94.94 0 0 0 1-1v-4a.94.94 0 0 0-1-1z" />
                        </svg>
                    </span>
                    <p>Transactions</p>
                </a>
                <ul class="tp_submenu">
                    <li><a href="{{ route('vendor.order.index') }}">List</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!--=== end side bar ===-->
