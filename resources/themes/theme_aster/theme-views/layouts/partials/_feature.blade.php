<!-- Feature -->
<section class="feature-secton">
    <div class="container py-3">
        <div class="feature-section-inner">
            <div class="row g-3 g-lg-4">
                <div class="col-lg-3 col-sm-6">
                    <div class="media gap-3 mb-3 align-items-center">
                        <div class="feature-icon-wrap">
                            <img src="/public/assets/front-end/img/icons/f11d.png" alt="">
                        </div>
                        <div class="media-body">
                            <h5 class="mb-2 text-light">{{translate('Everywhere Availability')}}</h5>
                            <div class="fs-12">{{translate('Anytime Accessibility')}}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="media gap-3 mb-3 align-items-center">
                        <div class="feature-icon-wrap">
                            <img src="{{theme_asset('assets/img/icons/f2.png')}}" alt="">
                        </div>
                        <div class="media-body">
                            <h5 class="mb-2 text-light">{{translate('Authentic_Products')}}</h5>
                            <div class="fs-12">100% {{translate('Authentic_Products')}}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="media gap-3 mb-3 align-items-center">
                        <div class="feature-icon-wrap">
                            <img src="{{theme_asset('assets/img/icons/f3.png')}}" alt="">
                        </div>
                        <div class="media-body">
                            <h5 class="mb-2 text-light">100% {{translate('Secure_Payment')}}</h5>
                            <div class="fs-12">{{translate('We_Ensure_Secure_Transactions')}}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="media gap-3 mb-3 align-items-center">
                        <div class="feature-icon-wrap">
                            <img src="{{theme_asset('assets/img/icons/f4.png')}}" alt="">
                        </div>
                        <div class="media-body">
                            <h5 class="mb-2 text-light">{{translate('24/7_Support_Center')}}</h5>
                            <div class="fs-12">{{translate('We_Ensure_Quality_Support')}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section style="background:#510183;border: 1px dashed;">
    <div class="container py-3">
        <div class="row flex-nowrap w-100 text-light align-items-center">
            <div class="mt-3 mb-3 w-50">
                <div class="d-flex gap-2">
                    <h6 class="text-uppercase mb-2 font-weight-bold footer-heder text-light">{{translate('newsletter')}}</h6>
                        <i class="bi bi-send-fill mt-n1"></i>
                </div>
                <p>{{translate('subscribe_our_newsletter_to_get_latest_updates')}}</p>
            </div>
            <form class="newsletter-form w-50" action="{{ route('subscription') }}" method="post">
                @csrf
                <div class="position-relative">
                    <label class="position-relative m-0 d-block">
                        <i class="bi bi-envelope envelop-icon text-muted fs-18"></i>
                        <input type="text" placeholder="{{ translate('enter_your_email') }}" class="form-control" name="subscription_email" required>
                    </label>
                    <button type="submit" class="btn btn-primary">{{ translate('submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</section>

