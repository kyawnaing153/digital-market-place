 <!--=== Related Product Slider Start===-->
 @php $price_symbol =  getSetting()->default_symbol ?? '$'; @endphp
 <div class="swiper-container">
     <div class="swiper-wrapper">
         @if (!empty($product_items))
             @foreach ($product_items as $key => $items)
                 @php
                     $extension = pathinfo($items->image, PATHINFO_EXTENSION);
                 @endphp
         
                 <div class="swiper-slide">
                     <a href="{{ route('frontend.product.single_details', [app()->getLocale(), $items->slug]) }}">
                         <div class="tp_slide_main tp-animation-box">
                             @if ($extension == "mp4")
                                 <div class="tp_slide_img">
                                     <span class="tp-product-list-img tp-animation">
                                         <video width="100%" height="180px" controls controlsList="nodownload">
                                             <source src="{{ Storage::url(@$items->image) }}" alt="product-img"
                                                 class="product-step2img">
                                         </video>
                                     </span>
                                 </div>
                            @elseif($extension == "mp3")  
                            <div class="tp_slide_img">
                                     <span class="tp-product-list-img tp-animation">
                                         <audio controls controlsList="nodownload" style="width: 100%;height: 100px;">
                                             <source src="{{ Storage::url(@$items->image) }}" alt="product-img"
                                                 class="product-step2img">
                                         </audio>
                                     </span>
                                 </div>   

                             @else
                                 <div class="tp_slide_img">
                                     <span class="tp-product-list-img tp-animation">
                                         <img src="{{ $items->thumb }}" class="tp-animation-img" alt="Image" />
                                     </span>
                                 </div>
                             @endif
                             <div class="tp_slide_content">
                                 <h5>{{ @$items->name }}</h5>
                                 <h6>by {{ @$items->getUser->full_name }}</h6>
                                 <div class="tp_rating_icon">
                                     <div class="star_rating">
                                         <ul>
                                             <div class="star_rating">
                                                 @include('frontend.include.rating', [
                                                     'faRating' => true,
                                                     'rating' => @$items->rating,
                                                 ])
                                             </div>
                                         </ul>
                                     </div>
                                     <span>{{ $items->sale_count ?? 0 }} sales</span>
                                 </div>
                                 <div class="addto_cart">
                                     @php $productPrice = $items->productPrice(); @endphp
                                     <div class="tp_flex_price_st">
                                         @if ($productPrice['free'])
                                             <p>
                                                 @if (!empty($productPrice['price']))
                                                     <del>{{ $price_symbol . @$productPrice['price'] }}</del>
                                                 @endif FREE
                                             </p>
                                         @elseif($productPrice['price'])
                                             @if (@$productPrice['offer_price'])
                                                 <p><del>{{ $price_symbol }}{{ @$productPrice['price'] }}</del></p>
                                                 <p>{{ $price_symbol }}{{ @$productPrice['offer_price'] }}</p>
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
         @endif
     </div>
 </div>
 <!-- Add Pagination -->
 <div class="swiper-button-next swiper-button-white"></div>
 <div class="swiper-button-prev swiper-button-white"></div>

 <!--===Related Slider End===-->
