@extends('frontend.layouts.app')

{{-- SEO Başlığı ve Açıklaması (Ayarlardan veya varsayılan) --}}
@section('title', $settings['seo_title'] ?? 'Real Trade State - Homepage')
{{-- GÜNCELLEME: Türkçe açıklama -> İngilizce açıklama --}}
@section('description', $settings['seo_description'] ?? 'Secure and fast trading platform.')

@section('content')

    <section class="main-slider-style1">
        <div class="main-slider-style1__inner">
            
            {{-- Statik Demo Mockup Alanı. silinecek sonrasında --}}
            <div class="top-box text-center">
                <div class="top-box__pattern"
                    style="background-image: url({{ asset('frontend/assets/images/pattern/slider-v1-pattern.png') }});">
                </div>
                <div class="title-box">
                    <h3>Free Demo</h3>
                    <p>Practice trading with virtual funds.</p>
                </div>
                <div class="img-box">
                    <img src="{{ asset('frontend/assets/images/slides/slider-v1-mockup.png') }}" alt="Img">
                </div>
                <div class="btn-box">
                    <a class="btn-one" href="{{ route('register') }}">
                        <span class="txt">Start Demo</span>
                        <i class="icon-right-arrow"></i>
                    </a>
                </div>
            </div>
            <div class="left-bottom-box">
                    <div class="top">
                        <div class="point">
                            <h2>4.9</h2>
                        </div>
                        <div class="rating">
                            <ul class="clearfix">
                                <li>
                                    <i class="icon-star"></i>
                                </li>
                                <li>
                                    <i class="icon-star"></i>
                                </li>
                                <li>
                                    <i class="icon-star"></i>
                                </li>
                                <li>
                                    <i class="icon-star"></i>
                                </li>
                                <li>
                                    <i class="icon-star"></i>
                                </li>
                            </ul>
                            <p>2.8k Verified Reviews</p>
                        </div>
                    </div>
                    <div class="btn-box">
                        <a href="#">
                            Read Reviews
                            <i class="icon-right-arrow"></i>
                        </a>
                    </div>
                </div>
                </div>
            {{-- Statik Highlights Alanı --}}
            <div class="main-slider-style1__highlights clearfix">
<!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container" id="tv-ticker-tape-container" style="width: 100%; height: 95px; background-color: transparent;">
    <div class="tradingview-widget-container__widget"></div>
    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
    {
      "symbols": [
      {
          "proName": "FOREXCOM:SPXUSD",
          "title": "S&P 500"
        },
        {
          "proName": "FOREXCOM:NSXUSD",
          "title": "US 100 (Nasdaq)"
        },
        {
          "proName": "FX_IDC:EURUSD",
          "title": "EUR/USD"
        },
        {
          "description": "Gold (Ons)",
          "proName": "OANDA:XAUUSD"
        },
        {
          "description": "Silver",
          "proName": "OANDA:XAGUSD"
        },
        {
          "description": "Brent Oil",
          "proName": "TVC:UKOIL"
        },
        {
          "description": "Crude Oil",
          "proName": "TVC:USOIL"
        },
        {
          "description": "Natural Gas",
          "proName": "TVC:NG1!"
        }
      ],
      "showSymbolLogo": true,
      "colorTheme": "light",
      "isTransparent": true,
      "displayMode": "adaptive",
      "locale": "en"
    }
    </script>
