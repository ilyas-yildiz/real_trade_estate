<footer class="footer-style1">

    <div class="footer-main">
        <div class="footer-main-top">
            <div class="container">
                <div class="row">

                    <div class="col-xl-3 col-lg-6 col-md-6 single-widget">
                        <div class="single-footer-widget wow fadeInUp" data-wow-duration="1200ms"
                            data-wow-delay="000ms">
                            <div class="single-footer-widget-contact">
                                <div class="footer-logo-style1">
                                    <a href="{{ route('frontend.home') }}">
                                        <img src="{{ asset('frontend/assets/images/resources/footer-1-logo-1.png') }}" alt="Logo">
                                    </a>
                                </div>
                                <div class="text-box">
                                    {{-- Veritabanından gelen veri çevrilmez, olduğu gibi basılır --}}
                                    <p>{{ $settings['footer_aboutus'] ?? __('messages.footer_desc_default') }}</p>
                                </div>
                                <div class="your-trading">
                                    <div class="title1">
                                        {{-- GÜNCELLEME: Çeviri --}}
                                        <h3>{{ __('messages.begin_trading') }}</h3>
                                    </div>
                                    <div class="btn-box">
                                        <a href="{{ route('register') }}" class="btn-one">
                                            <span class="txt">
                                                {{ __('messages.new_account') }}
                                                <i class="icon-right-arrow"></i>
                                            </span>
                                        </a>
                                        <a href="{{ route('login') }}" class="btn-one">
                                            <span class="txt">
                                                {{ __('messages.sign_in') }}
                                                <i class="icon-right-arrow"></i>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-6 col-md-6 single-widget">
                        <div class="single-footer-widget wow fadeInDown" data-wow-duration="1200ms"
                            data-wow-delay="100ms">
                            <div class="title">
                                <h3>{{ __('messages.trading') }}</h3>
                            </div>
                            <div class="footer-widget-links">
                                <ul>
                                    <li><a href="#">Trading <i class="icon-right-arrow"></i></a></li>
                                    <li><a href="#">Commodities <i class="icon-right-arrow"></i></a></li>
                                    <li><a href="#">Indices <i class="icon-right-arrow"></i></a></li>
                                    <li><a href="#">Stocks <i class="icon-right-arrow"></i></a></li>
                                    <li><a href="#">Cryptocurrencies <i class="icon-right-arrow"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-6 col-md-6 single-widget">
                        <div class="single-footer-widget wow fadeInDown" data-wow-duration="1200ms"
                            data-wow-delay="200ms">
                            <div class="title">
                                <h3>{{ __('messages.platform') }}</h3>
                            </div>
                            <div class="footer-widget-links">
                                <ul>
                                    <li><a href="#">Web Trader <i class="icon-right-arrow"></i></a></li>
                                    <li><a href="#">Meta Trader 5 <i class="icon-right-arrow"></i></a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="single-footer-widget mt28 wow fadeInUp" data-wow-duration="1500ms"
                            data-wow-delay="300ms">
                            <div class="title">
                                <h3>{{ __('messages.support') }}</h3>
                            </div>
                            <div class="footer-widget-links">
                                <ul>
                                    <li><a href="#">{{ __('messages.faq') }} <i class="icon-right-arrow"></i></a></li>
                                    <li><a href="{{ route('frontend.contact') }}">{{ __('messages.get_in_touch') }} <i class="icon-right-arrow"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-6 col-md-6 single-widget">
                        <div class="single-footer-widget wow fadeInDown" data-wow-duration="1200ms"
                            data-wow-delay="400ms">
                            <div class="title">
                                <h3>{{ __('messages.company') }}</h3>
                            </div>
                            <div class="footer-widget-links">
                                <ul>
                                    <li><a href="{{ route('frontend.about') }}">{{ __('messages.about_us') }} <i class="icon-right-arrow"></i></a></li>
                                    <li><a href="{{ route('frontend.blog.index') }}">{{ __('messages.blog') }} <i class="icon-right-arrow"></i></a></li>
                                    <li><a href="{{ route('frontend.contact') }}">{{ __('messages.careers') }} <i class="icon-right-arrow"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-md-6 single-widget">
                        <div class="single-footer-widget ml30 wow fadeInDown" data-wow-duration="1200ms"
                            data-wow-delay="500ms">
                            <div class="title">
                                <h3>{{ __('messages.trading_guides') }}</h3>
                            </div>
                            <div class="footer-widget-trading-guides">
                                <div class="img-box">
                                    <img src="{{ asset('frontend/assets/images/footer/footer-v1-img1.png') }}" alt="Image">
                                </div>
                                <div class="courses">
                                    <h6>10+ {{ __('messages.courses') }}</h6>
                                </div>
                                <div class="btn-box">
                                    <a href="#"><i class="icon-download"></i></a>
                                </div>
                                <div class="title2">
                                    <h2>{{ __('messages.free_ebook') }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="footer-main-bottom">
            <div class="container">
                <div class="footer-main-bottom__inner">
                    <div class="left-box">
                        <div class="icon-box">
                            <a href="#"><span class="icon-app-store"></span></a>
                            <a href="#"><span class="icon-google-play"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></span></a>
                        </div>
                        <div class="text">
                            {{-- !! !! kullanarak <br> etiketinin çalışmasını sağlıyoruz --}}
                            <p>{!! __('messages.join_traders', ['count' => '2.5m']) !!}</p>
                        </div>
                    </div>
                    
                    <ul class="middle-box clearfix">
                        @if(!empty($settings['facebook_url']))
                        <li>
                            <a href="{{ $settings['facebook_url'] }}" target="_blank">
                                <div class="icon"><i class="icon-facebook"></i></div>
                                <div class="text"><p>Facebook</p></div>
                            </a>
                        </li>
                        @endif
                        {{-- ... Diğer sosyal medya linkleri (değişiklik yok) ... --}}
                    </ul>

                    <div class="right-box">
                        @if(!empty($settings['telegram_url']))
                        <div class="text">
                            <p>{!! __('messages.telegram_support') !!}</p>
                        </div>
                        <div class="icon">
                            <a href="{{ $settings['telegram_url'] }}" target="_blank">
                                <i class="icon-telegram-1"></i>
                            </a>
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="bottom-inner">
                <div class="copyright-text wow fadeInLeft" data-wow-duration="1500ms" data-wow-delay="000ms">
                    <p>{{ $settings['copyright_text'] ?? 'Copyrights © 2025 Real Trade State. All rights reserved.' }}</p>
                </div>
                <div class="footer-menu wow fadeInRight" data-wow-duration="1500ms" data-wow-delay="200ms">
                    <ul class="clearfix">
                        <li><a href="#">{{ __('messages.privacy_policy') }}</a></li>
                        <li><a href="#">{{ __('messages.terms_of_service') }}</a></li>
                        <li><a href="#">{{ __('messages.risk_disclosure') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>