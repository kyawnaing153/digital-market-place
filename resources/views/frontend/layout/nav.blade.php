<!--=== nav bar start ===-->
<div class="tp_header_box">
    <div class="tp_header_logo">
        <a href="{{ route('frontend.home', app()->getLocale()) }}">
            <img src="{{ Storage::url(@$setting->my_logo) }}" alt="logo" />
        </a>
    </div>
    <div class="tp_nav_main">
        <div class="tp_header_menu">
            <ul>
                @if (@$setting->is_check_home)
                    <li @if (Route::is('frontend.home')) class="active" @endif>
                        <a href="{{ route('frontend.home', app()->getLocale()) }}">
                            @lang('master.header.Home')
                        </a>
                    </li>
                @endif

                @if (@$setting->is_check_about)
                    <li @if (Route::is('frontend.about-us')) class="active" @endif><a
                            href="{{ route('frontend.about-us', app()->getLocale()) }}"> @lang('master.header.About_Us')</a>
                    </li>
                @endif

                @if (@$setting->is_check_product)
                    <li @if (Route::is('frontend.product.search')) class="active" @endif>
                        <a href="{{ route('frontend.product.search', app()->getLocale()) }}">
                            @lang('master.header.Products')
                        </a>
                        @php  $featured_category = getFeaturedCategory(); @endphp
                        <ul class="tp_head_dropdown">
                            <li><a
                                    href="{{ route('frontend.product.search', app()->getLocale()) }}">@lang('master.header.All_Template')</a>
                            </li>
                            @if (!empty($featured_category))
                                @foreach (@$featured_category as $row)
                                    @if ($row->subCategories->count() > 0)
                                        <li class="has_submenu"><a
                                                href="{{ route('frontend.product.search', [app()->getLocale(), 'category' => $row->slug]) }}">
                                                {{ $row->name }}
                                            </a>
                                        </li>
                                        <ul class="tp_sub_menu">
                                            @foreach ($row->subCategories as $sub_category)
                                                <li class="sub_menu">
                                                    <a
                                                        href="{{ route('frontend.product.search', [app()->getLocale(), 'category' => $sub_category->slug]) }}">
                                                        {{ $sub_category->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <li>
                                            <a
                                                href="{{ route('frontend.product.search', [app()->getLocale(), 'category' => $row->slug]) }}">
                                                {{ $row->name }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </li>
                @endif

                @if (@$setting->is_check_terms_and_condition)
                    <li @if (Route::is('frontend.terms-and-conditions')) class="active" @endif>
                        <a
                            href="{{ route('frontend.terms-and-conditions', app()->getLocale()) }}">@lang('master.header.Terms_of_services')</a>
                    </li>
                @endif

                @if (@$setting->is_check_privacy_policy)
                    <li @if (Route::is('frontend.privacy-policy')) class="active" @endif>
                        <a href="{{ route('frontend.privacy-policy', app()->getLocale()) }}">@lang('master.header.Privacy_Policy')</a>
                    </li>
                @endif

                @if (@$setting->is_check_contact)
                    <li @if (Route::is('frontend.contact-us')) class="active" @endif>
                        <a href="{{ route('frontend.contact-us', app()->getLocale()) }}">@lang('master.header.Contact_Us')</a>
                    </li>
                @endif

                @if (@$setting->is_check_language)
                    <li>
                        <a href="#">
                            <i class="fa fa-language fa-lg" aria-hidden="true"></i>
                        </a>
                        @php  $lang = getlanguage(); @endphp
                        <ul class="tp_head_dropdown">
                            @if (!empty($lang))
                                @foreach (@$lang as $row)
                                    <li>
                                        <a href="{{ route('frontend.setlang', $row->short_name) }}">
                                            {{ $row->name }} </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                @endif

            </ul>
        </div>
        <div class="tp_toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="tp_header_login ">
            @if (Auth::check())
                <div class="tp_head_logged">
                    <div class="tp_head_cart">
                        <a href="{{ route('frontend.cart.index', app()->getLocale()) }}">
                            @if (Cart::instance('default')->count() > 0)
                                <span>{{ Cart::instance('default')->count() }}</span>
                            @endif
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="tp_head_cart">
                        <a href="{{ route('frontend.wishlist', app()->getLocale()) }}">
                            <i class="fa fa-heart" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle d-block text-decoration-none" data-bs-toggle="dropdown"
                            aria-expanded="false" id="dropdownMenuLink" role="button">
                            <img src="@if (!empty(@$auth_user->avatar)) {{ @$auth_user->avatar }} @endif"
                                alt="{{ @$auth_user->full_name }}" title="{{ @$auth_user->full_name }}" width="32"
                                height="32" class="rounded-circle" />
                        </a>

                        <ul class="dropdown-menu text-small" aria-labelledby="dropdownMenuLink"
                            data-popper-placement="bottom-start">
                            <li>
                                <strong class="dropdown-item" href="#">{{ @$auth_user->full_name }}</strong>
                            </li>
                            @if (@$auth_user->role == 0)
                                {{-- admin --}}
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('admin.dashboard') }}">@lang('master.header.Dashboard')</a>
                                </li>
                            @endif
                            @if (@$auth_user->role == 2)
                                {{-- vendor --}}
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('vendor.dashboard') }}">@lang('master.header.Dashboard')</a>
                                </li>
                            @endif
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('frontend.profile', app()->getLocale()) }}">@lang('master.header.Profile')
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('frontend.profile', [app()->getLocale(), 'tab' => 'my-orders']) }}">@lang('master.header.My_Order')
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('frontend.profile', [app()->getLocale(), 'tab' => 'my-downloads']) }}">@lang('master.header.My_Downloads')
                                </a>
                            </li>
                            @if (getSettingLongText()->is_checked_author_tab)
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('frontend.profile', [app()->getLocale(), 'tab' => 'become-an-author']) }}">@lang('master.header.become_an_author')
                                    </a>
                                </li>
                            @endif
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('frontend.logout', app()->getLocale()) }}">@lang('master.header.Sign_out')
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            @else
                <a href="{{ route('frontend.sign-in', app()->getLocale()) }}" class="tp_btn">@lang('master.header.Login')</a>
            @endif
        </div>
    </div>
</div>
<!--=== nav bar end ===-->
