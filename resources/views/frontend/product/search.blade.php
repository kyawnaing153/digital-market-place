@extends('frontend.layout.master')
@section('head_scripts')
    @php
        $ASSET_URL = asset('user-theme') . '/';
        $mUrl = Request::url();
        $mImage = Storage::url(getSettingShortValue('preview_image'));
        $mTitle = trans('page_title.Frontend.product_search_page_title');
        $mDescr = trans('page_title.Frontend.product_search_page_desc');
        $mKWords = trans('page_title.Frontend.product_search_page_keyword');
        $site_creator = trans('page_title.Frontend.site_creator');        
    @endphp
    <title>{{ @$mTitle }}</title>
    <meta name="keywords" content="{{ @$mKWords }}" />
    <meta name="description" content="{{ @$mDescr }}" />
    <meta property=og:locale content="{{ app()->getLocale() }}" />
    <meta property=og:type content=website />
    <meta property="og:site_name" content="{{ $site_creator }}" />
    <meta property="og:title" content="{{ @$mTitle }}" />
    <meta property="og:description" content="{{ @$mDescr }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ @$mImage }}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta property="twitter:title" content="{{ @$mTitle }}" />
    <meta property="twitter:description" content="{{ @$mDescr }}" />
    <meta property="twitter:url" content="{{ url()->current() }}" />
    <meta property="twitter:image" content="{{ @$mImage }}" />
    <meta name="twitter:site" content="{{ $site_creator }}" />
    <meta name="twitter:creator" content="{{ $site_creator }}" />
