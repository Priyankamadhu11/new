<!-- Footer -->
<footer class="footer">
<style>

    .ocean 
    {
        width: 100%;
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        overflow-x: hidden;
    }

    .wave 
    {
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 88.7'%3E%3Cpath d='M800 56.9c-155.5 0-204.9-50-405.5-49.9-200 0-250 49.9-394.5 49.9v31.8h800v-.2-31.6z' fill='%23003F7C'/%3E%3C/svg%3E");
        position: absolute;
        width: 200%;
        height: 100%;
        animation: wave 10s -3s linear infinite;
        transform: translate3d(0, 0, 0);
        opacity: 0.8;
    }

    .wave:nth-of-type(2) 
    {
        bottom: 0;
        animation: wave 18s linear reverse infinite;
        opacity: 0.5;
    }

    .wave:nth-of-type(3) 
    {
        bottom: 0;
        animation: wave 20s -1s linear infinite;
        opacity: 0.5;
    }

    @keyframes wave 
    {
        0% {transform: translateX(0);}
        50% {transform: translateX(-25%);}
        100% {transform: translateX(-50%);}
    }

</style>
    
    <div class="footer-top">
        <div class="container">
            <div class="row gy-3 align-items-center">
                <div class="col-lg-3 col-sm-3 text-center text-lg-start">
                    <img width="180" src="{{asset("storage/app/public/company/")}}/{{ $web_config['footer_logo']->value }}"
                        onerror="this.src='{{theme_asset('assets/img/image-place-holder-4_1.png')}}'"
                        loading="lazy" alt="">
                </div>
                <div class="col-lg-6 col-sm-6 d-flex justify-content-center justify-content-sm-start justify-content-lg-center">

                    <ul class="list-socials list-socials--white gap-4 fs-18">
                        @if($web_config['social_media'])
                            @foreach ($web_config['social_media'] as $item)
                                <li>
                                    @if ($item->name == "twitter")
                                        <a href="{{$item->link}}" target="_blank" class="font-bold">
                                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 24 24">
                                            <g opacity=".3"><polygon fill="#fff" fill-rule="evenodd" points="16.002,19 6.208,5 8.255,5 18.035,19" clip-rule="evenodd"></polygon><polygon points="8.776,4 4.288,4 15.481,20 19.953,20 8.776,4"></polygon></g><polygon fill-rule="evenodd" points="10.13,12.36 11.32,14.04 5.38,21 2.74,21" clip-rule="evenodd"></polygon><polygon fill-rule="evenodd" points="20.74,3 13.78,11.16 12.6,9.47 18.14,3" clip-rule="evenodd"></polygon><path d="M8.255,5l9.779,14h-2.032L6.208,5H8.255 M9.298,3h-6.93l12.593,18h6.91L9.298,3L9.298,3z"  fill="currentColor"></path>
                                            </svg>
                                        </a>
                                    @elseif($item->name == 'google-plus')
                                        <a href="{{$item->link}}" target="_blank">
                                            <i class="bi bi-google"></i>
                                        </a>
                                    @else
                                        <a href="{{$item->link}}" target="_blank">
                                            <i class="bi bi-{{$item->name}}"></i>
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <div class="col-lg-3 col-sm-3 d-flex justify-content-center justify-content-sm-start">
                    <div class="media gap-3 absolute-white">
                        <i class="bi bi-telephone-forward fs-28"></i>
                        <div class="media-body">
                            <h6 class="absolute-white mb-1">{{translate('Hotline')}}</h6>
                            <a href="tel:{{$web_config['phone']->value}}" class="absolute-white">{{$web_config['phone']->value}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-main px-2  px-lg-0">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-4">
                    <div class="widget widget--about text-center text-lg-start absolute-white">

                    <h4 class="widget__title">Why Zigamart?</h4>
                        <div>
                            Our platform helps small businesses succeed by making sure the products they
                            sell are good quality and come straight from the makers.
                        </div>

                        <h4 class="widget__title pt-4">Address</h4>
                        <div>
                            
                            @php
                                $address = \App\CPU\Helpers::get_business_settings('shop_address');
                                $parts = explode(',', $address, 3);

                                if (isset($parts[0]) && isset($parts[1]) && isset($parts[2])) {
                                    $formatted_address = $parts[0] . ', ' . $parts[1] . ",\n" . $parts[2];
                                } else {
                                    $formatted_address = $address;
                                }
                            @endphp

                            <i class="bi bi-house-door" style="padding-right: 10px;"></i>{{ $formatted_address }}<br>
                            <a href="mailto:{{$web_config['email']->value}}" style="padding-top:10px">
                            <i class="bi bi-envelope" style="padding-right: 10px;"></i>{{$web_config['email']->value}}</a>
                        </div>

                        <!--<div class="d-flex gap-3 justify-content-center justify-content-lg-start flex-wrap mt-4">
                            @if($web_config['android']['status'])
                                <a href="{{ $web_config['android']['link'] }}"><img src="{{ theme_asset('assets/img/media/google-play.png') }}" loading="lazy" alt=""></a>
                            @endif
                            @if($web_config['ios']['status'])
                                <a href="{{ $web_config['ios']['link'] }}"><img src="{{ theme_asset('assets/img/media/app-store.png') }}" loading="lazy" alt=""></a>
                            @endif
                        </div> -->

                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="row gy-5">
                        <div class="col-sm-4 col-6">
                            <div class="widget widget--nav absolute-white">
                                <h4 class="widget__title">{{translate('Accounts')}}</h4>
                                <ul class="d-flex flex-column gap-3">
                                    @if($web_config['seller_registration'])
                                        <li>
                                            <a href="{{route('shop.apply')}}">{{translate('Become_a_Seller')}}</a>
                                        </li>
                                    @endif
                                    <li>
                                        @if(auth('customer')->check())
                                            <a href="{{route('user-profile')}}">{{translate('Profile')}}</a>
                                        @else
                                            <button class="bg-transparent border-0 p-0" data-bs-toggle="modal" data-bs-target="#loginModal">{{translate('Profile')}}</button>
                                        @endif
                                    </li>
                                    <li>
                                        <a href="{{route('track-order.index') }}">{{translate('track_order')}}</a>
                                    </li>
                                    <li><a href="{{route('contacts')}}">{{translate('Help_&_Support')}}</a></li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="col-sm-4 col-6">
                            <div class="widget widget--nav absolute-white">
                                <h4 class="widget__title">{{translate('Quick_Links')}}</h4>
                                <ul class="d-flex flex-column gap-3">
                                    @if($web_config['flash_deals'])
                                        <li><a href="{{route('flash-deals',[$web_config['flash_deals']['id']])}}">{{translate('Flash_Deals')}}</a></li>
                                    @endif
                                    <li><a href="{{route('products',['data_from'=>'featured','page'=>1])}}">{{translate('Featured_Products')}}</a></li>
                                    <li><a href="{{route('sellers')}}">{{translate('Top_Shops')}}</a></li>
                                    <li><a href="{{route('products',['data_from'=>'latest'])}}">{{translate('Latest_Products')}}</a></li>
                                    <li><a href="{{route('helpTopic')}}">{{translate('FAQ')}}</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-sm-4 col-6">
                            <div class="widget widget--nav absolute-white">
                                <h4 class="widget__title">{{translate('Other')}}</h4>
                                <ul class="d-flex flex-column gap-3">
                                    <li><a href="{{route('about-us')}}">{{translate('About_Company')}}</a></li>
                                    <li><a href="{{route('privacy-policy')}}">{{translate('Privacy_Policy')}}</a></li>

                                    @if(isset($web_config['refund_policy']['status']) && $web_config['refund_policy']['status'] == 1)
                                        <li>
                                            <a href="{{route('refund-policy')}}">{{translate('Refund_Policy')}}</a>
                                        </li>
                                    @endif

                                    <!-- @if(isset($web_config['return_policy']['status']) && $web_config['return_policy']['status'] == 1)
                                        <li>
                                            <a href="{{route('return-policy')}}">{{translate('return_policy')}}</a>
                                        </li>
                                    @endif -->

                                    <li><a href="{{route('terms')}}">{{translate('Terms_&_Conditions')}}</a></li>

                                    <!-- @if(isset($web_config['cancellation_policy']['status']) && $web_config['cancellation_policy']['status'] == 1)
                                        <li>
                                            <a href="{{route('cancellation-policy')}}">{{translate('cancellation_policy')}}</a>
                                        </li>
                                    @endif -->

                                    <!-- <li>
                                        @if(auth('customer')->check())
                                            <a href="{{route('account-tickets')}}">{{translate('Support_Ticket')}}</a>
                                        @else
                                            <button class="bg-transparent border-0 p-0" data-bs-toggle="modal" data-bs-target="#loginModal">{{translate('Support_Ticket')}}</button>
                                        @endif
                                    </li> -->

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="footer-bottom">
        <div class="container">
            <div class="row pb-3 align-items-center">
                <div class="col-md-5">
                    <div class="text-center copyright-text" style="color:wheat;">
                        {{ $web_config['copyright_text']->value }}
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="d-flex align-items-center justify-content-evenly">
                        <div class="text-white">We Using Safe Payment For</div>
                        <div>                             
                            <img src="{{asset('/public/assets/front-end/img/visa_card.png')}}" alt="" width="100"/>
                        </div>
                        <div>
                            <img src="{{asset('/public/assets/front-end/img/master_card.png')}}" alt="" width="100"/>
                        </div>
                        <div>
                            <img src="{{asset('/public/assets/front-end/img/razorpay_card.png')}}" alt="" width="100"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom ocean">
        <div class="container">
            <div class="wave p-2"></div>
            <div class="wave p-2"></div>
        </div>
    </div>

</footer>
