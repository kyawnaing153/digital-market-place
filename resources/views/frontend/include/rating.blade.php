 <!--===fa rating with count End===-->
@if (isset($faRating))
    <ul>
        @php $r = $rating; @endphp
        @foreach (range(1, 5) as $i)
            <li>
                @if ($r > 0)
                    @if ($r > 0.5)
                        <i class="fa fa-star active" aria-hidden="true"></i>
                    @else
                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                    @endif
                @else
                    <i class="fa fa-star"></i>
                @endif
                @php $r--; @endphp
            </li>
        @endforeach
        <li>{{ number_format($rating, 1) }}</li>
    </ul>
@endif
 <!--===Related Slider End===-->
 <!--===fa without count rating End===-->
@if (isset($faWithoutCountRating))
    <ul>
        @php $r = $rating; @endphp
        @foreach (range(1, 5) as $i)
            <li>
                @if ($r > 0)
                    @if ($r > 0.5)
                        <i class="fa fa-star active" aria-hidden="true"></i>
                    @else
                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                    @endif
                @else
                    <i class="fa fa-star"></i>
                @endif
                @php $r--; @endphp
            </li>
        @endforeach
    </ul>
@endif
 <!--=== End===-->

 <!--===Testimonial Rating End===-->
@if (isset($testimonialRating))
    <ul>
        @php $r = $rating; @endphp
        @foreach (range(1, 5) as $i)
            <li>
                @if ($r > 0)
                    @if ($r > 0.5)
                        <i class="fa fa-star active fa-yellow" aria-hidden="true"></i>
                    @else
                        <i class="fa fa-star-half-o active fa-yellow" aria-hidden="true"></i>
                    @endif
                @else
                    <i class="fa fa-star"></i>
                @endif
                @php $r--; @endphp
            </li>
        @endforeach
    </ul>
@endif
 <!--===Testimonial End===-->
