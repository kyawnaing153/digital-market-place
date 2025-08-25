@extends('frontend.layout.master')
@section('head_scripts')
    @php
        $ASSET_URL = asset('user-theme') . '/';
        $price_symbol = getSetting()->default_symbol ?? '$';
    @endphp
    <title>@lang('page_title.Frontend.wishlist_title')</title>
    <meta name="keywords" content="@lang('page_title.Frontend.wishlist_keyword')" />
    <meta name="description" content="@lang('page_title.Frontend.wishlist_desc')" />
@endsection
@section('content')
    <!--===Header Section Start===-->
    <div class="tp_banner_section tp_single_section">
        <div class="container">
            <div class="tp_banner_heading">
                <h2>@lang('master.wishlist_product.wishlist')</h2>
                <p>
                    @lang('master.wishlist_product.heading_wishlist')
                </p>
            </div>
        </div>
    </div>
    <!--===Header Section End===-->
    <!--===cart Section Start===-->
    <div class="tp_singlepage_section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp_view_box">
                        <div class="tp_view_text">
                            <h2><i class="fa fa-heart" aria-hidden="true"></i> @lang('master.wishlist_product.wishlist_list')</h2>
                        </div>
                    </div>
                </div>
                @if (!empty($wishlist) && count($wishlist) > 0)
                    <div class="tp_single_grid product_list_view">
                        @foreach ($wishlist as $key => $item)
                            @php
                                $extension = pathinfo(@$item->getProduct->imageUrl, PATHINFO_EXTENSION);
                            @endphp

                            <div class="tp_istop_box">
                                <a
                                    href="{{ route('frontend.product.single_details', [app()->getLocale(), $item->getProduct->slug]) }}">
                                    <div class="grid_img">
                                        @if ($extension == 'mp4')
                                            <span class="tp-product-list-img tp-animation">
                                                <video width="100%" height="100%" controls controlsList="nodownload">
                                                    <source src="{{ Storage::url(@$item->getProduct->image) }}"
                                                        class="tp-animation-img" alt="project-img">
                                                </video>
                                            </span>
                                        @elseif($extension == 'mp3')
                                            <span class="tp-product-list-img tp-animation">
                                                <audio controls controlsList="nodownload" style="width: 100%;height: 100px;">
                                                    <source src="{{ Storage::url(@$item->getProduct->image) }}"
                                                        class="tp-animation-img" alt="project-img">
                                                </audio>
                                            </span>
                                        @else
                                            <span class="tp-product-list-img tp-animation">
                                                <img src="{{ @$item->getProduct->imageUrl }}" class="tp-animation-img"
                                                    alt="project-img" />
                                            </span>
                                        @endif
                                    </div>
                                </a>
                                <div class="tp_isbox_content">
                                    <div class="bottom_content">
                                        <h5>{{ @$item->getProduct->name }}</h5>
                                        <p>by {{ @$item->getProduct->getUser->full_name }}</p>
                                    </div>
                                    <div class="tp_wishlist_text">
                                        <p>
                                            {{ @$item->getProduct->short_desc }}
                                        </p>
                                    </div>
                                    <div class="addto_cart tp_flex_price_st">
                                        <h4>
                                            @php $productPrice = $item->getProduct->productPrice(); @endphp
                                            @if ($productPrice['free'])
                                                <p>
                                                    @if (!empty($productPrice['price']))
                                                        <del>{{ $price_symbol . @$productPrice['price'] }}</del>
                                                    @endif
                                                    @lang('master.wishlist_product.free')
                                                </p>
                                            @elseif($productPrice['price'])
                                                @if (@$productPrice['offer_price'])
                                                    <div class="tp_flex_price_st">
                                                        <p><del>{{ $price_symbol }}{{ @$productPrice['price'] }}</del></p>
                                                        <p>{{ $price_symbol }}{{ @$productPrice['offer_price'] }}</p>
                                                    </div>
                                                @else
                                                    <p>{{ $price_symbol }}{{ @$productPrice['price'] }}</p>
                                                @endif
                                            @else
                                                <div class="tp_flex_price_st">

                                                    <p>{{ $price_symbol }}{{ @$productPrice['from'] }}</p>
                                                    <span>-</span>
                                                    <p>{{ $price_symbol }}{{ @$productPrice['to'] }}</p>
                                            @endif
                                        </h4>
                                    </div>
                                </div>
                                <div class="tp_overlay_btn">
                                    <form
                                        action="{{ route('frontend.wishlist.remove', [app()->getLocale(), 'id' => $item->id]) }}"
                                        method="POST" id="delete-item">
                                        @csrf()
                                        <button type="submit" class="tp_btn"><img
                                                src="{{ $ASSET_URL }}assets/images/delete.png"
                                                alt="Image" />@lang('master.wishlist_product.remove')</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>@lang('master.wishlist_product.no_item_found') <a
                            href="{{ route('frontend.product.search', app()->getLocale()) }}">@lang('master.cart.add_now')</a></p>
                @endif
            </div>
        </div>
    </div>
    <!--===cart Section End===-->

    <div class="tp_uikit_section tp_uikit_product">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp_main_heading">
                        <h2>@lang('master.wishlist_product.recently_viewed')</h2>
                    </div>
                </div>
            </div>
            <!--===include related Product ===-->
            @include('frontend.include.related-product', ['product_items' => @$product_items]);
            <!--===include related End===-->
        </div>
    </div>
@endsection
@section('scripts')
    <script></script>
@endsection