</div>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    // Bu fonksiyon, widget iframe'i oluşturana kadar bekler
    function forceTickerHeight() {
        try {
            // Ana konteyneri bul
            var container = document.getElementById('tv-ticker-tape-container');
            // Widget'ın oluşturduğu iframe'i bul
            var iframe = container.querySelector('iframe[id^="tradingview_widget"]');

            if (iframe) {
                // iframe'i bulduysak, yüksekliğini 95px yap
                iframe.style.height = '95px';
            } else {
                // Bulamadıysa, 100ms sonra tekrar dene
                setTimeout(forceTickerHeight, 100);
            }
        } catch (e) {
            console.error("TradingView Ticker hatası:", e);
        }
    }
    
    // Fonksiyonu başlat
    forceTickerHeight();
});
</script>
<!-- TradingView Widget END -->
</div>

            {{-- DİNAMİK SLIDER --}}
            <div class="swiper-container banner-slider-two">
                <div class="swiper-wrapper">

                    @forelse ($slides as $slide)
                    <div class="swiper-slide">
                        {{-- DÜZELTME: 'storage/' kaldırıldı (Paylaşımlı sunucu uyumlu) --}}
                        <div class="image-layer" style="background-image: url({{ $slide->image_url ? asset('storage/slide-images/1920x1080/' . $slide->image_url) : asset('assets/images/main-slider/slider5/slide1.jpg') }});">
                        </div>
                        <div class="container">
                            <div class="content-box">
                                <div class="big-title">
                                    <h2>{!! $slide->title !!}</h2> 
                                </div>
                                <div class="text">
                                    <p>{{ $slide->subtitle }}</p>
                                </div>
                                <div class="bottom-box">
                                    <div class="btn-box">
                                        <a class="btn-one" href="{{ $slide->link ?? '#' }}">
                                            <span class="txt">{{ $slide->button_text ?? 'Details' }}</span>
                                            <i class="icon-right-arrow"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="swiper-slide">
                        <div class="image-layer" style="background-image: url({{ asset('frontend/assets/images/slides/slide-v1-1.jpg') }});">
                        </div>
                        <div class="container">
                            <div class="content-box">
                                <div class="big-title">
                                    <h2>Secure<br> investing for<br> every trader</h2>
                                </div>
                                <div class="text">
                                    <p>Invest confidently with advanced security measures tailored to protect your trades.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforelse

                </div>
            </div>

            {{-- Slider Navigasyonu --}}
            <div class="banner-slider-nav">
                <div class="banner-slider-control banner-slider-button-prev">
                    <span><i class="icon-arrow-left" aria-hidden="true"></i></span>
                </div>
                <div class="banner-slider-control banner-slider-button-next">
                    <span><i class="icon-arrow-right" aria-hidden="true"></i></span>
                </div>
            </div>

        </div>
    </section>
    

    @if(isset($about))
    <section class="about-style1">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="about-style1__img">
                        <div class="img-box wow fadeInLeft animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                            {{-- DÜZELTME: 'storage/' kaldırıldı --}}
                            <img src="{{ $about->image ? asset($about->image) : asset('frontend/assets/images/about/about-v1-1.jpg') }}" alt="About Image">
                        </div>
                        {{-- Statik Award Badge --}}
                        <div class="about-style1__img-award text-center wow fadeInUp animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                            <div class="about-style1__img-award-top">
                                <div class="top">
                                    <div class="shape1"><img src="{{ asset('frontend/assets/images/about/logo-5.png') }}" alt="Real Trade Estate"></div>
                                </div>
                            </div>
                        </div>
                        {{-- Statik Yıl --}}
                        <div class="about-style1-round-text wow fadeInRight animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                            <div class="overlay-text"><div class="inner">24</div></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6">
                    <div class="about-style1__content wow fadeInRight animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                        <div class="sec-title">
                            {{-- GÜNCELLEME: 'About Tradebro' -> 'About Real Trade Estate' --}}
                            <div class="sub-title"><h4>About Real Trade Estate</h4></div>
                            <h2>{!! $about->title !!}</h2>
                        </div>
                        <div class="text">
                            <p>{{ $about->short_content }}</p>
                        </div>
                        
                        <div class="text-box">
                            <div class="icon"><div class="inner"><span class="icon-target"><span class="path1"></span></span></div></div>
<div class="text1">
    <p>{{ Str::limit(strip_tags($about->content), 100) }}</p>