@endsection
@section('content')
    <!--===Section Start===-->
    <div class="tp_singlepage_section">
        <div class="container">
            <form id="product-search-form" action="{{ route('frontend.product.postsearch', app()->getLocale()) }}"
                method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="tp_view_box">
                            <div class="tp_view_text">
                                <p><span>{{ @$total_prod }}</span> @lang('master.product_search.html_templates_sorted')</p>
                            </div>
                            <div class="tp_listprice_box">
                                <div class="tp_view_list">
                                    <ul>
                                        <li>@lang('master.product_search.View')</li>
                                        <li>
                                            <a href="javascript:;" class="p-view active grid_view" data-val="0"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="15.69" height="15.687"
                                                    viewBox="0 0 15.69 15.687">
                                                    <path id="_01" data-name="01" class="cls-1"
                                                        d="M1175.17,459.1h3.92v3.918h-3.92V459.1Zm-5.87-5.876h3.91v3.917h-3.91v-3.917Zm5.87,11.753h3.92V468.9h-3.92v-3.917Zm-5.87-5.877h3.91v3.918h-3.91V459.1Zm0,5.877h3.91V468.9h-3.91v-3.917Zm11.75-11.753h3.92v3.917h-3.92v-3.917Zm-5.88,0h3.92v3.917h-3.92v-3.917Zm5.88,5.876h3.92v3.918h-3.92V459.1Zm0,5.877h3.92V468.9h-3.92v-3.917Z"
                                                        transform="translate(-1169.28 -453.219)" />
                                                </svg>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;" class="p-view list_view" data-val="1"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="15.75" height="15.75" viewBox="0 0 15.75 15.75">
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
                                    <select class="tp_nice_select" name="sort_by">
                                        <option value="price-asc" selected> @lang('master.author.Price_ASC')</option>
                                        <option value="price-desc">@lang('master.author.Price_DESC')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="tp_sidebar_category">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            @lang('master.product_search.Category')
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="tp_checkbox_Wrapper">
                                                <ul>
                                                    <li>
                                                        <div class="tp_checkbox parent-category">
                                                            <input type="checkbox" id="all_category" name="all_category"
                                                                value="1" name="all_category"
                                                                @if (empty(request('category'))) checked @endif>
                                                            <label for="all_category">@lang('master.author.All')</label>
                                                        </div>
                                                        <span>{{ @$total_prod }}</span>
                                                    </li>
                                                    @php  $featured_category = getFeaturedCategory(); @endphp
                                                    @if (!empty($featured_category))
                                                        @foreach (@$featured_category as $row)
                                                            <li>
                                                                <div class="tp_checkbox child-category">
                                                                    <input type="checkbox"
                                                                        id="auth_remember{{ $row->id }}"
                                                                        name="category_id[]" value="{{ $row->id }}"
                                                                        @if (request('category') == $row->slug) checked @endif />
                                                                    <label
                                                                        for="auth_remember{{ $row->id }}">{{ $row->name }}</label>
                                                                </div>
                                                                <span>{{ $row->getproduct->count() }}</span>
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                            aria-expanded="false" aria-controls="collapseThree">
                                            @lang('master.product_search.Price')
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse"
                                        aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="tp_checkbox_Wrapper">
                                                <ul>
                                                    <li>
                                                        <div class="tp_input_sidebar">
                                                            <input type="number" placeholder="$0" value="0"
                                                                name="start_price[]" />
                                                            <span>-</span>
                                                            <input type="number" placeholder="$500" value="500"
                                                                name="end_price[]" />
                                                        </div>
                                                        <div class="ser_input_btn">
                                                            <button class="search_btn" type="button"
                                                                onclick="search_product()">
                                                                 <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                                                width="14" height="12">
                                                                <path
                                                                    d="M0 0 C1.98 1.65 3.96 3.3 6 5 C5.44225728 8.23490776 4.62788492 9.97855006 2 12 C1.01 12 0.02 12 -1 12 C-0.835 11.4225 -0.67 10.845 -0.5 10.25 C0.14462031 7.73335631 0.14462031 7.73335631 0 4 C0 2.68 0 1.36 0 0 Z "
                                                                    fill="var(--theme-color)" transform="translate(8,0)" />
                                                                <path
                                                                    d="M0 0 C1.98 1.65 3.96 3.3 6 5 C5.44225728 8.23490776 4.62788492 9.97855006 2 12 C1.01 12 0.02 12 -1 12 C-0.835 11.4225 -0.67 10.845 -0.5 10.25 C0.14462031 7.73335631 0.14462031 7.73335631 0 4 C0 2.68 0 1.36 0 0 Z "
                                                                    fill="var(--theme-color)" transform="translate(1,0)" />
                                                            </svg>
                                                            </button>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFour">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                            aria-expanded="false" aria-controls="collapseFour">
                                            @lang('master.product_search.On_Sale')
                                        </button>
                                    </h2>
                                    <div id="collapseFour" class="accordion-collapse collapse"
                                        aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="tp_checkbox_Wrapper">
                                                <ul>
                                                    <li>
                                                        <div class="tp_checkbox">
                                                            <input type="checkbox" id="auth_remember10" name="is_sale"
                                                                value="1" />
                                                            <label for="auth_remember10">Yes</label>
                                                        </div>
                                                        <span>{{ $total_sale_prod ?? 0 }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFive">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                            aria-expanded="false" aria-controls="collapseFive">
                                            @lang('master.product_search.Rating')
                                        </button>
                                    </h2>
                                    <div id="collapseFive" class="accordion-collapse collapse"
                                        aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="tp_checkbox_Wrapper">
                                                <ul>
                                                    <li>
                                                        <div class="tp_checkbox parent-rating">
                                                            <input type="checkbox" id="rating_all" name="rating_all"
                                                                value="1" checked />
                                                            <label for="rating_all">@lang('master.author.Show_All')</label>
                                                        </div>
                                                    </li>
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <li>
                                                            <div class="tp_checkbox child-rating">
                                                                <input type="checkbox" id="rating-{{ $i }}"
                                                                    name="rating[]" value="{{ $i }}" />
                                                                <label for="rating-{{ $i }}">
                                                                    @for ($j = 1; $j <= 5; $j++)
                                                                        <i class="fa fa-star @if ($i >= $j) active @endif"
                                                                            aria-hidden="true"></i>
                                                                    @endfor
                                                                </label>
                                                            </div>
                                                            <span>{{ $i }}@lang('master.author.Star')</span>
                                                        </li>
                                                    @endfor
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="tp_btn" onclick="search_product()">@lang('master.product_search.Filter')</button>
                    </div>

                    <div class="col-lg-9">
                        <div class="row" id="search_box">
                        </div>

                        <div class="text-center">
                            <button type="button" class="tp_btn border d-none" id="load_more_button"
                                data="2">@lang('master.product_search.Loadmore')</button>
                        </div>

                        <div class="col-lg-12 mt-4">
                            <div class="tp_add_image" id="advertize-ad">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--===Section End===-->
@endsection
@section('scripts')
    <script src="{{ asset('user-theme/my_assets/js/product.js') }}"></script>
@endsection
