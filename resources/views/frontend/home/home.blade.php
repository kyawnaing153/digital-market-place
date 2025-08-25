@php
    $ASSET_URL = asset('user-theme') . '/';
    $setting = getSetting();
    $price_symbol = $setting->default_symbol ?? '$';

@endphp
@extends('frontend.layout.home_master')
@section('content')
    <section>

        <!--===How Work Start===-->
        <div class="tp_howwork_section">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    @if ($start_section->count() > 0)
                        @php $color = ['tp_work_box_blue','tp_work_box_red','tp_work_box_green',] @endphp
                        @foreach ($start_section as $key => $val)
                            <div class="col-lg-4 col-md-6 @if ($key > 2) mt-3 @endif ">
                                <div class="tp_work_box {{ @$color[$key] ?? 'tp_work_box_blue' }}">
                                    <img src="{{ $val->image }}" alt="" />
                                    <h4>{{ $val->heading }}</h4>
                                    <p>
                                        {{ $val->sub_heading }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <!--===How Work End===-->

        <!--===Categories Section Start===-->
        <div class="tp_istop_gallery">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tp_main_heading">
                            <h2>@lang('master.home.Check_Out_Our_Newest_Item')</h2>
                            <p>
                                @lang('master.home.Check_Out_heading')
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="int_project_gallery">
                            <div class="gallery_nav">
                                <ul>
                                    <li><a data-filter="*" class="gallery_active">@lang('master.home.all_categories')</a></li>
                                    @foreach (@$featured_category as $row)
                                        <li><a data-filter=".category-{{ $row->id }}"> {{ $row->name }} </a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="gallery_grid">
                                @if (!empty($products))
                                    @foreach ($products as $items)
                                        @php
                                            $path = parse_url(@$items->imageUrl, PHP_URL_PATH);
                                            $extension = pathinfo($path, PATHINFO_EXTENSION);
                                        @endphp
                                        <div class="grid-item category-{{ $items->category_id }}">
                                            <a
                                                href="{{ route('frontend.product.single_details', [app()->getLocale(), $items->slug]) }}">
                                                <div class="tp_istop_box tp-animation-box">
                                                    <div class="grid_img">
                                                        @if ($extension == 'mp4')
                                                            <span class="tp-product-list-img tp-animation">
                                                                <video width="100%" height="130px" controls controlsList="nodownload">
                                                                    <source src="{{ Storage::url($items->image) }}"
                                                                        class="tp-animation-img" alt="project-img">
                                                                </video>

                                                            </span>
                                                        @elseif($extension == 'mp3')
                                                            <span class="tp-product-list-img tp-animation">
                                                                <audio controls style="width: 100%;height: 100px;" controlsList="nodownload">
                                                                    <source src="{{ Storage::url($items->image) }}"
                                                                        class="tp-animation-img" alt="project-img">
                                                                </audio>
                                                            </span>
                                                        @else
                                                            <span class="tp-product-list-img tp-animation">
                                                                <img src="{{ $items->thumb }}" class="tp-animation-img"
                                                                    alt="project-img" />
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="tp_isbox_content">
                                                        <div class="bottom_content">
                                                            <h5>{{ $items->name }}</h5>
                                                            <p>by {{ @$items->getUser->full_name }}</p>
                                                        </div>
                                                        <div class="grid_icon">
                                                            <div class="star_rating">
                                                                @include('frontend.include.rating', [
                                                                    'faWithoutCountRating' => true,
                                                                    'rating' => @$items->rating,
                                                                ])
                                                            </div>

                                                            <span>{{ $items->sale_count ?? 0 }} @lang('master.home.sales')</span>
                                                        </div>

                                                        <div class="addto_cart tp_live_home">

                                                            @php $productPrice = $items->productPrice(); @endphp
                                                            <div class="tp_flex_price_st">
                                                                @if ($productPrice['free'])
                                                                    <p>
                                                                        @if (!empty($productPrice['price']))
                                                                            <del>{{ $price_symbol . @$productPrice['price'] }}</del>
                                                                        @endif @lang('master.home.free')
                                                                    </p>
                                                                @elseif($productPrice['price'])
                                                                    @if (@$productPrice['offer_price'])
                                                                        <p><del>{{ $price_symbol }}{{ @$productPrice['price'] }}</del>
                                                                        </p>
                                                                        <p>{{ $price_symbol }}{{ @$productPrice['offer_price'] }}
                                                                        </p>
                                                                    @else
                                                                        <p>{{ $price_symbol }}{{ @$productPrice['price'] }}
                                                                        </p>
                                                                    @endif
                                                                @else
                                                                    <p>{{ $price_symbol }}{{ @$productPrice['from'] }}</p>
                                                                    <span>-</span>
                                                                    <p>{{ $price_symbol }}{{ @$productPrice['to'] }}</p>
                                                                @endif
                                                            </div>
                                                            @if ($items->preview_link)
                                                                <a target="_blank" href="{{ $items->preview_link }}"
                                                                    class="tp_btn tp_cart_btn">@lang('master.home.live_preview')</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="tp-pro-icon">
                                                <button type="button"
                                                    @if (Auth::check()) onclick="addtoWishlist('{{ $items->slug }}')" class="watchlist_btn" @else data-bs-toggle="modal" data-bs-target="#log_modal" @endif><i
                                                        class="fa fa-heart @if (@$items->check_in_wishlist()) active @endif"
                                                        aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="tp_viewall">
                                <a href="{{ route('frontend.product.search', app()->getLocale()) }}"
                                    class="tp_btn">@lang('master.home.View_All')</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--===Categories Section End===-->

        <!--===Top Selling Section Start===-->
        <div class="tp_TopSelling_section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="tp_selling_content">
                            <h2>@lang('master.home.top_selling')<br />@lang('master.home.all_time_theme')</h2>
                            <ul>
                                <li>
                                    <img src="{{ $ASSET_URL }}assets/images/bullet.svg" alt="" />
                                    @lang('master.home.fully_responsive')

                                </li>
                                <li>
                                    <img src="{{ $ASSET_URL }}assets/images/bullet.svg" alt="" />
                                    @lang('master.home.mew_product')
                                </li>
                            </ul>
                            <h1>@lang('master.home.premium_product')</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--===Top Selling Section End===-->

        <!--=== Why Choose Start===-->
        <div class="tp_howwork_section tp_whychoose_section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tp_main_heading">
                            <h2>@lang('master.home.Why_Choose_Us')</h2>
                            <p>@lang('master.home.Why_Choose_heading')</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if ($why_choose_us->count() > 0)
                        @php $color = ['tp_work_box_blue','tp_work_box_red','tp_work_box_blue','tp_work_box_green','tp_work_box_green'] @endphp
                        @foreach ($why_choose_us as $key => $val)
                            <div class="col-lg-3 col-md-6">
                                <div class="tp_work_box {{ @$color[$key] }}">
                                    <img src="{{ $val->image }}" alt="{{ $val->heading }}" />
                                    <h4>{{ $val->heading }}</h4>
                                    <p>{{ $val->sub_heading }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <!--=== Why Choose End===-->

        <!--===Featured Product Slider Start===-->
        @if (!empty($featured_products) && count($featured_products) > 0)
            <div class="tp_uikit_section tp_feture_product">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tp_main_heading">
                                <h2>@lang('master.home.featured_product_title')</h2>
                                <p>
                                    @lang('master.home.featured_product_heading')
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            @foreach ($featured_products as $key => $items)
                                @php
                                    $extension = pathinfo($items->image, PATHINFO_EXTENSION);
                                @endphp
                                <div class="swiper-slide">
                                    <a
                                        href="{{ route('frontend.product.single_details', [app()->getLocale(), $items->slug]) }}">
                                        <div class="tp_slide_main tp-animation-box">
                                            @if ($extension == 'mp4')
                                                <div class="tp_slide_img">
                                                    <span class="tp-product-list-img tp-animation">
                                                        <video width="100%" height="180px" controls controlsList="nodownload">
                                                            <source src="{{ Storage::url($items->image) }}"
                                                                class="tp-animation-img" alt="project-img">
                                                        </video>
                                                    </span>
                                                </div>
                                            @elseif($extension == 'mp3')
                                            <div class="tp_slide_img">
                                                    <span class="tp-product-list-img tp-animation">
                                                        <audio controls style="width: 100%;height: 100px;" controlsList="nodownload">
                                                            <source src="{{ Storage::url($items->image) }}"
                                                                class="tp-animation-img" alt="project-img">
                                                        </audio>
                                                    </span>
                                                </div>
                                            @else
                                                <div class="tp_slide_img">
                                                    <span class="tp-product-list-img tp-animation">
                                                        <img src="{{ $items->thumb }}" class="tp-animation-img"
                                                            alt="Image" />
                                                    </span>
                                                </div>
                                            @endif

                                            <div class="tp_slide_content">
                                                <h5>{{ @$items->name }}</h5>
                                                <h6>by {{ @$items->getUser->full_name }}</h6>
                                                <div class="tp_rating_icon">
                                                    <div class="star_rating">
                                                        @include('frontend.include.rating', [
                                                            'faRating' => true,
                                                            'rating' => @$items->rating,
                                                        ])
                                                    </div>
                                                    <span>{{ $items->sale_count ?? 0 }} @lang('master.author.sales')</span>
                                                </div>

                                                <div class="addto_cart">
                                                    @php $productPrice = $items->productPrice(); @endphp
                                                    <div class="tp_flex_price_st">
                                                        @if ($productPrice['free'])
                                                            <p>@lang('master.home.free')</p>
                                                        @elseif($productPrice['price'])
                                                            @if (@$productPrice['offer_price'])
                                                                <p><del>{{ $price_symbol }}{{ @$productPrice['price'] }}</del>
                                                                </p>
                                                                <p>{{ $price_symbol }}{{ @$productPrice['offer_price'] }}
                                                                </p>
                                                            @else
                                                                <p>{{ $price_symbol }}{{ @$productPrice['price'] }}</p>
                                                            @endif
                                                        @else
                                                            <p>{{ $price_symbol }}{{ @$productPrice['from'] }}</p>
                                                            <span>-</span>
                                                            <p>{{ $price_symbol }}{{ @$productPrice['to'] }}</p>
                                                        @endif

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-button-next swiper-button-white"></div>
                    <div class="swiper-button-prev swiper-button-white"></div>
                </div>
            </div>
        @endif
        <!--===Featured Product Slider End===-->

        <!--===Testimonial Slider Start===-->
        @if (!empty($testimonials) && count($testimonials) > 0)
            <div class="tp_uikit_section tp_Testimonial_section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tp_main_heading">
                                <h2>@lang('master.home.testimonials_title')</h2>
                                <p>
                                    @lang('master.home.testimonials_heading')
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    @foreach ($testimonials as $key => $item)
                                        <div class="swiper-slide">
                                            <div class="tp_test_main">
                                                <div class="tp_test_img">
                                                    <img src="{{ $item->image }}" alt="Image" />
                                                </div>
                                                <div class="tp_test_text">
                                                    <p>
                                                        {{ $item->message }}
                                                    </p>
                                                    <div class="tp_test_quote">
                                                        <img src="{{ $ASSET_URL }}assets/images/border.png"
                                                            alt="Image" />
                                                        <h5>{{ $item->name }}</h5>
                                                        @if ($item->is_checked_designation)
                                                            <h6>{{ $item->designation }}</h6>
                                                        @endif
                                                        <div class="star_rating">
                                                            @include('frontend.include.rating', [
                                                                'testimonialRating' => true,
                                                                'rating' => @$item->rating,
                                                            ])
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-button-next swiper-button-white"></div>
                    <div class="swiper-button-prev swiper-button-white"></div>
                </div>
            </div>
        @endif
        <!--===Testimonial Slider End===-->
    </section>
@endsection