</div>

                        </div>
                        <div class="btn-box">
                            <a href="{{ route('frontend.about') }}">
                                Read More
                                <i class="icon-right-arrow"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    {{-- Not: Bu bölüm şimdilik STATİK, ileride $settings'den çekilebilir --}}
    <section class="fact-counter-style1">
         <div class="fact-counter-style1__shape1">
            <img src="{{ asset('frontend/assets/images/shapes/fact-counter-v1-shape1.png') }}" alt="Shape">
        </div>
        {{-- ... (index.html'den statik sayaç bölümünün geri kalanı) ... --}}
    </section>
  
    {{-- Bu bölüm STATİK --}}
    <section class="platforms-style1">
            <div class="container">
                <div class="sec-title white">
                    <div class="sub-title">
                        <h4>Platforms</h4>
                    </div>
                    <h2>Powerful Trading Platforms for Every Trader</h2>
                </div>
                <div class="platforms-style1__inner">

                    <div class="platforms-style1__tab">

                        <div class="platforms-style1__img">
                            <div class="shape">
                                <img class="float-bob-y" src="{{ asset('frontend/assets/images/shapes/platforms-v1-shape1.png') }}" alt="Shape">
                            </div>
                            <div class="inner">
                                <img src="{{ asset('frontend/assets/images/resources/platforms-v1-11.png') }}" alt="Image" style="max-width: 400px;">
                            </div>
                        </div>



                        <div class="platforms-style1__content">

                            <div class="platforms-style1__tab-btn">
                                <ul class="tabs-button-box clearfix">
                                    <li data-tab="#trader-4" class="tab-btn-item active-btn-item">
                                        <div class="icon">
                                            <i class="icon-check"></i>
                                        </div>
                                        <h4>Meta <br>Trader 4</h4>
                                    </li>
                                    <li data-tab="#trader-5" class="tab-btn-item">
                                        <div class="icon">
                                            <i class="icon-check"></i>
                                        </div>
                                        <h4>Meta <br>Trader 5</h4>
                                    </li>
                                </ul>
                            </div>

                            <div class="tabs-content-box">

                                <!--Start Tab Single-->
                                <div class="tab-content-box-item tab-content-box-item-active" id="trader-4">
                                    <div class="platforms-style1-tab-content-box-item">

                                        <!--Start Single Platforms Style1 Tab -->
                                        <div class="single-platforms-style1-tab">
                                            <div class="text">
                                                <p>Denouncing pleasure and praising pain was born and will give complete
                                                    account of the system and expound.</p>
                                            </div>
                                            <ul class="list-item">
                                                <li>
                                                    <div class="icon">
                                                        <img src="{{ asset('frontend/assets/images/icon/icon-1.png') }}" alt="Icon">
                                                    </div>
                                                    <p>Extensive Technical Indicators</p>
                                                </li>
                                                <li>
                                                    <div class="icon">
                                                        <img src="{{ asset('frontend/assets/images/icon/icon-1.png') }}" alt="Icon">
                                                    </div>
                                                    <p>Automated Trading with Expert Advisors</p>
                                                </li>
                                                <li>
                                                    <div class="icon">
                                                        <img src="{{ asset('frontend/assets/images/icon/icon-1.png') }}" alt="Icon">
                                                    </div>
                                                    <p>Low Resource Requirements</p>
                                                </li>
                                            </ul>
                                        </div>
                                        <!--End Single Platforms Style1 Tab -->

                                    </div>
                                </div>
                                <!--End Tab Single-->

                                <!--Start Tab Single-->
                                <div class="tab-content-box-item" id="trader-5">
                                    <div class="platforms-style1-tab-content-box-item">

                                        <!--Start Single Platforms Style1 Tab -->
                                        <div class="single-platforms-style1-tab">
                                            <div class="text">
                                                <p>Denouncing pleasure and praising pain was born and will give complete
                                                    account of the system and expound.</p>
                                            </div>
                                            <ul class="list-item">
                                                <li>
                                                    <div class="icon">
<img src="{{ asset('frontend/assets/images/icon/icon-1.png') }}" alt="Icon">
                                                    </div>
                                                    <p>Extensive Technical Indicators</p>
                                                </li>
                                                <li>
                                                    <div class="icon">
                                                        <img src="{{ asset('frontend/assets/images/icon/icon-1.png') }}" alt="Icon">
                                                    </div>
                                                    <p>Automated Trading with Expert Advisors</p>
                                                </li>
                                                <li>
                                                    <div class="icon">
                                                        <img src="{{ asset('frontend/assets/images/icon/icon-1.png') }}" alt="Icon">
                                                    </div>
                                                    <p>Low Resource Requirements</p>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                                <!--End Tab Single-->
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>

    {{-- Bu bölüm STATİK --}}
<section class="how-it-work-style1">
            <div class="container">
                <div class="how-it-work-style1__top">
                    <div class="sec-title white">
                        <div class="sub-title">
                            <h4>How It’s Work</h4>
                        </div>
                        <h2>Step-by-Step Trading Guide</h2>
                    </div>
                    <div class="text">
                        <p>Pleasure and praising pain was born and will give complete system.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="owl-carousel owl-theme thm-owl__carousel how-it-work-style1-carousel owl-nav-style-one owl-loaded owl-drag" data-owl-options="{
                            &quot;loop&quot;: false,
                            &quot;autoplay&quot;: false,
                            &quot;margin&quot;: 30,
                            &quot;nav&quot;: true,
                            &quot;dots&quot;: false,
                            &quot;smartSpeed&quot;: 500,
                            &quot;autoplayTimeout&quot;: 10000,
                            &quot;navText&quot;: [&quot;&lt;span class=\&quot;left icon-arrow-left\&quot;&gt;&lt;/span&gt;&quot;,&quot;&lt;span class=\&quot;icon-arrow-right\&quot;&gt;&lt;/span&gt;&quot;],
                            &quot;responsive&quot;: {
                                    &quot;0&quot;: {
                                        &quot;items&quot;: 1
                                    },
                                    &quot;768&quot;: {
                                        &quot;items&quot;: 2
                                    },
                                    &quot;992&quot;: {
                                        &quot;items&quot;: 2
                                    },
                                    &quot;1200&quot;: {
                                        &quot;items&quot;: 3
                                    }
                                }
                            }">



                            <!-- Start Single How It Work Style1 -->
                            
                            <!-- End Single How It Work Style1 -->
                            <!-- Start Single How It Work Style1 -->
                            
                            <!-- End Single How It Work Style1 -->
                            <!-- Start Single How It Work Style1 -->
                            
                            <!-- End Single How It Work Style1 -->


                            <!-- Start Single How It Work Style1 -->
                            
                            <!-- End Single How It Work Style1 -->
                            <!-- Start Single How It Work Style1 -->
                            
                            <!-- End Single How It Work Style1 -->
                            <!-- Start Single How It Work Style1 -->
                            
                            <!-- End Single How It Work Style1 -->


                        <div class="owl-stage-outer"><div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: 0.5s; width: 2400px;"><div class="owl-item active" style="width: 370px; margin-right: 30px;"><div class="single-how-it-work-style1">
                                <div class="count-box counted">
                                    <div class="step">
                                        <h6>Step 01</h6>
                                    </div>
                                </div>
                                <div class="content-box">
                                    <div class="title">
                                        <h3><a href="#">Open Your Account</a></h3>
                                        <p>Always holds these matters to this principle of selection or else cases
                                            he endures pains.</p>
                                    </div>
                                </div>
                            </div></div><div class="owl-item active" style="width: 370px; margin-right: 30px;"><div class="single-how-it-work-style1">
                                <div class="count-box counted">
                                    <div class="step">
                                        <h6>Step 02</h6>
                                    </div>
                                </div>
                                <div class="content-box">
                                    <div class="title">
                                        <h3><a href="#">Fund Your Account</a></h3>
                                        <p>Beguiled and demoralized the charms of pleasure of the moment, so blinded
                                            by desire that they foresee.</p>
                                    </div>
                                </div>
                            </div></div><div class="owl-item active" style="width: 370px; margin-right: 30px;"><div class="single-how-it-work-style1">
                                <div class="count-box counted">
                                    <div class="step">
                                        <h6>Step 03</h6>
                                    </div>
                                </div>
                                <div class="content-box">
                                    <div class="title">
                                        <h3><a href="#">Choose Your Asset</a></h3>
                                        <p>Business it will frequently occur that pleasures have to be repudiated
                                            and annoyances accepted.</p>
                                    </div>
                                </div>
                            </div></div><div class="owl-item" style="width: 370px; margin-right: 30px;"><div class="single-how-it-work-style1">
                                <div class="count-box counted">
                                    <div class="step">
                                        <h6>Step 04</h6>
                                    </div>
                                </div>
                                <div class="content-box">
                                    <div class="title">
                                        <h3><a href="#">Open Your Account</a></h3>
                                        <p>Always holds these matters to this principle of selection or else cases
                                            he endures pains.</p>
                                    </div>
                                </div>
                            </div></div><div class="owl-item" style="width: 370px; margin-right: 30px;"><div class="single-how-it-work-style1">
                                <div class="count-box counted">
                                    <div class="step">
                                        <h6>Step 05</h6>
                                    </div>
                                </div>
                                <div class="content-box">
                                    <div class="title">
                                        <h3><a href="#">Fund Your Account</a></h3>
                                        <p>Beguiled and demoralized the charms of pleasure of the moment, so blinded
                                            by desire that they foresee.</p>
                                    </div>
                                </div>
                            </div></div><div class="owl-item" style="width: 370px; margin-right: 30px;"><div class="single-how-it-work-style1">
                                <div class="count-box counted">
                                    <div class="step">
                                        <h6>Step 06</h6>
                                    </div>
                                </div>
                                <div class="content-box">
                                    <div class="title">
                                        <h3><a href="#">Choose Your Asset</a></h3>
                                        <p>Business it will frequently occur that pleasures have to be repudiated
                                            and annoyances accepted.</p>
                                    </div>
                                </div>
                            </div></div></div></div>
                           
                            <div class="owl-dots disabled"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @if(isset($blogs) && $blogs->count() > 0)
    <section class="blog-style1">
        <div class="container">
            <div class="sec-title withtext text-center">
                <div class="sub-title"><h4>News & Updates</h4></div>
                <h2>Latest Insights and Updates</h2>
            </div>

            <div class="blog-style1__inner">
                <div class="blog-style1__tab">
                    
                    <div class="blog-style1__tab-btn">
                        <ul class="tabs-button-box clearfix">
                            {{-- Şimdilik sadece bir ana tab kullanıyoruz --}}
                            <li data-tab="#global-analysis" class="tab-btn-item active-btn-item"><h4>Latest News</h4></li>
                        </ul>
                    </div>

                    <div class="tabs-content-box">
                        <div class="tab-content-box-item tab-content-box-item-active" id="global-analysis">
                            <div class="blog-style1-tab-content-box-item">
                                <div class="row">
                                    <div class="col-xl-8">
                                        {{-- Ana Blog (Slider) - Sadece ilk blogu alır --}}
                                        @php $firstBlog = $blogs->first(); @endphp
                                        @if($firstBlog)
                                        <div class="blog-style1-carousel">
                                            <div class="single-item">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6">
                                                        <div class="single-blog-style1">
                                                            <div class="img-box">
                                                                {{-- DÜZELTME: 'storage/' kaldırıldı --}}
                                                                <img src="{{ $firstBlog->image_url ? asset('storage/blog-images/365x182/' . $firstBlog->image_url) : asset('frontend/assets/images/blog/blog-v1-1.jpg') }}" alt="{{ $firstBlog->title }}">
                                                            </div>
                                                            <div class="content-box">
                                                                <div class="top-box">
                                                                    <div class="category">
                                                                        <div class="icon"><i class="icon-hashtag"></i></div>
                                                                        {{-- GÜNCELLEME: 'Kategori' -> 'Category' --}}
                                                                        <h6>{{ $firstBlog->category->name ?? 'Category' }}</h6>
                                                                    </div>
                                                                    <div class="date">
                                                                        <div class="icon"><i class="fa fa fa-calendar"></i></div>
                                                                        <h6>{{ $firstBlog->created_at->format('d.m.Y') }}</h6>
                                                                    </div>
                                                                </div>
                                                                <div class="title-box">
                                                                    <h3><a href="{{ route('frontend.blog.detail', $firstBlog->slug) }}">{{ $firstBlog->title }}</a></h3>
                                                                </div>
                                                                <div class="text-box">
                                                                    <p>{{ $firstBlog->short_description ?? Str::limit(strip_tags($firstBlog->content), 100) }}</p>
                                                                </div>
                                                                <div class="btn-box">
                                                                    <a class="overlay-btn" href="{{ route('frontend.blog.detail', $firstBlog->slug) }}">
                                                                        Read More <i class="icon-right-arrow"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- Yanındaki diğer 2 blog (ilk 3 blogdan 2. ve 3. olanlar) --}}
                                                    <div class="col-xl-6 col-lg-6">
                                                        @if(isset($blogs[1]))
                                                        @php $sideBlog1 = $blogs[1]; @endphp
                                                        <div class="single-blog-style2">
                                                            <div class="top-box">
                                                                <div class="category"><div class="icon"><i class="icon-hashtag"></i></div><h6>{{ $sideBlog1->category->name ?? '' }}</h6></div>
                                                                <div class="date"><div class="icon"><i class="fa fa fa-calendar"></i></div><h6>{{ $sideBlog1->created_at->format('d.m.Y') }}</h6></div>
                                                            </div>
                                                            <div class="title-box"><h3><a href="{{ route('frontend.blog.detail', $sideBlog1->slug) }}">{{ $sideBlog1->title }}</a></h3></div>
                                                            <div class="text-box"><p>{{ $sideBlog1->short_description ?? Str::limit(strip_tags($sideBlog1->content), 70) }}</p></div>
                                                            <div class="btn-box"><a class="overlay-btn" href="{{ route('frontend.blog.detail', $sideBlog1->slug) }}">Read More <i class="icon-right-arrow"></i></a></div>
                                                            <div class="border-line"></div>
                                                        </div>
                                                        @endif
                                                        @if(isset($blogs[2]))
                                                        @php $sideBlog2 = $blogs[2]; @endphp
                                                        <div class="single-blog-style2">
                                                            <div class="top-box">
                                                                <div class="category"><div class="icon"><i class="icon-hashtag"></i></div><h6>{{ $sideBlog2->category->name ?? '' }}</h6></div>
                                                                <div class="date"><div class="icon"><i class="fa fa fa-calendar"></i></div><h6>{{ $sideBlog2->created_at->format('d.m.Y') }}</h6></div>
                                                            </div>
                                                            <div class="title-box"><h3><a href="{{ route('frontend.blog.detail', $sideBlog2->slug) }}">{{ $sideBlog2->title }}</a></h3></div>
                                                            <div class="text-box"><p>{{ $sideBlog2->short_description ?? Str::limit(strip_tags($sideBlog2->content), 70) }}</p></div>
                                                            <div class="btn-box"><a class="overlay-btn" href="{{ route('frontend.blog.detail', $sideBlog2->slug) }}">Read More <i class="icon-right-arrow"></i></a></div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    <div class="col-xl-4 col-lg-6">
                                            <div class="blog-style1-subscribe">
                                                <div class="shape1">
                                                    <img class="float-bob-x" src="{{ asset('frontend/assets/images/shapes/blog-v1-shape1.png') }}" alt="Shape">
                                                </div>
                                                <div class="shape2">
                                                    <img class="zoominout" src="{{ asset('frontend/assets/images/shapes/blog-v1-shape2.png') }}" alt="Shape">
                                                </div>
                                                <div class="shape3">
                                                    <img class="zoominout" src="{{ asset('frontend/assets/images/shapes/blog-v1-shape3.png') }}" alt="Shape">
                                                </div>
                                                <div class="top-box">
                                                    <h3>Subscribe Us</h3>
                                                    <p>Get updates in your inbox diectly.</p>
                                                </div>
                                                <div class="blog-style1-subscribe__inner">
                                                    <ul class="clearfix">
                                                        <li>
                                                            <div class="icon">
                                                                <i class="icon-check"></i>
                                                            </div>
                                                            <p>Special Promotions</p>
                                                        </li>
                                                        <li>
                                                            <div class="icon">
                                                                <i class="icon-check"></i>
                                                            </div>
                                                            <p>Exclusive Market Insights</p>
                                                        </li>
                                                        <li>
                                                            <div class="icon">
                                                                <i class="icon-check"></i>
                                                            </div>
                                                            <p>Expert Trading Tips</p>
                                                        </li>
                                                    </ul>
                                                    <div class="blog-style1-subscribe-form">
                                                        <form action="#" method="POST">
                                                            <div class="form-group">
                                                                <input type="email" name="email" placeholder="Email address..." required="">
                                                            </div>
                                                            <div class="checked-box1">
                                                                <input type="checkbox" name="agree" id="termsconditions2" checked="">
                                                                <label for="termsconditions1">
                                                                    <span></span>I agree terms &amp; conditions.
                                                                </label>
                                                            </div>
                                                            <div class="btn-box">
                                                                <button class="submit btn-one">
                                                                    <span class="txt">
                                                                        Subscribe
                                                                        <i class="icon-right-arrow"></i>
                                                                    </span>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

{{-- YENİ HABERLER BÖLÜMÜ (DOĞRU SCRIPT İLE) --}}
<section class="news-style1 pdtop pdbottom">
    <div class="container">
        <div class="sec-title withtext text-center">
            <div class="sub-title"><h4>Market News</h4></div>
            <h2>Latest Crypto Updates</h2>
        </div>
        
        <!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container">
  <div class="tradingview-widget-container__widget"></div>
  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-timeline.js" async>
  {
  "displayMode": "regular",
  "feedMode": "all_symbols",
  "colorTheme": "light",
  "isTransparent": false,
  "locale": "en",
  "width": 1200,
  "height": 550
}
  </script>
</div>
<!-- TradingView Widget END -->
        </div>
</section>
{{-- YENİ HABERLER BÖLÜMÜ SONU --}}

    @if(isset($references) && $references->count() > 0)
    <section class="testimonial-style1">
        <div class="container">
            <div class="sec-title white">
                <div class="sub-title"><h4>Testimonials</h4></div>
                <h2>Real Experiences, Real Results</h2>
            </div>
        </div>
        <div class="testimonial-style1__inner">

            <ul class="marquee_mode-rightToLeft">
                @foreach ($references as $reference)
                <li class="single-testimonial-style1">
                    <div class="top-box">
                        <div class="left"><div class="percent"><p>5.0</p></div><div class="text"><p>Client <br>Review</p></div></div>
                        <div class="right"><div class="point"><p>5.0</p></div><ul class="rating"><li><i class="icon-star"></i></li><li><i class="icon-star"></i></li><li><i class="icon-star"></i></li><li><i class="icon-star"></i></li><li><i class="icon-star"></i></li></ul></div>
                    </div>
                    <div class="text-box">
                        <p>{{ $reference->comment }}</p>
                    </div>
                    <div class="bottom-box">
                        <div class="icon">
                            <img src="{{ $reference->image ? asset($reference->image) : asset('frontend/assets/images/resources/flag1.png') }}" alt="Flag">
                        </div>
                        <h3>{{ $reference->name }}, <span>{{ $reference->title }}</span></h3>
                    </div>
                    <div class="quote-icon">
                        <img src="{{ asset('frontend/assets/images/icon/icon-quote.png') }}" alt="">
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </section>
    @endif
    {{-- Bu bölüm STATİK --}}
    <section class="global-reach-style1">
        <div class="global-reach-style1__bg" style="background-image: url({{ asset('frontend/assets/images/shapes/global-reach-style1__shape-bg.jpg') }});"></div>
         <div class="container">
             <div class="sec-title withtext text-center">
                <div class="sub-title"><h4>Global Reach</h4></div>
                <h2>Traders Across the Globe</h2>
            </div>
             <div class="global-reach-style1__map wow fadeInUp animated" data-wow-delay="00ms" data-wow-duration="1700ms">
                <img src="{{ asset('frontend/assets/images/resources/global-reach-v1-map.png') }}" alt="Map">
                 {{-- ... (index.html'den statik harita pinleri) ... --}}
            </div>
         </div>
    </section>
@endsection

@push('scripts')
    {{-- Anasayfaya özel dashboard/slider script'i --}}
    {{-- NOT: Bu dosya index.html'de yüklendiği için ekliyoruz --}}
@endpush