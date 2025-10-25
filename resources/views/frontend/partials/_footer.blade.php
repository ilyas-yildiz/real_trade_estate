<!--Start footer Style1 -->
<footer class="footer-style1">

    <!--Start Footer Main-->
    <div class="footer-main">
        <div class="footer-main-top">
            <div class="container">
                <div class="row">

                    <!--Start Single Footer Widget-->
                    <div class="col-xl-3 col-lg-6 col-md-6 single-widget">
                        <div class="single-footer-widget wow fadeInUp" data-wow-duration="1200ms"
                            data-wow-delay="000ms">
                            <div class="single-footer-widget-contact">
                                <div class="footer-logo-style1">
                                    <a href="{{ route('frontend.home') }}">
                                        {{-- Logo (Ayarlardan veya statik) --}}
                                        <img src="{{ asset('frontend/assets/images/resources/footer-1-logo-1.png') }}" alt="Logo">
                                    </a>
                                </div>
                                <div class="text-box">
                                    {{-- Kısa açıklama (Ayarlardan) --}}
                                    <p>{{ $settings['footer_description'] ?? 'Business it will frequently to occur that pleasures have all repudiated and annoyances accepted.' }}</p>
                                </div>
                                <div class="your-trading">
                                    <div class="title1">
                                        <h3>Begin Your Trading,</h3>
                                    </div>
                                    <div class="btn-box">
                                        <a href="{{ route('register') }}" class="btn-one">
                                            <span class="txt">
                                                New Account
                                                <i class="icon-right-arrow"></i>
                                            </span>
                                        </a>
                                        <a href="{{ route('login') }}" class="btn-one">
                                            <span class="txt">
                                                Sign In
                                                <i class="icon-right-arrow"></i>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Single Footer Widget-->

                    <!--Start Single Footer Widget-->
                    <div class="col-xl-2 col-lg-6 col-md-6 single-widget">
                        <div class="single-footer-widget wow fadeInDown" data-wow-duration="1200ms"
                            data-wow-delay="100ms">
                            <div class="title">
                                <h3>Trading</h3>
                            </div>
                            <div class="footer-widget-links">
                                {{-- Bu linkleri ileride dinamik bir menüden çekebiliriz --}}
                                <ul>
                                    <li>
                                        <a href="#">
                                            Forex Trading
                                            <i class="icon-right-arrow"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Commodities
                                            <i class="icon-right-arrow"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Indices
                                            <i class="icon-right-arrow"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Stocks
                                            <i class="icon-right-arrow"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            Cryptocurrencies
                                            <i class="icon-right-arrow"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--End Single Footer Widget-->

                    <!--Start Single Footer Widget-->
                    <div class="col-xl-2 col-lg-6 col-md-6 single-widget">
                        <div class="single-footer-widget wow fadeInDown" data-wow-duration="1200ms"
                            data-wow-delay="200ms">
                            <div class="title">
                                <h3>Platform</h3>
                            </div>
                            <div class="footer-widget-links">
                                <ul>
                                    <li><a href="#">Web Trader <i class="icon-right-arrow"></i></a></li>
                                    <li><a href="#">Meta Trader 4 <i class="icon-right-arrow"></i></a></li>
                                    <li><a href="#">Meta Trader 5 <i class="icon-right-arrow"></i></a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="single-footer-widget mt28 wow fadeInUp" data-wow-duration="1500ms"
                            data-wow-delay="300ms">
                            <div class="title">
                                <h3>Support</h3>
                            </div>
                            <div class="footer-widget-links">
                                <ul>
                                    <li><a href="#">FAQ <i class="icon-right-arrow"></i></a></li>
                                    <li><a href="{{ route('frontend.contact') }}">Get in Touch <i class="icon-right-arrow"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--End Single Footer Widget-->

                    <!--Start Single Footer Widget-->
                    <div class="col-xl-2 col-lg-6 col-md-6 single-widget">
                        <div class="single-footer-widget wow fadeInDown" data-wow-duration="1200ms"
                            data-wow-delay="400ms">
                            <div class="title">
                                <h3>Company</h3>
                            </div>
                            <div class="footer-widget-links">
                                <ul>
                                    <li><a href="{{ route('frontend.about') }}">About Us <i class="icon-right-arrow"></i></a></li>
                                    <li><a href="{{ route('frontend.blog.index') }}">Blog <i class="icon-right-arrow"></i></a></li>
                                    <li><a href="{{ route('frontend.contact') }}">Careers <i class="icon-right-arrow"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!--End Single Footer Widget-->

                    <!--Start Single Footer Widget-->
                    <div class="col-xl-3 col-lg-6 col-md-6 single-widget">
                        <div class="single-footer-widget ml30 wow fadeInDown" data-wow-duration="1200ms"
                            data-wow-delay="500ms">
                            <div class="title">
                                <h3>Trading Guides</h3>
                            </div>
                            {{-- Bu bölüm statik kalabilir veya blogdan çekilebilir --}}
                            <div class="footer-widget-trading-guides">
                                <div class="img-box">
                                    <img src="{{ asset('frontend/assets/images/footer/footer-v1-img1.png') }}" alt="Image">
                                </div>
                                <div class="courses">
                                    <h6>10+ Courses</h6>
                                </div>
                                <div class="btn-box">
                                    <a href="#"><i class="icon-download"></i></a>
                                </div>
                                <div class="title2">
                                    <h2>Free Ebook</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Single Footer Widget-->

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
                            <p>Join with 2.5m <br>Traders.</p>
                        </div>
                    </div>
                    
                    {{-- Dinamik Sosyal Medya Linkleri ($settings'den) --}}
                    <ul class="middle-box clearfix">
                        @if(!empty($settings['facebook_url']))
                        <li>
                            <a href="{{ $settings['facebook_url'] }}" target="_blank">
                                <div class="icon"><i class="icon-facebook"></i></div>
                                <div class="text"><p>Facebook</p></div>
                            </a>
                        </li>
                        @endif
                        @if(!empty($settings['linkedin_url']))
                        <li>
                            <a href="{{ $settings['linkedin_url'] }}" target="_blank">
                                <div class="icon"><i class="icon-linkedin"></i></div>
                                <div class="text"><p>Linkedin</p></div>
                            </a>
                        </li>
                        @endif
                        @if(!empty($settings['youtube_url']))
                        <li>
                            <a href="{{ $settings['youtube_url'] }}" target="_blank">
                                <div class="icon"><i class="icon-youtube"></i></div>
                                <div class="text"><p>Youtube</p></div>
                            </a>
                        </li>
                        @endif
                        @if(!empty($settings['instagram_url']))
                        <li>
                            <a href="{{ $settings['instagram_url'] }}" target="_blank">
                                <div class="icon"><i class="icon-social"></i></div>
                                <div class="text"><p>Instagram</p></div>
                            </a>
                        </li>
                        @endif
                    </ul>

                    <div class="right-box">
                        @if(!empty($settings['telegram_url']))
                        <div class="text">
                            <p>Instant Support via <br>Telegram</p>
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
    <!--End Footer Main-->

    <!--Start Footer Bottom-->
    <div class="footer-bottom">
        <div class="container">
            <div class="bottom-inner">
                <div class="copyright-text wow fadeInLeft" data-wow-duration="1500ms" data-wow-delay="000ms">
                    {{-- Copyright (Ayarlardan) --}}
                    <p>{{ $settings['copyright_text'] ?? 'Copyrights © 2025 Tradebro. All rights reserved.' }}</p>
                </div>
                <div class="footer-menu wow fadeInRight" data-wow-duration="1500ms" data-wow-delay="200ms">
                    {{-- Bu linkler statik kalabilir veya admin panelinden yönetilebilir --}}
                    <ul class="clearfix">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Risk Disclosure</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--End Footer Bottom-->
</footer>
<!--End footer Style1 -->
