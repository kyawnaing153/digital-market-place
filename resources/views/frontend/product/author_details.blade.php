@extends('frontend.layout.master')
@section('head_scripts')
@endsection
@php
    $ASSET_URL = asset('user-theme') . '/';
    $price_symbol = getSetting()->default_symbol ?? '$';
@endphp
@section('content')
    <!--===Section Start===-->
    <div class="tp_proauthor_head">
        <div class="container">
            <div class="tp_authore_head">
                <a href="{{ route('frontend.user.author', [app()->getLocale(), @$product->getUser->username]) }}">
                    <div class="tp_product_box_flex tp_authore_productbox">
                        <div class="tp_product_user">
                            <img src="{{ $ASSET_URL }}assets/images/profile2.jpg" alt="Image" />
                        </div>
                        <div class="tp_john_flex">
                            <h5>{{ @$product->getUser->full_name }}</h5>
                            <p>{{ 'Member since ' . set_date_format3(@$product->getUser->created_at) }}</p>
                        </div>
                    </div>
                </a>
                <div class="tp_author_rating">
                    <div class="tp_auth_rating">
                        <h4>@lang('master.author.Author_Rating')</h4>
                        @include('frontend.include.rating', [
                            'faRating' => true,
                            'rating' => @$product->getUser->rating,
                        ])
                    </div>
                    <div class="tp_auth_rating tp_authsales_rating">
                        <h4>@lang('master.author.Sales')</h4>
                        <ul>
                            <li>
                                <img src="{{ $ASSET_URL }}assets/images/box.png" alt="Image" />
                                {{ @$product->getUser->getProductCount->count() }}
                                @lang('master.author.Products')
                            </li>
                            <li>
                                <img src="{{ $ASSET_URL }}assets/images/sales.png" alt="Image" />
                                {{ @$product->getUser->getProductSales() }} @lang('master.author.Sales')
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tp_singlepage_section">
        <div class="container">
            <form action="{{ route('frontend.user.author', [app()->getLocale(),@$product->getUser->username]) }}" method="GET">
                <div class="tp_proauth_search_section">
                    <div class="tp_search_box">
                        <input type="text" name="keyword" value="{{ request('keyword') }}"
                            placeholder="@lang('master.home.search_template_here')" />
                        <button type="submit" class="tp_btn">@lang('master.home.search')</button>
                    </div>

                    <div class="tp_view_box tp_proauth_viewbox">
                        <div class="tp_listprice_box">
                            <div class="tp_view_list">
                                <ul>
                                    <li>@lang('master.product_search.View')</li>
                                    <li>
                                        <a href="javascript:;" class="p-view grid_view" data-val="0"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="15.69" height="15.687"
                                                viewBox="0 0 15.69 15.687">
                                                <path id="_01" data-name="01" class="cls-1"
                                                    d="M1175.17,459.1h3.92v3.918h-3.92V459.1Zm-5.87-5.876h3.91v3.917h-3.91v-3.917Zm5.87,11.753h3.92V468.9h-3.92v-3.917Zm-5.87-5.877h3.91v3.918h-3.91V459.1Zm0,5.877h3.91V468.9h-3.91v-3.917Zm11.75-11.753h3.92v3.917h-3.92v-3.917Zm-5.88,0h3.92v3.917h-3.92v-3.917Zm5.88,5.876h3.92v3.918h-3.92V459.1Zm0,5.877h3.92V468.9h-3.92v-3.917Z"
                                                    transform="translate(-1169.28 -453.219)" />
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="p-view list_view active" data-val="1"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="15.75" height="15.75"
                                                viewBox="0 0 15.75 15.75">
                                                <path id="_02" data-name="02" class="cls-1"
                                                    d="M1211.49,453.131h-2.26v2.251h2.26v-2.251Zm0,4.5h-2.26v2.251h2.26v-2.251Zm-2.26,4.5h2.26v2.251h-2.26v-2.251Zm2.26,4.5h-2.26v2.251h2.26v-2.251Zm13.5-13.506h-11.25v2.251h11.25v-2.251Zm0,4.5h-11.25v2.251h11.25v-2.251Zm-11.25,4.5h11.25v2.251h-11.25v-2.251Zm11.25,4.5h-11.25v2.251h11.25v-2.251Z"
                                                    transform="translate(-1209.25 -453.125)" />
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tp_select_box tp_price_box">
                                <label>@lang('master.product_search.Sort_By')</label>
                                <select class="tp_nice_select" name="sort_by" onchange="this.form.submit()">
                                    <option value="price-asc" {{ request('sort_by') == 'price-asc' ? 'selected' : '' }}>
                                        @lang('master.author.Price_ASC')</option>
                                    <option value="price-desc" {{ request('sort_by') == 'price-desc' ? 'selected' : '' }}>
                                        @lang('master.author.Price_DESC')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="tp_proauth_formproduct">
                <form id="product-search-form" action="{{ route('frontend.product.postsearch', app()->getLocale()) }}"
                    method="post">
                    @csrf

                    <div class="row">
                        @if ($data->count() > 0)
                            @foreach ($data as $key => $items)
                                @php
                                    $extension = pathinfo(@$items->imageUrl, PATHINFO_EXTENSION);
                                @endphp
                                <div class="col-lg-4 col-md-6 tp_single_grid product_list_view">
                                    <div class="tp_istop_box">
                                        <a
                                            href="{{ route('frontend.product.single_details', [app()->getLocale(), $items->slug]) }}">
                                            <div class="grid_img">
                                                @if ($extension == 'mp4')
                                                    <span class="tp-product-list-img tp-animation">
                                                        <video width="100%" height="130px" controls controlsList="nodownload">
                                                            <source src="{{ Storage::url(@$items->image) }}"
                                                                class="tp-animation-img" alt="project-img">
                                                        </video>
                                                        @if ($items->is_offer == 2)
                                                            <div class="tp_sales"><span>@lang('master.author.Sales')</span></div>
                                                        @endif
                                                    </span>
                                                @elseif($extension == 'mp3')
                                                  <span class="tp-product-list-img tp-animation">
                                                        <audio controls controlsList="nodownload"  style="width: 100%;height: 100px;">
                                                            <source src="{{ Storage::url(@$items->image) }}"
                                                                class="tp-animation-img" alt="project-img">
                                                        </audio>
                                                        @if ($items->is_offer == 2)
                                                            <div class="tp_sales"><span>@lang('master.author.Sales')</span></div>
                                                        @endif
                                                    </span>

                                                @else
                                                    <span class="tp-product-list-img tp-animation">
                                                        <img src="{{ $items->imageUrl }}" class="tp-animation-img"
                                                            alt="project-img" />
                                                        @if ($items->is_offer == 2)
                                                            <div class="tp_sales"><span>@lang('master.author.Sales')</span></div>
                                                        @endif
                                                    </span>
                                                @endif

                                            </div>

                                            <div class="tp_isbox_content">
                                                <div class="bottom_content">
                                                    <h5>{{ $items->name }}</h5>
                                                    <p>@lang('master.product_search.by') {{ $items->getUser->full_name }}</p>
                                                </div>
                                                <div class="tp_wishlist_text">
                                                    <p>
                                                        {!! $items->short_desc !!}
                                                    </p>
                                                </div>
                                                <div class="grid_icon">
                                                    <div class="star_rating">
                                                        @include('frontend.include.rating', [
                                                            'faRating' => true,
                                                            'rating' => @$items->rating,
                                                        ])
                                                    </div>
                                                    <span>{{ $items->sale_count }}@lang('master.author.Sales')</span>
                                                </div>
                                                <div class="addto_cart">
                                                    @php $productPrice = $items->productPrice(); @endphp
                                                    <div class="tp_flex_price_st">
                                                        @if ($productPrice['free'])
                                                            <p>
                                                                @if (!empty($productPrice['price']))
                                                                    <del>{{ $price_symbol . @$productPrice['price'] }}</del>
                                                                @endif @lang('master.wishlist_product.free')
                                                            </p>
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
                                        </a>
                                        <div class="addto_cart addto_cart_btn">
                                            <a target="_blank" href="{{ $items->preview_link }}"
                                                class="tp_btn tp_cart_btn">@lang('master.author.Live_Preview')</a>
                                            <button type="button"
                                                @if (Auth::check()) onclick="addtoWishlist('{{ $items->slug }}')" class="active_red tp_btn tp_btn_wish watchlist_btn" @else data-bs-toggle="modal" data-bs-target="#log_modal" class="active_red tp_btn tp_btn_wish" @endif>
                                                <i class="fa fa-heart @if (@$items->check_in_wishlist()) active @endif"
                                                    aria-hidden="true"></i>
                                                @lang('master.product_search.add_to_wishlist')</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center tp_noproduct">
                                <img src="{{ $ASSET_URL }}assets/images/product_not_found2.png">
                                <p class="text-center">@lang('master.product_search.product_not_found')</p>
                            </div>
                        @endif
                        <div class="tp-pagination-wrapper">
                            {{ @$data->links() }}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--===Section End===-->
@endsection
@section('scripts')
    <script src="{{ asset('user-theme/my_assets/js/product.js') }}"></script>
@endsection
