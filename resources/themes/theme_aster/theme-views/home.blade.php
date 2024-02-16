@extends('theme-views.layouts.app')

@section('title', $web_config['name']->value.' '.translate('Online_Shopping').' | '.$web_config['name']->value.' '.translate('ecommerce'))
@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="Welcome To {{$web_config['name']->value}}"/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">

    <meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="Welcome To {{$web_config['name']->value}}"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{{ substr(strip_tags(str_replace('&nbsp;', ' ', $web_config['about']->value)),0,160) }}">
@endpush

@section('content')
    <main class="main-content d-flex flex-column gap-3">
        <!-- Main Banner -->
        @include('theme-views.partials._main-banner')

        <!-- Flash Deal -->
        @if ($web_config['flash_deals'])
            @include('theme-views.partials._flash-deals')
        @endif

        @include('theme-views.partials._center_section_list')

        <!-- Find What You Need -->
        @include('theme-views.partials._find-what-you-need')


        @include('theme-views.partials._center_section_2_list')

        <!-- Top Stores -->
        @if ($web_config['business_mode'] == 'multi' && count($top_sellers) > 0)
            @include('theme-views.partials._top-stores')
        @endif

        <!-- Featured Deals -->
        @if ($web_config['featured_deals']->count()>0)
            @include('theme-views.partials._featured-deals')
        @endif

        <!-- Recommended For You -->
        @include('theme-views.partials._recommended-product')

        <!-- More Stores -->
        @if($web_config['business_mode'] == 'multi')
            @include('theme-views.partials._more-stores')
        @endif

        <!-- Top Rated Products -->
        @include('theme-views.partials._top-rated-products')

         <!-- Call To Action -->
         @if (isset($main_section_banner))
        <section class="">
            <div class="container">
                <div class="py-5 rounded position-relative">
                    <a href="{{$main_section_banner ? $main_section_banner->url:''}}" >
                        <img src="{{asset('storage/app/public/banner')}}/{{$main_section_banner ? $main_section_banner['photo'] : ''}}"
                         onerror="this.src='{{theme_asset('assets/img/main-section-banner-placeholder.png')}}'"
                         alt="" class="rounded dark-support img-fit start-0 top-0 index-n1 flipX-in-rtl h-auto">
                    </a>
                </div>
            </div>
        </section>
        @endif

        <!-- Today’s Best Deal an Just for you -->
        @include('theme-views.partials._best-deal-just-for-you')

        <!-- Home Categories -->

       

        <style>
            #mobile_app_section 
            {
                background-image: url('/public/assets/front-end/img/mian_banners.png');
                background-size: cover; 
                background-position: center; 
            }

        </style>

        <section class="py-2">
            <div class="container">
                <div class="py-5 rounded position-relative" id="mobile_app_section">
                    <div class="text-center">
                        <div style="margin-left:20%">
                            <h1>Download Zigamart <br> App Now</h1><br>
                            <span>Efficient, Simple, and Delightful <br>
                            Unlock the app's magic in just 30 seconds!</span>
                            <br><br>
                            @if($web_config['android']['status'])
                                <a href="{{ $web_config['android']['link'] }}"><img src="{{ theme_asset('assets/img/media/google-play.png') }}" loading="lazy" alt=""></a>
                            @endif
                            @if($web_config['ios']['status'])
                                <a href="{{ $web_config['ios']['link'] }}"><img src="{{ theme_asset('assets/img/media/app-store.png') }}" loading="lazy" alt=""></a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection

