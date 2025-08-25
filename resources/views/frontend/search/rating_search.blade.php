@if (isset($data) && count($data) > 0)
    @foreach ($data as $key => $val)
        <div class="tp_cmnt_flexbox @if (!$loop->first) mt-4 @endif">
            <div class="tp_cmnt_user">
                <img src="@if (@$val->getUser->avatar) {{ $val->getUser->avatar }} @else {{ asset('user-theme/assets/images/cmnt_user.png') }} @endif"
                    alt="Image" />
            </div>
            <div class="tp_ct_text">
                <div class="tp_ct_text_flex">
                    <h6>
                        {{ @$val->getUser->full_name }}
                    </h6>

                </div>
                <div class="star_rating">
                    @include('frontend.include.rating', [
                        'faRating' => true,
                        'rating' => @$val->rating,
                    ])
                </div>
                <p>
                    {{ @$val->comment }}
                </p>
            </div>
        </div>
        @if (isset($val->reviewReply) && count($val->reviewReply) > 0)
            @foreach ($val->reviewReply as $val2)
                <div class="tp_cmnt_flexbox tp_reply_box">
                    <div class="tp_ct_text">
                        <div class="tp_ct_text_flex">
                            <h6>
                                <svg xmlns="http://www.w3.org/2000/svg" width="12.531" height="10.84"
                                    viewBox="0 0 12.531 10.84">
                                    <path class="cls-1"
                                        d="M467.06,1474.37a0.775,0.775,0,0,0,0,1.1l1.8,1.78h-4.375a5.5,5.5,0,0,0-3.876,1.59,5.368,5.368,0,0,0-1.605,3.83v1.55a0.758,0.758,0,0,0,.229.55,0.782,0.782,0,0,0,1.108,0,0.758,0.758,0,0,0,.229-0.55v-1.55a3.875,3.875,0,0,1,1.147-2.74,3.916,3.916,0,0,1,2.768-1.13h4.375l-1.8,1.77a0.839,0.839,0,0,0-.175.26,0.732,0.732,0,0,0-.064.3,0.749,0.749,0,0,0,.229.55,0.851,0.851,0,0,0,.258.17,0.787,0.787,0,0,0,.3.06,0.641,0.641,0,0,0,.3-0.07,0.821,0.821,0,0,0,.254-0.17l3.133-3.1a0.775,0.775,0,0,0,.229-0.55,0.793,0.793,0,0,0-.229-0.55l-3.133-3.1A0.781,0.781,0,0,0,467.06,1474.37Z"
                                        transform="translate(-459 -1474.16)" />
                                </svg>
                                @lang('master.product_search.author_response')
                                <span>@lang('master.product_search.feedback')</span>
                            </h6>
                        </div>
                        <div class="star_rating">
                            <ul>
                                <li>{{ time_elapsed_string2($val2->created_at) }}</li>
                            </ul>
                        </div>
                        <p>
                            {{ @$val2->comment }}
                        </p>
                    </div>
                </div>
            @endforeach
        @endif
    @endforeach
@else
    <p> @lang('master.product_search.review') </p>
@endif
