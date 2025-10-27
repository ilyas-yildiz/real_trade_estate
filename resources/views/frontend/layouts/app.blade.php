<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    {{-- Dinamik Başlık (Sayfaya özel veya varsayılan) --}}
    {{-- GÜNCELLEME: 'Tradebro' -> 'Real Trade Estate' --}}
    <title>@yield('title', config('app.name', 'Real Trade Estate'))</title>
    
    {{-- Favicons (Bunları public/frontend/assets... içine koyduğunu varsayıyorum) --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('frontend/assets/images/favicons/apple-touch-icon.png') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('frontend/assets/images/favicons/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('frontend/assets/images/favicons/favicon-16x16.png') }}" />
    
    {{-- Meta Açıklama (Sayfaya özel) --}}
    {{-- GÜNCELLEME: 'Tradebro HTML 5 Template' -> 'Real Trade Estate HTML 5 Template' --}}
    <meta name="description" content="@yield('description', 'Real Trade Estate HTML 5 Template')" />

    {{-- Vendor (Plugin) CSS Dosyaları --}}
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/animate/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/animate/custom-animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/aos/aos.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/bootstrap-touchspin/jquery.bootstrap-touchspin.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/fancybox/fancybox.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/fontawesome/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/jarallax/jarallax.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/jquery-magnific-popup/jquery.magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/jquery-ui/jquery-ui.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/nice-select/nice-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/odometer/odometer.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/owl-carousel/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/owl-carousel/owl.theme.default.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/swiper/swiper.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/timepicker/timePicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/vegas/vegas.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendors/thm-icons/style.css') }}" />

    {{-- Ana Tema CSS Dosyaları --}}
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/module-css/01-header-section.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/module-css/02-banner-section.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/module-css/03-about-section.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/module-css/04-fact-counter-section.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/module-css/05-testimonial-section.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/module-css/06-partner-section.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/module-css/07-footer-section.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/module-css/08-blog-section.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/module-css/09-breadcrumb-section.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/module-css/10-contact.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/module-css/11-services-section.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/module-css/13-team-section.css') }}" />

    {{-- Ana Stil Dosyaları --}}
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive.css') }}" />

    {{-- Sayfaya özel eklenecek CSS'ler için --}}
    @stack('styles')
</head>

<body class="body-bg-1">

    <div class="loader-wrap">
        <div class="preloader">
            <div id="handle-preloader" class="handle-preloader">
                <div class="layer layer-one"><span class="overlay"></span></div>
                <div class="layer layer-three"><span class="overlay"></span></div>
                <div class="layer layer-two"><span class="overlay"></span></div>
                <div class="animation-preloader">
                    <div class="spinner"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="cursor"></div>
    <div class="cursor-follower"></div>
    {{-- 
        Not: 'xs-sidebar-group' (sağdan açılan info menüsü) static bir yapıya benziyor. 
        İleride $settings'den gelen datayla doldurabiliriz ama şimdilik layout'ta kalabilir.
    --}}
    <div class="xs-sidebar-group info-group info-sidebar">
        <div class="xs-overlay xs-bg-black"></div>
        <div class="xs-sidebar-widget">
            <div class="sidebar-widget-container">
                <div class="widget-heading">
                    <a href="#" class="close-side-widget">X</a>
                </div>
                <div class="sidebar-textwidget">
                    {{-- Buradaki içerik statik veya $settings'den gelebilir --}}
                    <div class="sidebar-info-contents">
                        <div class="content-inner">
                            <div class="logo">
                                <a href="index.html">
                                    <img src="{{ asset('frontend/assets/images/resources/side-content__logo.png') }}" alt="" />
                                </a>
                            </div>
                            <div class="content-box">
                                <h3>Drive Safe & Smart with Us</h3>
                                <div class="inner-text">
                                    <p>
                                        Every pain avoided but in certain circumstances and owing to the claims of duty
                                        or the obligations of business it will frequently occur that pleasures have to
                                        be repudiated and annoyances accepted selection he rejects pleasures to secure.
                                    </p>
                                </div>
                            </div>
                            <div class="sidebar-contact-info">
                                <h3>Contact Us</h3>
                                {{-- Bu kısım ileride $settings'den dinamik olarak doldurulacak --}}
                                <ul>
                                    <li>...</li>
                                    <li>...</li>
                                </ul>
                            </div>
                            {{-- ... (Newsletter ve sosyal medya linkleri) ... --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-wrapper boxed_wrapper">

        {{-- Header (Menü) --}}
        @include('frontend.partials._header')


        {{-- ANA İÇERİK --}}
        {{-- Buraya home.blade.php, about.blade.php vb. dosyaların içeriği gelecek --}}
        @yield('content')


        {{-- Footer --}}
        @include('frontend.partials._footer')

    </div>
    {{-- Mobil Navigasyon (Statik kalabilir) --}}
    <div class="mobile-nav__wrapper">
        <div class="mobile-nav__overlay mobile-nav__toggler"></div>
        <div class="mobile-nav__content">
            <span class="mobile-nav__close mobile-nav__toggler">
                <i class="fa fa-times-circle"></i>
            </span>
            <div class="logo-box">
                <a href="index.html" aria-label="logo image">
                    <img src="{{ asset('frontend/assets/images/resources/mobile-nav-logo.png') }}" alt="" />
                </a>
            </div>
            <div class="mobile-nav-search-box">
                <form class="search-form" action="#">
                    <input placeholder="Keyword" type="text" />
                    <button type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>
            <div class="mobile-nav__container"></div>
            {{-- ... (Mobil iletişim bilgileri) ... --}}
        </div>
    </div>

    {{-- Arama Pop-up (Statik kalabilir) --}}
    <div class="search-popup">
        <div class="search-popup__overlay search-toggler">
            <div class="search-popup__close-btn">
                <span class="fa fa-times"></span>
            </div>
        </div>
        <div class="search-popup__content">
            <form action="#">
                <label for="search" class="sr-only">search here</label>
                <input type="text" id="search" placeholder="Search Here..." />
                <button type="submit" aria-label="search submit" class="thm-btn">
                    <i class="icon-search"></i>
                </button>
            </form>
        </div>
    </div>
    
    {{-- Scroll to top (Statik kalabilir) --}}
    <div class="scroll-to-top">
        <div>
            <div class="scroll-top-inner">
                <div class="scroll-bar">
                    <div class="bar-inner"></div>
                </div>
                <div class="scroll-bar-text">
                    <i class="icon-arrow-down"></i>
                </div>
            </div>
        </div>
    </div>
    {{-- Vendor (Plugin) JS Dosyaları --}}
    <script src="{{ asset('frontend/assets/vendors/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/aos/aos.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/bootstrap-touchspin/jquery.bootstrap-touchspin.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/countdown/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/fancybox/jquery.fancybox.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/isotope/isotope.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/jarallax/jarallax.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/jquery-ajaxchimp/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/jquery-appear/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/jquery-magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/nice-select/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/odometer/odometer.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/swiper/swiper.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/timepicker/timepicker.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/vegas/vegas.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/wow/wow.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/slick/slick.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/animate/sal.min.js') }}"></script>

    {{-- Gsap JS Dosyaları --}}
    <script src="{{ asset('frontend/assets/vendors/gsap/gsap.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/gsap/ScrollTrigger.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/gsap/SplitText.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/extra-scripts/extra-scripts.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/marquee/marquee.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/curved-text/jquery.circleType.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/curved-text/jquery.lettering.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendors/curved-text/jquery.fittext.js') }}"></script>

    {{-- Ana Tema JS --}}
    <script src="{{ asset('frontend/assets/js/custom.js') }}"></script>

    {{-- 
        Sayfaya özel JS dosyaları (örn: anasayfadaki slider'ı başlatan dosya) 
        @push('scripts') ile home.blade.php içinden buraya eklenecek.
        NOT: index.html'deki 'dashboard-ecommerce.init.js' dosyasını buraya koymadım, 
        çünkü o sadece anasayfaya özel ve onu home.blade.php içine koyacağız.
    --}}
    @stack('scripts')

</body>
</html>