@php
    $ASSET_URL = asset('user-theme') . '/';
    $auth_user = Auth::user();
    $setting = getsetting();
@endphp
<!--===Header Section Start===-->
<div class="tp_banner_section">
    @if (@$setting->is_checked_show_all_anim_img)
        <div class="tp-chart1-img">
            <img src="{{ Storage::url($setting->home_bg_s_img1) }}" alt="bg_img" />
        </div>
        <div class="tp-chart2-img">
            <img src="{{ Storage::url($setting->home_bg_s_img2) }}" alt="bg_img" />
        </div>
    @endif
    <div class="container">
        <div class="tp_banner_heading">
            <h5>@lang('master.home.banner_heading')</h5>
            <h1>@lang('master.home.banner_title')</h1>
            <!--=== Get all featured category ===-->
            @php  $featured_category = getFeaturedCategory(); @endphp
            <form action="{{ route('frontend.product.search', app()->getLocale()) }}" method="GET">
                <div class="tp_search_box">
                    <div class="tp_niceselect_box">
                        <select name="category" class="tp_nice_select">
                            <option value="">@lang('master.home.choose_category')</option>
                            @if (!empty($featured_category))
                                @foreach (@$featured_category as $row)
                                    <option value="{{ $row->slug }}">{{ $row->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <input id="search_text" type="text" name="keyword" value="" placeholder="@lang('master.home.search_template_here')" />
                    <button type="submit" class="tp_btn">@lang('master.home.search')</button>
                </div>
            </form>
        </div>
    </div>
    @if (@$setting->is_checked_show_all_anim_img)
        <div class="tp-chart3-img">
            <img src="{{ Storage::url($setting->home_bg_s_img3) }}" alt="bg_img" />
        </div>
        <div class="tp-chart4-img">
            <img src="{{ Storage::url($setting->home_bg_s_img4) }}" alt="bg_img" />
        </div>
    @endif
    <div class="tp_bnnner_section2"></div>
</div>
<!--===Header Section End===-->
