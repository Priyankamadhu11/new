<section>


    @php

        $section_banners = \app\Model\Banner::where('banner_type', 'Section wise Banner')->get();

        if ($section_banners) 
        {
            $banners = [];

            foreach ($section_banners as $banner) {
                $banners[] = $banner;
            }
        }

    @endphp

    @php
        $subcat_list = \app\Model\Category::where('parent_id', 13)->get();
        $cattname=\app\Model\Category::where('id',13)->first();
    @endphp

    <style>

        #refurbished
        {
            background:linear-gradient(-90deg, #090038, #00759f);;
            color: white;
            position: absolute;
            z-index: 99;
            margin-top: 15px;
            padding: 5px;
            font-size: 12px;
            font-weight: 700;
            border: 1px dashed yellow;
        }
        
    </style>

    <!-- @if(isset($banners[1]))
        <div class="container">
            <div class="py-3 rounded position-relative">
                <a href="{{$banners[1]->url}}" target="_blank">
                        <img src="{{asset('storage/app/public/banner')}}/{{$banners[1]->photo}}" 
                            alt="" class="rounded dark-support img-fit start-0 top-0 index-n1 flipX-in-rtl h-auto">
                        </a>
            </div>
        </div>
    @endif -->

    <!-- @if($subcat_list)
        <div class="container">

            <div class="d-flex flex-wrap justify-content-between gap-3 mb-4">
                <h2>{{$cattname->name}}</h2>
            </div>

            <div class="row g-2 g-sm-3 pb-5">
                @foreach ($subcat_list as $key => $subcat)
                    <div class="col-2 d-none d-sm-block text-center">
                        <a href="javascript:" onclick="location.href='{{route('products',['id'=> $subcat['id'],'data_from'=>'category','page'=>1])}}'" class="ad-hover h-100 ">
                            <img src="{{ asset('storage/app/public/category/' . $subcat->icon) }}" loading="lazy" alt="" onerror="this.src='{{ theme_asset('assets/img/image-place-holder-2_1.png') }}'" class="dark-support rounded w-100 img-fit">
                        </a>
                        <span class="text-center pt-2">{{$subcat->name}}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif -->
    
    @php
        $toys_list = \app\Model\Product::where('sub_category_id',55)->where('status',1)->get();
        $toyname=\app\Model\Category::where('id',55)->first();
    @endphp

    @if(count($toys_list)>0)

        @if(isset($banners[2]))
            <div class="container">
                <div class="pb-5 rounded position-relative">
                        <a href="{{$banners[2]->url}}" target="_blank">
                            <img src="{{asset('storage/app/public/banner')}}/{{$banners[2]->photo}}" 
                                alt="" class="rounded dark-support img-fit start-0 top-0 index-n1 flipX-in-rtl h-auto">
                        </a>
                </div>
            </div>
        @endif

        <div class="container">
            <div class="d-flex flex-wrap justify-content-between gap-3 mb-2">
                <h2>{{$toyname->name}}</h2>
            </div>

                <div class="swiper-container pb-5">
                        <!-- Swiper -->
                    <div class="position-relative">
                        <div class="swiper" data-swiper-loop="true" data-swiper-margin="20"
                                data-swiper-pagination-el="null" data-swiper-navigation-next=".top-stores-nav-next"
                                data-swiper-navigation-prev=".top-stores-nav-prev"
                                data-swiper-breakpoints='{"0": {"slidesPerView": "1"}, "768": {"slidesPerView": "2"}, "992": {"slidesPerView": "5"}}'>
                        <div class="swiper-wrapper">            
                            @foreach ($toys_list as $key => $toys)
                                <div class="swiper-slide align-items-start bg-light rounded">
                                    @if($toys->used_or_new == 1)
                                        <div id="refurbished">Refurbished Product</div>
                                    @endif
                                    <a href="{{route('product',$toys->slug)}}" class="text-center">
                                        @php
                                            $images = json_decode($toys['images']);
                                            $firstImage = isset($images[0]) ? $images[0] : null;
                                        @endphp
                                      
                                        <img src="{{ asset('storage/app/public/product/' . $firstImage) }}" loading="lazy" alt="{{ $toys->name }}" onerror="this.src='{{ theme_asset('assets/img/image-place-holder-2_1.png') }}'" class="dark-support rounded w-100 img-fit pb-2">

                                        <span class="text-center">{{ $toys->name }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif

    @if(isset($banners[3]))
        <div class="container">
            <div class="pb-5 rounded position-relative">
                <a href="{{$banners[3]->url}}" target="_blank">
                    <img src="{{asset('storage/app/public/banner')}}/{{$banners[3]->photo}}" 
                    alt="" class="rounded dark-support img-fit start-0 top-0 index-n1 flipX-in-rtl h-auto">
                </a>
            </div>
        </div>
    @endif

    @php
        $topcat_list = \app\Model\Category::where('parent_id',0)->where('home_status',1)->inRandomOrder()->take(6)->get();
    @endphp

    @if(count($topcat_list)>0)

        <div class="container">
            <div class="d-flex flex-wrap justify-content-between gap-3 mb-4">
                <h2>Top Categories Of The Month</h2>
            </div>
            <div class="row g-2 g-sm-3 pb-5">
                @foreach ($topcat_list as $key => $topcat)
                    <div class="col-2 d-sm-block text-center">
                        <a href="javascript:0" onclick="location.href='{{route('products',['id'=> $topcat['id'],'data_from'=>'category','page'=>1])}}'" class="ad-hover h-100 d-flex flex-column align-items-center">
                            <div class="rounded-circle overflow-hidden border border-2" style="width:175px;height: 175px;border:1px dashed purple !important">
                                <img src="{{ asset('storage/app/public/category/' . $topcat->icon) }}" loading="lazy" alt="" onerror="this.src='{{ theme_asset('assets/img/image-place-holder-2_1.png') }}'" class="dark-support rounded w-100 img-fit">
                            </div>
                            <span class="text-center pt-2">{{$topcat->name}}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

    @endif

    <!-- @if(isset($banners[4]))
        <div class="container">
            <div class="pb-5 rounded position-relative" target="_blank">
                <img src="{{asset('storage/app/public/banner')}}/{{$banners[4]->photo}}" 
                    alt="" class="rounded dark-support img-fit start-0 top-0 index-n1 flipX-in-rtl h-auto">
            </div>
        </div>
    @endif -->

    <!-- @php
        $appcatproducts=\app\Model\Category::where('parent_id',4)->get();
        $catname=\app\Model\Category::where('id',4)->first();
    @endphp

    @if(count($appcatproducts)>0)
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between gap-3 mb-4">
                <h2>{{$catname->name}}</h2>
            </div>
            <div class="row g-2 g-sm-3 pb-5 align-items-center">
                @foreach ($appcatproducts as $key => $topcat)
                    <div class="col-3 d-none d-sm-block text-center" >
                        <div class="row flex-nowrap align-items-center">
                            <a href="javascript:" onclick="location.href='{{route('products',['id'=> $topcat['id'],'data_from'=>'category','page'=>1])}}'" class="h-100 w-50">
                                <img src="{{ asset('storage/app/public/category/' . $topcat->icon) }}" loading="lazy" alt="" onerror="this.src='{{ theme_asset('assets/img/image-place-holder-2_1.png') }}'" class="dark-support rounded">
                            </a>
                            <span class="text-center pt-2 w-50 ">{{$topcat->name}}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif -->
  
    
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script>
    $(document).ready(function(){
        $('.toy_slider').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            autoplay: true, 
            autoplaySpeed: 2000, 
            infinite: true, 
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });
    });
</script>