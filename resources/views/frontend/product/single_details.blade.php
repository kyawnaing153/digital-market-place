@php
    $ASSET_URL = asset('user-theme') . '/';
    $price_symbol = getSetting()->default_symbol ?? '$';
@endphp
@extends('frontend.layout.master')
@section('head_scripts')
    @php
        $mUrl = Request::url();
        $mImage = Storage::url(getSettingShortValue('preview_image'));
        $mTitle = @$product->meta_title;
        $mDescr = @$product->meta_desc;
        $mKWords = @$product->meta_keywords;
    @endphp
    <title>{{ @$mTitle }}</title>
    <meta name="keywords" content="{{ @$mKWords }}" />
    <meta name="description" content="{{ @$mDescr }}" />
    <meta property=og:locale content="{{ app()->getLocale() }}" />
    <meta property=og:type content=website />
    <meta property="og:site_name" content="Coin Gabbar" />
    <meta property="og:title" content="{{ @$mTitle }}" />
    <meta property="og:description" content="{{ @$mDescr }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ @$mImage }}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta property="twitter:title" content="{{ @$mTitle }}" />
    <meta property="twitter:description" content="{{ @$mDescr }}" />
    <meta property="twitter:url" content="{{ url()->current() }}" />
    <meta property="twitter:image" content="{{ @$mImage }}" />
    <meta name="twitter:site" content="@themeportal" />
    <meta name="twitter:creator" content="@themeportal" />
