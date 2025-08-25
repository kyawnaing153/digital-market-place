@if (isset($data) && count($data) > 0)
    @foreach ($data as $key => $val)
        <div class="comment_section">
            <div class="tp_cmnt_flexbox gfkg  mt-4">
                <div class="tp_cmnt_user">
                    <img src="@if (!empty($val->getUser->avatar)) {{ $val->getUser->avatar }} @else {{ asset('user-theme/assets/images/cmnt_user.png') }} @endif"
                        alt="Image" />
                </div>
                <div class="tp_ct_text">
                    <div class="tp_ct_text_flex">
                        <h6>
                            {{ @$val->getUser->full_name }} <span> -
                                {{ date('d M Y', strtotime($val->created_at)) }}</span><span>-
                                {{ date('h:m A', strtotime($val->created_at)) }}</span>
                        </h6>
                        <a href="javascript:;"  @if (!Auth::check()) data-bs-toggle="modal" data-bs-target="#log_modal" type="button" @else class="reply-btn" @endif>
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="11" viewBox="0 0 13 11">
                                <path class="cls-1"
                                    d="M1015.64,1301.22a0.762,0.762,0,0,1,0,1.11l-1.86,1.8h4.53a5.74,5.74,0,0,1,4.02,1.62,5.4,5.4,0,0,1,1.67,3.89v1.57a0.8,0.8,0,0,1-.24.56,0.81,0.81,0,0,1-.57.23,0.834,0.834,0,0,1-.58-0.23,0.787,0.787,0,0,1-.23-0.56v-1.57a3.885,3.885,0,0,0-1.19-2.78,4.146,4.146,0,0,0-2.88-1.15h-4.53l1.86,1.8a0.677,0.677,0,0,1,.18.26,0.775,0.775,0,0,1,.07.3,0.765,0.765,0,0,1-.06.3,1,1,0,0,1-.18.26,0.771,0.771,0,0,1-.27.17,0.853,0.853,0,0,1-.31.06,0.866,0.866,0,0,1-.32-0.06,0.677,0.677,0,0,1-.26-0.18l-3.25-3.14a0.773,0.773,0,0,1,0-1.12l3.25-3.14A0.834,0.834,0,0,1,1015.64,1301.22Z"
                                    transform="translate(-1011 -1301)" />
                            </svg>
                            @lang('master.comment_search.Reply')
                        </a>
                    </div>
                    <p>
                        {{ @$val->comment }}
                    </p>
                </div>
            </div>
            @if(auth()->check())
                <div class="tp_cmnt_toreply reply-form d-none">
                    <div class="tp_cmnt_toreply_user">
                        <img src="@if (auth()->user()) @if (auth()->user()->avatar){{ auth()->user()->avatar }} @else {{ asset('user-theme/assets/images/cmnt_user.png') }} @endif @endif"
                            alt="Image" />
                    </div>
                    <div class="tp_cmnt_toreply_form ">
                        <form method="POST" class="addReply">
                            @csrf
                            <div class="form-outline form-white">
                                <label class="form-label">@lang('master.comment_search.send_a_reply')</label>
                                <textarea name="comment" rows="3" cols="30" class="form-control comment-text-area"
                                    placeholder="Reply here..."></textarea>
                                <input type="hidden" name="parent_id" id="parent_id" value="{{ @$val->id }}">
                                <div class="form_replybtn_box">
                                    <button class="tp_btn tp_btn_post cmd-reply-btn" type="submit" >@lang('master.comment_search.send_reply')</button>
                                    <button type="button" class="tp_btn reply-form-remove">@lang('master.comment_search.Cancel')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
            @if (@$val->commentReply[0])
                @foreach ($val->commentReply as $val2)
                    <div class="tp_cmnt_flexbox tp_reply_box">
                        <div class="tp_cmnt_user">
                            <img src="@if (!empty(@$val2->getUser->avatar)) {{ $val2->getUser->avatar }} @else {{ asset('user-theme/assets/images/cmnt_user.png') }} @endif"
                                alt="Image" />
                        </div>
                        <div class="tp_ct_text">
                            <div class="tp_ct_text_flex flex">
                                <h6>
                                    {{ @$val2->getUser->full_name }} 
                                    <span> - {{ date('d M Y', strtotime($val2->created_at)) }}</span>
                                    <span> - {{ date('h:m A', strtotime($val2->created_at)) }}</span>
                                </h6>
                            </div>
                            <p>
                                {{ @$val2->comment }}
                            </p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    @endforeach
@else
    <p>@lang('master.single_product.no_comment_found')</p>
@endif
