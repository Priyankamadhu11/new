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

    @if(isset($banners[0]))
    <div class="container">
        <div class="pb-3 rounded position-relative">
                <a href="{{$banners[0]->url}}" target="_blank">
                    <img src="{{asset('storage/app/public/banner')}}/{{$banners[0]->photo}}" 
                         alt="" class="rounded dark-support img-fit start-0 top-0 index-n1 flipX-in-rtl h-auto">
                </a>
                </div>
        </div>
    </div>
    @endif

    @php
        $jaggery_list = \app\Model\Product::where('category_id',57)->where('status',1)->get();
        $cat_name=\app\Model\Category::where('id',57)->first();
    @endphp

    @if($jaggery_list)
        <div class="container">
            
            <div class="d-flex flex-wrap justify-content-between gap-3 mb-4">
                <h2>{{$cat_name->name}}</h2>
            </div>
            <div class="row g-2 g-sm-4 pb-5">
            

                @foreach ($jaggery_list as $key => $image)
                    <div class="col-3 d-none d-sm-block text-center">
                        @if($image->used_or_new == 1)
                            <div id="refurbished">Refurbished Product</div>
                        @endif
                        <a href="{{route('product',$image->slug)}}" class="ad-hover h-100 ">
                            @php
                                $images = json_decode($image['images']);
                                $firstImage = isset($images[0]) ? $images[0] : null;
                            @endphp
                            <img src="{{ asset('storage/app/public/product/' . $firstImage) }}" loading="lazy" alt="" onerror="this.src='{{ theme_asset('assets/img/image-place-holder-2_1.png') }}'" class="dark-support rounded w-100 img-fit">
                        </a>
                        <span class="text-center pt-2">{{$image->name}}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

   

</section>