@endsection
@section('content')
    <!--===Single Product Details Section Start===-->
    <div class="tp_singlepage_section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp_in2_text">
                        <h2>
                            {{ @$product->name }}
                        </h2>
                        <p>By<span> {{ @$product->getUser->full_name }}</span></p>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-7 col-md-12">
                    <div class="tp_template_box">
                        @php
                            $extension = pathinfo($product->image, PATHINFO_EXTENSION);
                        @endphp
                        
                        @if ($extension == 'mp4')
                            <div class="tp_video_icon">
                                <video width="620" height="240" controls controlsList="nodownload">
                                    <source src="{{ Storage::url($product->image) }}" type="video/mp4">
                                </video>
                            </div>
                        @elseif($extension == 'mp3')
                        <div class="tp_video_icon">
                                <audio controls controlsList="nodownload" style="width: 100%;height: 100px;">
                                    <source src="{{ Storage::url($product->image) }}" type="audio/mp3">
                                </audio>
                            </div>
                        @else
                            <div class="tp_tem_thumb">
                                <div class="tp_preview_icon">
                                    <img src="{{ $product->imageUrl }}" alt="Image" />
                                    @if (!empty($product->preview_link))
                                        <a href="{{ @$product->preview_link }}" class="preview_icon_overlay"
                                            target="_blank">
                                            <img src="{{ $ASSET_URL }}assets/images/preview-icon.png"
                                                alt="Image" /></a>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="gallery_nav tp_tem_tab_buttom">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-home" type="button" role="tab"
                                        aria-controls="pills-home" aria-selected="true">
                                        @lang('master.single_product.description')
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-profile" type="button" role="tab"
                                        aria-controls="pills-profile" aria-selected="false">
                                        @lang('master.single_product.previews')
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-contact" type="button" role="tab"
                                        aria-controls="pills-contact" aria-selected="false">
                                        @lang('master.single_product.reviews')
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-Comments-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-Comments" type="button" role="tab"
                                        aria-controls="pills-Comments" aria-selected="false">
                                        @lang('master.single_product.comments')
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                <div class="tp_tem_description">
                                    {!! @$product->description !!}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab">
                                <div class="tp_tem_previews">
                                    <h3> @lang('master.single_product.previews_nd_screenshots')</h3>
                                    @if (!empty($product_meta->preview_imgs))
                                        @php $preview_imgs_arr = (object) unserialize(@$product_meta->preview_imgs); @endphp
                                        @foreach ($preview_imgs_arr as $key => $value)
                                            @php
                                                $prev_path = parse_url(getImage($value), PHP_URL_PATH);
                                                $prev_extension = pathinfo($prev_path, PATHINFO_EXTENSION);
                                            @endphp
                                            @if ($prev_extension == 'mp4')
                                                <video width="552px" height="534px" controls>
                                                    <source src="{{ getImage($value) }}"alt="Preview Image"
                                                        loading="lazy">
                                                </video>
                                            @else
                                                <img src="{{ getImage($value) }}" alt="Preview Image" loading="lazy" />
                                            @endif
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                aria-labelledby="pills-contact-tab">
                                <div class="tp_tem_comments tp_tem_reviews">
                                    <div class="tp_filter_box">
                                        <div class="tp_fil_text">
                                            <h3>
                                                <img src="{{ $ASSET_URL }}assets/images/three_star.png"
                                                    alt="Image" />
                                                {{ @$product->getProductReview->count() }} @lang('master.single_product.Reviews_for_this_product')
                                            </h3>
                                        </div>
                                        <div class="tp_fil_range">
                                            <ul>
                                                <li>@lang('master.single_product.filter_by_rating')</li>
                                                <li>
                                                    <div class="tp_select_box">
                                                        <select class="wide tp_nice_select" id="filter_rating"
                                                            onchange="search_rating()">
                                                            <option value="">Star</option>
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <option value="{{ $i }}">{{ $i }}
                                                                    @lang('master.single_product.Star')</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tp_comments_box" id="review_search_box">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-Comments" role="tabpanel"
                                aria-labelledby="pills-Comments-tab">
                                <div class="tp_tem_comments">
                                    <div class="tp_comm_box">
                                        <form method="POST" id="add-product-comment-form">
                                            @csrf
                                            <div class="form-outline form-white">
                                                <label class="form-label fw-semibold"
                                                    for="comment">@lang('master.single_product.add_comment')</label>
                                                <textarea name="comment" rows="3" cols="30" class="form-control comment comment-text-area"
                                                    placeholder="Add a comment here...1" @if (!Auth::check()) disabled @endif></textarea>
                                                <button class="tp_btn tp_btn_post"
                                                    @if (!Auth::check()) data-bs-toggle="modal" data-bs-target="#log_modal" type="button" @else type="submit" @endif
                                                    id="add-product-comment-form-btn">@lang('master.single_product.post_comment')</button>
                                            </div>
                                            <input type="hidden" name="product_id" id="product_id"
                                                value="{{ @$product->id }}">
                                        </form>
                                    </div>
                                    <div class="tp_filter_box">
                                        <div class="tp_fil_text">
                                            <h3>
                                                <img src="{{ $ASSET_URL }}assets/images/comment_icon.png"
                                                    alt="Image" />
                                                {{ @$product->getProductComment->count() }} @lang('master.single_product.comments_found')
                                            </h3>
                                        </div>
                                        <div class="tp_fil_range">
                                            <ul>
                                                <li>@lang('master.single_product.Filter_By')</li>
                                                <li>
                                                    <div class="tp_select_box">
                                                        <select onchange="search_comment()" id="filter_month"
                                                            class="tp_nice_select">
                                                            <option value=""> @lang('master.single_product.Month')
                                                            </option>
                                                            @for ($m = 1; $m <= 12; $m++)
                                                                @php $month = date('M', mktime(0,0,0,$m, 1, date('Y'))); @endphp
                                                                <option value="{{ $m }}">
                                                                    {{ $month }}</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="tp_select_box">
                                                        <select onchange="search_comment()" id="filter_year"
                                                            class="wide tp_nice_select">
                                                            <option value="" selected> @lang('master.single_product.Year')
                                                            </option>
                                                            <option value="{{ date('Y') }}">{{ date('Y') }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tp_comments_box" id="cmd_search_box">
                                    </div>
                                    <div class="text-center mt-2">
                                        <button type="button" class="tp_btn border rounded-pill d-none"
                                            id="load_more_cmd_button" data="2">@lang('master.product_search.Loadmore')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tp_add_image" id="advertize-ad"></div>
                </div>
                <div class="col-xl-4 col-lg-5 col-md-12">
                    <form id="add-to-card-form" method="POST">
                        <div class="tp_sidebar_category tp_sidebar_category_single">
                            <div class="tp_leftbar_box">
                                @if (@$product->is_free == '1')
                                    <div class="tp_flex_price">
                                        <p>@lang('master.single_product.Price')</p>
                                        <div class="tp_lowprice">
                                            <h2>
                                                @if (!empty($product->price))
                                                    <del class="small text-muted">{{ $price_symbol . @$product->price }}</del>
                                                @endif @lang('master.single_product.Free')
                                            </h2>
                                        </div>
                                    </div>
                                @else
                                    @if (@$product->is_enable_multi_price == 1 && isset($product_meta->multi_price) && !empty($product_meta->multi_price))
                                        @php $priceArr = (object) unserialize(@$product_meta->multi_price); @endphp
                                        @foreach ($priceArr as $key => $value)
                                            <div class="tp_flex_price form-check">
                                                <input class="form-check-input"
                                                    @if (@$product_meta->enable_multi_option == 1) type="checkbox" @else type="radio" @endif
                                                    value="{{ @$value['price_id'] }}" name="price_id[]"
                                                    @if (@$value['default_price'] == 1) checked @endif>
                                                <p>{{ @$value['option_name'] }}</p>

                                                <div class="tp_lowprice">
                                                    @if (!empty(@$value['offer_price']) && @$product->is_offer != 0)
                                                        <h2><span>{{ $price_symbol . @$value['price'] }}</span>
                                                            {{ $price_symbol . @$value['offer_price'] }}
                                                        </h2>
                                                    @else
                                                        <h2>{{ $price_symbol . @$value['price'] }}</h2>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="tp_flex_price">
                                            <p>@lang('master.product_search.Price')</p>
                                            <div class="tp_lowprice">
                                                @if (@$product->is_offer != '0')
                                                    <h2><span>{{ $price_symbol . @$product->price }}</span>
                                                        {{ $price_symbol . @$product->offer_price }}
                                                    </h2>
                                                @else
                                                    <h2><span></span>{{ $price_symbol . @$product->price }}</h2>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <div class="tp_leftbar_box">
                            <div class="tp_tem_option">
                                <div class="grid_icon">
                                    <div class="star_rating">
                                        @include('frontend.include.rating', [
                                            'faRating' => true,
                                            'rating' => @$product->rating,
                                        ])
                                    </div>
                                    <span><img src="{{ $ASSET_URL }}assets/images/sales.png" alt="sale-img" />
                                        {{ @$product->sale_count }}
                                        @lang('master.single_product.sales')</span>
                                </div>
                                <div class="tp_buy_btn">
                                    <a onclick="addToCart('',1)" class="tp_btn"><img
                                            src="{{ $ASSET_URL }}assets/images/buynow.png"
                                            alt="Image" />@lang('master.product_search.buy_now')
                                    </a>

                                    <button type="button" onclick="addToCart()" class="tp_btn"><img
                                            src="{{ $ASSET_URL }}assets/images/addtocart.png" alt="Image" />
                                        @lang('master.single_product.add_to_cart')
                                    </button>
                                    @if (isset($product->preview_link) && !empty($product->preview_link))
                                        <a target="_blank" href="{{ $product->preview_link }}" class="tp_btn"><img
                                                src="{{ $ASSET_URL }}assets/images/live_preview.png"
                                                alt="Image" />@lang('master.product_search.live_preview')</a>
                                    @endif

                                    <input type="hidden" name="slug" value="{{ $product->slug }}">


                                    <button type="button"
                                        @if (Auth::check()) onclick="addtoWishlist('{{ $product->slug }}')" class="active_red tp_btn tp_btn_wish watchlist_btn" @else data-bs-toggle="modal" data-bs-target="#log_modal" class="active_red tp_btn tp_btn_wish" @endif><i
                                            class="fa fa-heart @if (@$product->check_in_wishlist()) active @endif"
                                            aria-hidden="true"></i>@lang('master.single_product.add_to_wishlist')</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="tp_leftbar_box">
                        <div class="tp_product_detailhead">
                            <h4>@lang('master.single_product.product_details')</h4>
                        </div>
                        <div class="tp_product_detail">
                            <ul>
                                @if (!empty($product->published_at))
                                    <li> @lang('master.single_product.Last_Update') <span>{{ set_date_format2(@$product->last_modified) }}</span></li>
                                    <li> @lang('master.single_product.Published') <span>{{ set_date_format2(@$product->published_at) }}</span></li>
                                @endif
                                @if (@$product->product_details[0])
                                    @foreach (@$product->product_details as $key => $val)
                                        <li>{{ @$val['key'] }}<span>{{ @$val['value'] }}</span></li>
                                    @endforeach
                                @endif

                                <li> @lang('master.single_product.Tags') <span class="ms-3">{{ @$product->tags }}</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tp_leftbar_box">
                        <div class="tp_product_detailhead">
                            <h4>@lang('master.single_product.author')</h4>
                        </div>
                        <a href="{{ route('frontend.user.author', [app()->getLocale(), @$product->getUser->username]) }}">
                            <div class="tp_product_box_flex">
                                <div class="tp_product_user">
                                    <img src="{{ $ASSET_URL }}assets/images/profile2.jpg" alt="Image" />
                                </div>
                                <div class="tp_john_flex">
                                    <h5>{{ @$product->getUser->full_name }}</h5>
                                    <div class="star_rating">
                                        @include('frontend.include.rating', [
                                            'faRating' => true,
                                            'rating' => @$product->getUser->rating,
                                        ])
                                    </div>
                                    <div class="star_rating">
                                        <ul>
                                            <li>
                                                <img src="{{ $ASSET_URL }}assets/images/box.png" alt="Image" />
                                                {{ @$product->getUser->getProductCount->count() }}
                                                @lang('master.single_product.Products')
                                            </li>
                                            <li>
                                                <img src="{{ $ASSET_URL }}assets/images/sales.png" alt="Image" />
                                                {{ @$product->getUser->getProductSales() }} @lang('master.single_product.Sales')
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--===Section End===-->
@endsection
@section('scripts')
    <script src="{{ asset('user-theme/my_assets/js/product_details.js') }}"></script>
@endsection
