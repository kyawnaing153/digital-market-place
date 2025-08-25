@extends('frontend.layout.master')
@section('head_scripts')
    @php
        $ASSET_URL = asset('user-theme') . '/';
        $price_symbol = getSetting()->default_symbol ?? '$';
    @endphp
    <title>@lang('page_title.Frontend.cart_title')</title>
    <meta name="keywords" content="@lang('page_title.Frontend.cart_keyword')" />
    <meta name="description" content="@lang('page_title.Frontend.cart_desc')" />
@endsection
@section('content')
    <!--===cart Section Start===-->
    <div class="tp_singlepage_section tp_cart_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp_view_box">
                        <div class="tp_view_text">
                            <h2>@lang('master.cart.your_cart')</h2>
                        </div>
                        @if (Cart::instance('default')->count() > 0)
                            <div class="tp_cart_step">
                                <div class="tp_step_box">
                                    <a type="button" class="anchor-button">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            preserveAspectRatio="xMidYMid" width="69" height="47"
                                            viewBox="0 0 69 47">
                                            <g>
                                                <circle cx="34.5" cy="12.5" r="12.5" class="cls-1">
                                                </circle>
                                                <path
                                                    d="M38.659,8.113 L32.260,13.934 L29.554,11.102 L27.764,12.747 L32.136,17.322 L40.322,9.881 L38.659,8.113 Z"
                                                    class="cls-1"></path>
                                            </g>
                                        </svg>
                                        <span>@lang('master.cart.add_to_cart')</span></a>
                                </div>
                                <div class="tp_step_box">
                                    <a href="{{ route('frontend.checkout', app()->getLocale()) }}"><svg
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="25" height="25" viewBox="0 0 25 25">
                                            <image id="tick" width="25" height="25"
                                                xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAACYUlEQVRIia2Wy29SQRSHP+BeXrVQG9NYK+jCaEWp1lqNSxPd+Ehc6d6Vrly5d2uMiSZu/BN05UKbmC5cqYm2NWmVNPiiKBBK0IImpQWKObcDoVcur/Lb3DCP3zdnODNnbNOvIzSRCzgLXAHOAPsAP5ADloC3wDPgFbBmZWMF0YDrwB1guNkqlJaBu8AjYN3caW8w4RAwCzxuEyAaAu4D74HRVpBJ4A0w1qa5WWNq/mkriKxgGhjsElDVTuBlfURViA48UX9qLyQ+T5VvDXJrG1tkpbDyNSBu4HaPAVWJr1sgl1R2dCyHw07owDAet241VXwvC+RiNwBdc3AiFGTP0ADjoSBOXbMaekF6JjoFuF26YdzncRq/V/KrFEtlq+EnJZJgox6n7iB8cMT41muH18VkeH8NEEtkiXxJUqlUrCABrVHaag47E0c3jfq8LmY/LhkrHfB5OTa619gqUTSWJp781Spwv0SSN7eWyhssZzebZeXHDwfYvcvHeChgAGTVnz4n2wGI8hLJD+CIuedrPGNkT3B4EH+/B3//iNFeLm8wH02Q/f23HYDop11dag0V/Z4mkV6pdcmWzUXinQBE7wQy1WzE4rcUqUyOwlqRmYUYuT+rnQBEU1JP3KoAWR5Im03OhcZ6sdQpICPZK5EUgHvNRkp2dgFA+RaqF+RDYL4blyZaAB5QdwsXgWuqdvdC4nNV+W4pWovAOVWvtyOZf175YYaIZlQJnusS8gE4ZT4WjR4ScVWjbwKpNs1l3A0FkEzdolbvLklvqTdSDuS2lneXT11FYiavmhfAc5Wl/wv4B+t/osUjHVxUAAAAAElFTkSuQmCC" />
                                        </svg>
                                        <span>@lang('master.cart.checkout')</span></a>
                                </div>
                                <div class="tp_step_box">
                                    <a type="button" class="anchor-button"><svg xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="25" height="25"
                                            viewBox="0 0 25 25">
                                            <image id="tick" width="25" height="25"
                                                xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAACYUlEQVRIia2Wy29SQRSHP+BeXrVQG9NYK+jCaEWp1lqNSxPd+Ehc6d6Vrly5d2uMiSZu/BN05UKbmC5cqYm2NWmVNPiiKBBK0IImpQWKObcDoVcur/Lb3DCP3zdnODNnbNOvIzSRCzgLXAHOAPsAP5ADloC3wDPgFbBmZWMF0YDrwB1guNkqlJaBu8AjYN3caW8w4RAwCzxuEyAaAu4D74HRVpBJ4A0w1qa5WWNq/mkriKxgGhjsElDVTuBlfURViA48UX9qLyQ+T5VvDXJrG1tkpbDyNSBu4HaPAVWJr1sgl1R2dCyHw07owDAet241VXwvC+RiNwBdc3AiFGTP0ADjoSBOXbMaekF6JjoFuF26YdzncRq/V/KrFEtlq+EnJZJgox6n7iB8cMT41muH18VkeH8NEEtkiXxJUqlUrCABrVHaag47E0c3jfq8LmY/LhkrHfB5OTa619gqUTSWJp781Spwv0SSN7eWyhssZzebZeXHDwfYvcvHeChgAGTVnz4n2wGI8hLJD+CIuedrPGNkT3B4EH+/B3//iNFeLm8wH02Q/f23HYDop11dag0V/Z4mkV6pdcmWzUXinQBE7wQy1WzE4rcUqUyOwlqRmYUYuT+rnQBEU1JP3KoAWR5Im03OhcZ6sdQpICPZK5EUgHvNRkp2dgFA+RaqF+RDYL4blyZaAB5QdwsXgWuqdvdC4nNV+W4pWovAOVWvtyOZf175YYaIZlQJnusS8gE4ZT4WjR4ScVWjbwKpNs1l3A0FkEzdolbvLklvqTdSDuS2lneXT11FYiavmhfAc5Wl/wv4B+t/osUjHVxUAAAAAElFTkSuQmCC" />
                                        </svg>
                                        <span>@lang('master.cart.done')</span></a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @if (Cart::instance('default')->count() > 0)
                    <div class="tp_single_grid product_list_view">
                        @foreach (Cart::instance('default')->content() as $item)
                       
                            @php
                                $extension = pathinfo(@$item->model->imageUrl, PATHINFO_EXTENSION);
                            @endphp
                            <div class="tp_istop_box">
                                @if ($extension == 'mp4')
                                    <a href="javascript:;">
                                        <div class="grid_img">
                                            <span class="tp-product-list-img tp-animation">
                                                <video width="100%" height="100%" controls controlsList="nodownload">
                                                    <source src="{{ Storage::url($item->model->image) }}" type="video/mp4">
                                                </video>
                                            </span>
                                        </div>
                                    </a>
                                @elseif($extension == 'mp3')
                                <a href="javascript:;">
                                        <div class="grid_img">
                                            <span class="tp-product-list-img tp-animation">
                                                <audio controls controlsList="nodownload" style="width: 100%;height: 100px;">
                                                    <source src="{{ Storage::url($item->model->image) }}" type="audio/mp4">
                                                </audio>
                                            </span>
                                        </div>
                                    </a>
                                @else
                                    <a href="javascript:;">
                                        <div class="grid_img">
                                            <span class="tp-product-list-img tp-animation">
                                                <img src="{{ @$item->model->imageUrl }}" class="tp-animation-img"
                                                    alt="project-img" />
                                            </span>
                                        </div>
                                    </a>
                                @endif
                                <div class="tp_isbox_content">
                                    <div class="bottom_content">
                                        <h5>{{ $item->name }}</h5>
                                        <p>by {{ @$item->model->getUser->full_name }}</p>
                                    </div>
                                    <div class="tp_wishlist_text">
                                        <p>
                                            {{ @$item->model->short_desc }}
                                        </p>
                                    </div>
                                    <div class="addto_cart">
                                        <h4>
                                            <span>{{ $price_symbol }}{{ $item->price }}</span>
                                        </h4>
                                    </div>
                                </div>
                                <div class="tp_overlay_btn">
                                    <form
                                        action="{{ route('frontend.cart.destroy', [app()->getLocale(), $item->rowId, 'default']) }}"
                                        method="POST" id="delete-item">
                                        @csrf()
                                        @method('DELETE')
                                        <button type="submit" class="tp_btn"><img
                                                src="{{ $ASSET_URL }}assets/images/delete.png"
                                                alt="Image" />@lang('master.cart.remove')</button>
                                    </form>

                                    <button type="button"
                                        @if (Auth::check()) onclick="addtoWishlist('{{ $item->model->slug }}')" class="active_red active_redhide tp_btn tp_btn_wish watchlist_btn"@else data-bs-toggle="modal" data-bs-target="#log_modal" @endif
                                        class="active_red active_redhide tp_btn tp_btn_wish"><i
                                            class="fa fa-heart @if (@$item->model->check_in_wishlist()) active @endif"
                                            aria-hidden="true"></i> @lang('master.cart.add_to_Wishlist')</button>

                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-lg-12">
                        <div class="tp_view_box tp_concheck_box">
                            <div class="tp_view_text">
                            </div>
                            <div class="tp_continue_checkout">
                                <a href="{{ route('frontend.checkout', app()->getLocale()) }}"
                                    class="tp_btn">@lang('master.cart.continue_to_checkout')<span><i class="fa fa-angle-double-right"
                                            aria-hidden="true"></i> </span></a>
                            </div>
                        </div>
                    </div>
                @else
                    <p>@lang('master.cart.no_item_cart') <a
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
                        <h2>@lang('master.cart.recently_viewed')</h2>
                    </div>
                </div>
            </div>
            @include('frontend.include.related-product', ['product_items' => @$product_items]);
        </div>
    </div>
@endsection
