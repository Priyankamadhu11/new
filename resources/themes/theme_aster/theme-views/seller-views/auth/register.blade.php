@extends('theme-views.layouts.app')
@section('title', translate('Seller_Apply').' | '.$web_config['name']->value.' '.translate('ecommerce'))
@section('content')

<style>
    .col-sec
    {
        display: flex;
        align-items: center;
        flex-direction: column;
    }
    .vertical_line
    {
        background: purple;
        position: absolute;
        height: 30%;
        z-index: -1;
        width: 2px;
        left: 0;
        right: 0;
        margin: 4px auto;
    }
</style>
    <!-- Main Content -->
    <main class="main-content d-flex flex-column gap-3 mb-sm-5">
        <div class="container">
            <div class="card">
                <div class="card-body p-0">
                    @php
                        $seller_banners = App\Model\SellerBanner::where('published', 1)->get();
                    @endphp

                    @if(isset($seller_banners))
                        <div class="swiper-container shadow-sm rounded">
                            <div class="swiper" data-swiper-loop="true" data-swiper-navigation-next="null" data-swiper-navigation-prev="null">
                                <div class="swiper-wrapper">
                                    @foreach($seller_banners as $key=>$banner)
                                        <div class="swiper-slide">
                                            <a href="{{ $banner['url'] }}" class="h-100">
                                                <img src="{{asset('storage/app/public/seller-banner')}}/{{$banner['photo']}}" loading="lazy" onerror="this.src='{{theme_asset('assets/img/image-place-holder-2_1.png')}}'" alt="" class="dark-support rounded">
                                            </a>
                                        </div>
                                    @endforeach
                                    @if(count($seller_banners)==0)
                                        <img src="{{theme_asset('assets/img/image-place-holder-2_1.png')}}" loading="lazy" alt="" class="dark-support rounded">
                                    @endif
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                            </div>
                        </div>
                    @endif
                </div>
               
                <div class="card-body p-sm-4" id="targetSection">
                    <div class="row justify-content-between gy-4">
                        <div class="col-lg-4">
                                    <div class="bg-light p-3 p-sm-4 rounded h-100">
                                        <div class="d-flex justify-content-center">
                                            <div class="ext-center">
                                                <h2 class="mb-2">{{translate('Seller_Registration')}}</h2>
                                                <p>{{translate('Create_your_own_store.')}}</p>

                                                <div class="my-4 text-center">
                                                    <img width="500" src="/public/assets/front-end/img/ZIGAMART-SELLER-AD.gif" loading="lazy" alt="" class="dark-support">
                                                </div>
                                                <p class="text-primary">{{translate('Open your doors and start selling. Establish your own business.')}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-xl-7">
                                    <span class="float-end">{{translate('Already_have_store')}}?  <a class="text-primary fs-5 fw-bold" href="{{route('seller.auth.login')}}">{{translate('Login')}}</a></span>
                                    <form id="seller-registration" action="{{route('shop.apply')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="wizard">
                                            <h3>{{translate('Seller_Info')}}</h3>
                                            <section>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label for="firstName">{{translate('First_Name')}}<span class="text-danger">*</span></label>
                                                            <input class="form-control" type="text" id="firstName" name="f_name" value="{{old('f_name')}}" placeholder="{{translate('Ex')}} : Jhon" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label for="lastName">{{translate('Last_Name')}}<span class="text-danger">*</span></label>
                                                            <input class="form-control" type="text" id="lastName" name="l_name" value="{{old('l_name')}}" placeholder="{{translate('Ex')}} : Doe" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label for="email2">{{translate('Email')}}<span class="text-danger">*</span></label>
                                                            <input class="form-control" type="email" id="email2"  name="email" value="{{old('email')}}" placeholder="{{translate('Enter_email')}}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label for="tel">{{translate('Phone')}}<span class="text-danger">*</span></label>
                                                            <input class="form-control" type="tel" id="tel" name="phone" value="{{old('phone')}}" placeholder="{{translate('Enter_phone_number')}}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label for="password">{{translate('Password')}}<span class="text-danger">*</span></label>
                                                            <div class="input-inner-end-ele">
                                                                <input class="form-control" type="password" id="password"  name="password" value="{{old('password')}}" placeholder="{{translate('Enter_password')}}" required>
                                                                <i class="bi bi-eye-slash-fill togglePassword"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label for="repeat_password">{{translate('Confirm_Password')}}<span class="text-danger">*</span></label>
                                                            <div class="input-inner-end-ele">
                                                                <input class="form-control" type="password" id="repeat_password" name="repeat_password" placeholder="{{translate('repeat_password')}}" required>
                                                                <i class="bi bi-eye-slash-fill togglePassword"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="media gap-3 align-items-center">
                                                            <div class="upload-file">
                                                                <input type="file" class="upload-file__input" name="image" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                                                                <div class="upload-file__img">
                                                                    <div class="temp-img-box">
                                                                        <div class="d-flex align-items-center flex-column gap-2">
                                                                            <i class="bi bi-upload fs-30"></i>
                                                                            <div class="fs-12 text-muted">{{translate('Upload_File')}}</div>
                                                                        </div>
                                                                    </div>
                                                                    <img src="#" class="dark-support img-fit-contain border" alt="" hidden>
                                                                </div>
                                                            </div>

                                                            <div class="media-body d-flex flex-column gap-1 upload-img-content">
                                                                <h5 class="text-uppercase mb-1">{{translate('Seller_Image')}}<span class="text-danger">*</span></h5>
                                                                <div class="text-muted">{{translate('Image_Ration')}} 1:1</div>
                                                                <div class="text-muted">
                                                                    {{translate('NB')}}: {{translate('image_size_must_be_within')}} 2 MB <br>
                                                                    {{translate('NB')}}: {{translate('image_type_must_be_within')}} .jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>

                                            <h3>{{translate('Shop_Info')}}</h3>
                                            
                                            <section>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label for="storeName">{{translate('Store_Name')}}<span class="text-danger">*</span></label>
                                                            <input class="form-control" type="text" id="storeName" name="shop_name" placeholder="{{translate('Ex')}}: {{translate('halar')}}" value="{{old('shop_name')}}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group mb-4">
                                                            <label for="storeAddress">{{translate('Store_Address')}}<span class="text-danger">*</span></label>
                                                            <input class="form-control" type="text" id="storeAddress" name="shop_address" value="{{old('shop_address')}}" placeholder="{{translate('Ex_:_Shop_-12_Road-8') }}" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 mb-4">
                                                        <div class="d-flex flex-column gap-3 align-items-center">
                                                            <div class="upload-file">
                                                                <input type="file" class="upload-file__input" name="banner" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                                                                <div class="upload-file__img style--two">
                                                                    <div class="temp-img-box">
                                                                        <div class="d-flex align-items-center flex-column gap-2">
                                                                            <i class="bi bi-upload fs-30"></i>
                                                                            <div class="fs-12 text-muted">{{translate('Upload_File')}}</div>
                                                                        </div>
                                                                    </div>
                                                                    <img src="#" class="dark-support img-fit-contain border" alt="" hidden>
                                                                </div>
                                                            </div>

                                                            <div class="text-center">
                                                                <h5 class="text-uppercase mb-1">{{translate('Store_Banner')}}<span class="text-danger">*</span></h5>
                                                                <div class="text-muted">{{translate('Image_Ratio')}} 3:1</div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if(theme_root_path() == "theme_aster")
                                                    <div class="col-lg-6 mb-4">
                                                        <div class="d-flex flex-column gap-3 align-items-center">
                                                            <div class="upload-file">
                                                                <input type="file" class="upload-file__input" name="bottom_banner" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                                                                <div class="upload-file__img style--two">
                                                                    <div class="temp-img-box">
                                                                        <div class="d-flex align-items-center flex-column gap-2">
                                                                            <i class="bi bi-upload fs-30"></i>
                                                                            <div class="fs-12 text-muted">{{translate('Upload_File')}}</div>
                                                                        </div>
                                                                    </div>
                                                                    <img src="#" class="dark-support img-fit-contain border" alt="" hidden>
                                                                </div>
                                                            </div>

                                                            <div class="text-center">
                                                                <h5 class="text-uppercase mb-1">{{translate('Store_Secondary_Banner')}}<span class="text-danger">*</span></h5>
                                                                <div class="text-muted">{{translate('Image_Ratio')}} 3:1</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    <div class="col-lg-6 mb-4">
                                                        <div class="d-flex flex-column gap-3 align-items-center">
                                                            <div class="upload-file">
                                                                <input type="file" class="upload-file__input" name="logo" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                                                                <div class="upload-file__img">
                                                                    <div class="temp-img-box">
                                                                        <div class="d-flex align-items-center flex-column gap-2">
                                                                            <i class="bi bi-upload fs-30"></i>
                                                                            <div class="fs-12 text-muted">{{translate('Upload_File')}}</div>
                                                                        </div>
                                                                    </div>
                                                                    <img src="#" class="dark-support img-fit-contain border" alt="" hidden>
                                                                </div>
                                                            </div>

                                                            <div class="text-center">
                                                                <h5 class="text-uppercase mb-1">{{translate('Store_Logo')}}<span class="text-danger">*</span></h5>
                                                                <div class="text-muted">{{translate('Image_Ratio')}} 1:1</div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    @if($web_config['recaptcha']['status'] == 1)
                                                    <div class="col-12">
                                                        <div id="recaptcha_element_seller_regi" class="w-100 mt-4" data-type="image"></div>
                                                        <br/>
                                                    </div>
                                                    @else
                                                    <div class="col-12">
                                                        <div class="row py-2 mt-4">
                                                            <div class="col-6 pr-2">
                                                                <input type="text" class="form-control border __h-40" name="default_recaptcha_id_seller_regi" value=""
                                                                    placeholder="{{ translate('Enter_captcha_value') }}" autocomplete="off" required>
                                                            </div>
                                                            <div class="col-6 input-icons mb-2 rounded bg-white">
                                                                <a onclick="re_captcha_seller_regi();" class="d-flex align-items-center align-items-center">
                                                                    <img src="{{ URL('/seller/auth/code/captcha/1?captcha_session_id=default_recaptcha_id_seller_regi') }}" class="input-field rounded __h-40" id="default_recaptcha_id_regi">
                                                                    <i class="bi bi-arrow-repeat icon cursor-pointer p-2"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    <div class="col-12">
                                                        <label class="custom-checkbox">
                                                            <input id="acceptTerms" name="acceptTerms" type="checkbox" required>
                                                            {{translate('I_agree_with_the')}} <a target="_blank" href="{{route('terms')}}">{{translate('terms_and_condition')}}.</a>
                                                        </label>
                                                    </div>

                                                </div>
                                            </section>

                                        </div>
                                </form>
                            </div>
                    </div>
                </div>
               
                <hr style="border-top:2px solid" class="pb-5">
                <section class="container">
                    <h2 class="text-center text-danger">Discover the simplicity of selling on Zigamart</h2>
                    <div class="row py-5 align-items-center">
                        <div class="col-md-5">
                            <h4 class="text-danger">Step 1: Sign up and Showcase Your Products</h4><br>
                            <ul>
                                <li>Sign up for your account and build your product inventory.</li>
                                <li>Market your own brand or retail existing brands.</li>
                                <li>Access self-paced tutorials.</li>
                                <li>Purchase packaging materials directly from our platform to kickstart sales.</li>
                            </ul>
                        </div>
                        <div class="col-md-2 text-center">
                            <img src="/public/assets/front-end/img/list-step-1.png" alt="" />
                            <div class="vertical_line"></div>
                        </div>
                        <div class="col-md-5 text-center "><img src="/public/assets/front-end/img/Register_yourself_and_List_your_products.png" alt="" width="200" /></div>
                    </div>
                    <div class="row py-5 align-items-center">
                        <div class="col-md-5 text-center"><img src="/public/assets/front-end/img/Get_support_from_professional_service_provider.png" alt="" width="200" /></div>
                        <div class="col-md-2 text-center">
                            <img src="/public/assets/front-end/img/list-step-2.png" alt="" />
                            <div class="vertical_line"></div>
                        </div>
                        <div class="col-md-5">
                            <h4 class="text-danger">Step 2: Utilize Professional Services</h4><br>
                            <ul>
                                <li>Obtain seamless documentation and cataloging through our network of Professional Service providers across India.</li>
                                <li>Enhance your product's visibility with professional-grade photoshoots conducted by our partnered photographers.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row py-5 align-items-center">
                        <div class="col-md-5">
                            <h4 class="text-danger">Step 3: Fulfill Orders & Coordinate Pickup</h4><br>
                            <ul>
                                <li>Upon listing, your products reach millions of potential customers across India.</li>
                                <li>Manage incoming orders and oversee your online enterprise seamlessly using our Seller Panel and Seller Zone Mobile App.</li>
                            </ul>
                        </div>
                        <div class="col-md-2 text-center">
                            <img src="/public/assets/front-end/img/list-step-3.png" alt="" />
                            <div class="vertical_line"></div>

                        </div>
                        <div class="col-md-5 text-center"><img src="/public/assets/front-end/img/Receive_orders_Schedule_a_pickup.png" alt="" width="200" /></div>
                    </div>
                    <div class="row py-5 align-items-center">
                        <div class="col-md-5 text-center"><img src="/public/assets/front-end/img/Receive_quick_payment_grow_your_business.png" alt="" width="200" /></div>
                        <div class="col-md-2 text-center">
                            <img src="/public/assets/front-end/img/list-step-4.png" alt="" />
                        </div>
                        <div class="col-md-5">
                            <h4 class="text-danger">Step 4: Rapid Payment & Business Development</h4><br>
                            <ul>
                                <li>Receive fast and trouble-free payments directly to your account upon order completion.</li>
                                <li>Grow Your Business Efficiently with Cost-Effective Digital Marketing and SMO Strategies.</li>
                            </ul>
                        </div>
                    </div>
                </section>
                <hr style="border-top:2px solid">
                <div class="d-flex justify-content-evenly py-3">
                   <div class="col-sec text-center">
                        <img src="/public/assets/front-end/img/sell-accross-india.png"  alt=""/>
                        <span>Sell around the clock <br> reaching customers in 2500 cities and towns</span>
                   </div>
                   <div class="col-sec text-center">
                        <img src="/public/assets/front-end/img/largest-online-mk-place.png" alt="" />
                        <span>With millions of users and a seller base of over half a million <br>we cover the length and breadth of India </span>
                   </div>
                   <div class="col-sec text-center">
                        <img src="/public/assets/front-end/img/on-time-payment.png" alt=""/>
                        <span>Speedy transactions with <br> clear and open procedures</span>
                   </div>
                </div>
                <div class="text-center pt-5">
                    <h2>Kickstart your enterprise with Zigamart and <br> tap into a broad customer base <br> across India</h2>
                    <button class="mt-3 m-auto btn btn-primary fs-5" id="scrollToSection"> Start selling now!</button>
                </div>
            </div>
        </div>
    </main>
    <!-- End Main Content -->
@endsection

@push('script')
    <!-- Page Level Scripts -->
    <script src="{{theme_asset('assets/plugins/jquery-step/jquery.validate.min.js')}}"></script>
    <script src="{{theme_asset('assets/plugins/jquery-step/jquery.steps.min.js')}}"></script>
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>

@if($web_config['recaptcha']['status'] == '1')
    <script>
        var onloadCallback = function () {
            let reg_id = grecaptcha.render('recaptcha_element_seller_regi', {'sitekey': '{{ $web_config['recaptcha']['site_key'] }}'});
            let login_id = grecaptcha.render('recaptcha_element_seller_login', {'sitekey': '{{ $web_config['recaptcha']['site_key'] }}'});

            $('#recaptcha_element_seller_regi').attr('data-reg-id', reg_id);
            $('#recaptcha_element_seller_login').attr('data-login-id', login_id);
        };
    </script>
@else
    <script>
        function re_captcha_seller_regi() {
            $url = "{{ URL('/seller/auth/code/captcha/') }}";
            $url = $url + "/" + Math.random()+'?captcha_session_id=default_recaptcha_id_seller_regi';

            document.getElementById('default_recaptcha_id_regi').src = $url;
            console.log('url: '+ $url);
        }
    </script>
@endif

    <script>
        // Multi Step Form

        $(document).ready(function(){
            $('#seller-registration [href="#next"]').text("{{ translate('next') }}");
            $('#seller-registration [href="#previous"]').text("{{ translate('previous') }}");
        });

        var form = $("#seller-registration");
        form.validate({
            errorPlacement: function errorPlacement(error, element) { element.before(error); },
            rules: {
                repeat_password: {
                    equalTo: "#password"
                }
            }
        });

        // Form Wizard
        form.children(".wizard").steps({
            headerTag: "h3",
            bodyTag: "section",
            onStepChanging: function (event, currentIndex, newIndex)
            {
                $('[href="#next"]').text("{{ translate('next') }}");
                $('[href="#previous"]').text("{{ translate('previous') }}");
                $('[href="#finish"]').text("{{ translate('finish') }}");
                $('[href="#finish"]').addClass('disabled');

                $('#acceptTerms').click(function(){
                    if ($(this).is(':checked')) {
                        $('[href="#finish"]').removeClass('disabled');
                    }else{
                        $('[href="#finish"]').addClass('disabled');
                    }
                });

                if (currentIndex > newIndex) {
                    return true;
                }
                if (currentIndex < newIndex) {
                    form.find('.body:eq(' + newIndex + ') label.error').remove();
                    form.find('.body:eq(' + newIndex + ') .error').removeClass('error');
                }
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            onFinishing: function (event, currentIndex)
            {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function (event, currentIndex)
            {
                @if($web_config['recaptcha']['status'] == '1')
                    if(currentIndex > 0){
                        var response = grecaptcha.getResponse($('#recaptcha_element_seller_regi').attr('data-reg-id'));
                        if (response.length === 0) {
                            toastr.error("{{translate('Please_check_the_recaptcha')}}");
                        }else{
                            $('#seller-registration').submit();
                        }
                    }
                @else
                    $('#seller-registration').submit();
                @endif
            }
        });



        $(document).ready(function(){
            $("#scrollToSection").click(function() {
                $('html, body').animate({
                    scrollTop: $("#targetSection").offset().top
                }, 1000); 
            });
        });
    </script>

@endpush
