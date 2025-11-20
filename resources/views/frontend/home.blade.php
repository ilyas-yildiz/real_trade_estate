@extends('frontend.layouts.app')

{{-- SEO Başlığı ve Açıklaması --}}
@section('title', $settings['seo_title'] ?? __('messages.site_title'))
@section('description', $settings['seo_description'] ?? __('messages.meta_description_default'))

@section('content')

    <section class="main-slider-style1">
        <div class="main-slider-style1__inner">
            
            {{-- Statik Demo Mockup Alanı --}}
            <div class="top-box text-center">
                <div class="top-box__pattern"
                    style="background-image: url({{ asset('frontend/assets/images/pattern/slider-v1-pattern.png') }});">
                </div>
                <div class="title-box">
                    {{-- GÜNCELLEME: Çeviri --}}
                    <h3>{{ __('messages.free_demo') }}</h3>
                    <p>{{ __('messages.practice_trading') }}</p>
                </div>
                <div class="img-box">
                    <img src="{{ asset('frontend/assets/images/slides/slider-v1-mockup.png') }}" alt="Img">
                </div>
                <div class="btn-box">
                    <a class="btn-one" href="{{ route('register') }}">
                        <span class="txt">{{ __('messages.start_demo') }}</span>
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
                                <li><i class="icon-star"></i></li>
                                <li><i class="icon-star"></i></li>
                                <li><i class="icon-star"></i></li>
                                <li><i class="icon-star"></i></li>
                                <li><i class="icon-star"></i></li>
                            </ul>
                            <p>2.8k {{ __('messages.verified_reviews') }}</p>
                        </div>
                    </div>
                    <div class="btn-box">
                        <a href="#">
                            {{ __('messages.read_reviews') }}
                            <i class="icon-right-arrow"></i>
                        </a>
                    </div>
                </div>
                </div>
            {{-- Statik Highlights Alanı --}}
            <ul class="main-slider-style1__highlights clearfix">
                <li>
                    <div class="icon"><span class="icon-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span></div>
                    <p>{!! __('messages.bonus_offer') !!}</p>
                </li>
                <li>
                    <div class="icon"><span class="icon-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span></div>
                    <p>{!! __('messages.demo_account_offer') !!}</p>
                </li>
                 <li>
                    <div class="icon"><span class="icon-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span></div>
                    <p>{!! __('messages.subscribe_offer') !!}</p>
                </li>
                <li>
                    <div class="icon"><span class="icon-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span></div>
                    <p>{!! __('messages.download_ebooks') !!}</p>
                </li>
            </ul>

            {{-- TRADINGVIEW 1: KAYAN FİYAT BANDI --}}
            <div class="tradingview-widget-container" id="tv-ticker-tape-container" style="width: 100%; height: 95px; background-color: transparent;">
                <div class="tradingview-widget-container__widget"></div>
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
                {
                  "symbols": [
                    { "proName": "FOREXCOM:SPXUSD", "title": "S&P 500" },
                    { "proName": "FOREXCOM:NSXUSD", "title": "US 100 (Nasdaq)" },
                    { "proName": "FX_IDC:EURUSD", "title": "EUR/USD" },
                    { "description": "Gold (Ons)", "proName": "OANDA:XAUUSD" },
                    { "description": "Silver", "proName": "OANDA:XAGUSD" },
                    { "description": "Brent Oil", "proName": "TVC:UKOIL" },
                    { "description": "Crude Oil", "proName": "TVC:USOIL" },
                    { "description": "Natural Gas", "proName": "TVC:NG1!" }
                  ],
                  "showSymbolLogo": true,
                  "colorTheme": "light",
                  "isTransparent": true,
                  "displayMode": "adaptive",
                  // GÜNCELLEME: Widget Dili Dinamik Yapıldı
                  "locale": "{{ App::getLocale() }}"
                }
                </script>
            </div>
            <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                function forceTickerHeight() {
                    try {
                        var container = document.getElementById('tv-ticker-tape-container');
                        var iframe = container.querySelector('iframe[id^="tradingview_widget"]');
                        if (iframe) {
                            iframe.style.height = '95px';
                        } else {
                            setTimeout(forceTickerHeight, 100);
                        }
                    } catch (e) {
                        console.error("TradingView Ticker hatası:", e);
                    }
                }
                forceTickerHeight();
            });
            </script>
            {{-- DİNAMİK SLIDER --}}
            <div class="swiper-container banner-slider-two">
                <div class="swiper-wrapper">

                    @forelse ($slides as $slide)
                    <div class="swiper-slide">
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
                                            <span class="txt">{{ $slide->button_text ?? __('messages.details') }}</span>
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
                                    <h2>{!! __('messages.slider_default_title') !!}</h2>
                                </div>
                                <div class="text">
                                    <p>{{ __('messages.slider_default_text') }}</p>
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
                            {{-- Resim --}}
                            <img src="{{ $about->image_url ? asset('storage/about-images/800x600/' . $about->image_url) : asset('frontend/assets/images/about/about-v1-1.jpg') }}" alt="About Image">
                        </div>
                        <div class="about-style1__img-award text-center wow fadeInUp animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                            <div class="about-style1__img-award-top">
                                <div class="top">
                                    <div class="shape1"><img src="{{ asset('frontend/assets/images/about/logo-5.png') }}" alt="Real Trade Estate"></div>
                                </div>
                            </div>
                        </div>
                        <div class="about-style1-round-text wow fadeInRight animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                            <div class="overlay-text"><div class="inner">24</div></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6">
                    <div class="about-style1__content wow fadeInRight animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                        <div class="sec-title">
                            <div class="sub-title"><h4>{{ __('messages.about_title_prefix') }} Real Trade Estate</h4></div>
                            
                            {{-- DÜZELTME BURADA: $about->title -> getTranslation('title') --}}
                            <h2>{!! $about->getTranslation('title') !!}</h2>
                        </div>
                        <div class="text">
                            {{-- DÜZELTME BURADA: $about->short_content -> getTranslation('short_content') --}}
                            <p>{{ $about->getTranslation('short_content') }}</p>
                        </div>
                        
                        <div class="text-box">
                            <div class="icon"><div class="inner"><span class="icon-target"><span class="path1"></span></span></div></div>
                            <div class="text1">
                                {{-- DÜZELTME BURADA: $about->content -> getTranslation('content') --}}
                                <p>{{ Str::limit(strip_tags($about->getTranslation('content')), 100) }}</p>
                            </div>
                        </div>
                        <div class="btn-box">
                            <a href="{{ route('frontend.about') }}">
                                {{ __('messages.read_more') }}
                                <i class="icon-right-arrow"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    
    {{-- İstatistik Sayacı --}}
    <section class="fact-counter-style1">
         <div class="fact-counter-style1__shape1">
            <img src="{{ asset('frontend/assets/images/shapes/fact-counter-v1-shape1.png') }}" alt="Shape">
        </div>
        {{-- ... (Burayı önceki adımlarda settings'den dinamik yapmıştık, aynı kalsın) ... --}}
    </section>
  
    {{-- Platformlar Bölümü --}}
    <section class="platforms-style1">
            <div class="container">
                <div class="sec-title white">
                    <div class="sub-title">
                        <h4>{{ __('messages.platforms') }}</h4>
                    </div>
                    <h2>{{ __('messages.platforms_title') }}</h2>
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
                                        <div class="icon"><i class="icon-check"></i></div>
                                        <h4>Meta <br>Trader 4</h4>
                                    </li>
                                    <li data-tab="#trader-5" class="tab-btn-item">
                                        <div class="icon"><i class="icon-check"></i></div>
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

   @if(isset($blogs) && $blogs->count() > 0)
    <section class="blog-style1">
        <div class="container">
            <div class="sec-title withtext text-center">
                <div class="sub-title"><h4>{{ __('messages.news_updates') }}</h4></div>
                <h2>{{ __('messages.latest_insights') }}</h2>
            </div>

            <div class="blog-style1__inner">
                <div class="blog-style1__tab">
                    <div class="blog-style1__tab-btn">
                        <ul class="tabs-button-box clearfix">
                            <li data-tab="#global-analysis" class="tab-btn-item active-btn-item"><h4>Latest News</h4></li>
                        </ul>
                    </div>

                    <div class="tabs-content-box">
                        <div class="tab-content-box-item tab-content-box-item-active" id="global-analysis">
                            <div class="blog-style1-tab-content-box-item">
                                <div class="row">
                                    <div class="col-xl-8">
                                        @php $firstBlog = $blogs->first(); @endphp
                                        @if($firstBlog)
                                        <div class="blog-style1-carousel">
                                            <div class="single-item">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6">
                                                        <div class="single-blog-style1">
                                                            <div class="img-box">
                                                                <img src="{{ $firstBlog->image_url ? asset('storage/blog-images/365x182/' . $firstBlog->image_url) : asset('frontend/assets/images/blog/blog-v1-1.jpg') }}" alt="{{ $firstBlog->getTranslation('title') }}">
                                                            </div>
                                                            <div class="content-box">
                                                                <div class="top-box">
                                                                    <div class="category"><div class="icon"><i class="icon-hashtag"></i></div><h6>{{ $firstBlog->category->name ?? 'Category' }}</h6></div>
                                                                    <div class="date"><div class="icon"><i class="fa fa fa-calendar"></i></div><h6>{{ $firstBlog->created_at->format('d.m.Y') }}</h6></div>
                                                                </div>
                                                                <div class="title-box">
                                                                    <h3><a href="{{ route('frontend.blog.detail', $firstBlog->slug) }}">{{ $firstBlog->getTranslation('title') }}</a></h3>
                                                                </div>
                                                                <div class="text-box">
                                                                    <p>{{ $firstBlog->getTranslation('short_description') ?? Str::limit(strip_tags($firstBlog->getTranslation('content')), 100) }}</p>
                                                                </div>
                                                                <div class="btn-box">
                                                                    <a class="overlay-btn" href="{{ route('frontend.blog.detail', $firstBlog->slug) }}">
                                                                        {{ __('messages.read_more') }} <i class="icon-right-arrow"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6">
                                                        @if(isset($blogs[1]))
                                                        @php $sideBlog1 = $blogs[1]; @endphp
                                                        <div class="single-blog-style2">
                                                            <div class="top-box">
                                                                <div class="category"><div class="icon"><i class="icon-hashtag"></i></div><h6>{{ $sideBlog1->category->name ?? '' }}</h6></div>
                                                                <div class="date"><div class="icon"><i class="fa fa fa-calendar"></i></div><h6>{{ $sideBlog1->created_at->format('d.m.Y') }}</h6></div>
                                                            </div>
                                                            <div class="title-box"><h3><a href="{{ route('frontend.blog.detail', $sideBlog1->slug) }}">{{ $sideBlog1->getTranslation('title') }}</a></h3></div>
                                                            <div class="text-box"><p>{{ $sideBlog1->getTranslation('short_description') ?? Str::limit(strip_tags($sideBlog1->getTranslation('content')), 70) }}</p></div>
                                                            <div class="btn-box"><a class="overlay-btn" href="{{ route('frontend.blog.detail', $sideBlog1->slug) }}">{{ __('messages.read_more') }} <i class="icon-right-arrow"></i></a></div>
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
                                                            <div class="title-box"><h3><a href="{{ route('frontend.blog.detail', $sideBlog2->slug) }}">{{ $sideBlog2->getTranslation('title') }}</a></h3></div>
                                                            <div class="text-box"><p>{{ $sideBlog2->getTranslation('short_description') ?? Str::limit(strip_tags($sideBlog2->getTranslation('content')), 70) }}</p></div>
                                                            <div class="btn-box"><a class="overlay-btn" href="{{ route('frontend.blog.detail', $sideBlog2->slug) }}">{{ __('messages.read_more') }} <i class="icon-right-arrow"></i></a></div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        {{-- Subscribe Kutusu (Burada değişiklik yok) --}}
                                        <div class="blog-style1-subscribe">
                                            {{-- ... (Subscribe HTML içeriği) ... --}}
                                             <div class="shape1"><img src="{{ asset('frontend/assets/images/shapes/blog-v1-shape1.png') }}" alt="Shape"></div>
                                            <div class="shape2"><img src="{{ asset('frontend/assets/images/shapes/blog-v1-shape2.png') }}" alt="Shape"></div>
                                            <div class="shape3"><img src="{{ asset('frontend/assets/images/shapes/blog-v1-shape3.png') }}" alt="Shape"></div>
                                            <div class="top-box"><h3>{{ __('messages.subscribe_us') }}</h3><p>{{ __('messages.subscribe_desc') }}</p></div>
                                            <div class="blog-style1-subscribe__inner">
                                                <ul class="clearfix">
                                                    <li><div class="icon"><i class="icon-check"></i></div><p>Special Promotions</p></li>
                                                    <li><div class="icon"><i class="icon-check"></i></div><p>Exclusive Market Insights</p></li>
                                                    <li><div class="icon"><i class="icon-check"></i></div><p>Expert Trading Tips</p></li>
                                                </ul>
                                                <div class="blog-style1-subscribe-form">
                                                    <form action="#" method="POST">
                                                        <div class="form-group"><input type="email" name="email" placeholder="{{ __('messages.email_placeholder') }}" required=""></div>
                                                        <div class="checked-box1"><input type="checkbox" name="agree" id="termsconditions2" checked=""><label for="termsconditions1"><span></span>{{ __('messages.agree_terms') }}</label></div>
                                                        <div class="btn-box"><button class="submit btn-one"><span class="txt">{{ __('messages.subscribe') }}<i class="icon-right-arrow"></i></span></button></div>
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

{{-- HABERLER BÖLÜMÜ (TRADINGVIEW TIMELINE) --}}
<section class="news-style1 pdtop pdbottom">
    <div class="container">
        <div class="sec-title withtext text-center">
            <div class="sub-title"><h4>{{ __('messages.market_news') }}</h4></div>
            <h2>{{ App::getLocale() == 'tr' ? 'Son Piyasa Gelişmeleri' : 'Latest Market Updates' }}</h2>
        </div>
        
        {{-- 
            GÜNCELLEME: 
            1. ID eklendi: 'tv-timeline-container'
            2. style'a '!important' eklendi (CSS önlemi)
        --}}
        <div class="tradingview-widget-container" id="tv-timeline-container" style="width: 800px !important; max-width: 100%; height: 800px !important; margin: 0 auto; display: block;">
          <div class="tradingview-widget-container__widget"></div>
          <div class="tradingview-widget-copyright">
            <a href="https://tr.tradingview.com/" rel="noopener nofollow" target="_blank">
                <span class="blue-text">Piyasa haberleri</span>
            </a> TradingView tarafından
          </div>
          <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-timeline.js" async>
          {
          "feedMode": "all_symbols",
          "isTransparent": false,
          "displayMode": "regular",
          // GÜNCELLEME: JSON ayarında da 800 diyoruz
          "width": "800", 
          "height": "800",
          "colorTheme": "light",
          "locale": "{{ App::getLocale() }}" 
        }
          </script>
        </div>
        
        {{-- YENİ: Widget Boyutunu Zorlayan Script --}}
        <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            function forceTimelineSize() {
                var container = document.getElementById('tv-timeline-container');
                
                if (container) {
                    // Konteyneri zorla 800px yap
                    container.style.setProperty('width', '1200px', 'important');
                    container.style.setProperty('height', '800px', 'important');
                    
                    // İçindeki iframe'i bul ve onu da zorla
                    var iframe = container.querySelector('iframe');
                    if (iframe) {
                        iframe.style.setProperty('width', '100%', 'important');
                        iframe.style.setProperty('height', '100%', 'important');
                    }
                }
                
                // Scriptin yüklenmesi zaman alabileceği için işlemi tekrarla
                // (TradingView bazen sonradan render eder)
                setTimeout(forceTimelineSize, 500); 
                setTimeout(forceTimelineSize, 2000); // 2 saniye sonra son kontrol
            }
            
            // İlk tetikleme
            forceTimelineSize();
        });
        </script>
        </div>
</section>
{{-- HABERLER BÖLÜMÜ SONU --}}

    @if(isset($references) && $references->count() > 0)
    <section class="testimonial-style1">
        <div class="container">
            <div class="sec-title white">
                <div class="sub-title"><h4>{{ __('messages.testimonials') }}</h4></div>
                <h2>{{ __('messages.real_experiences') }}</h2>
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

    {{-- Global Reach Bölümü --}}
    <section class="global-reach-style1">
        <div class="global-reach-style1__bg" style="background-image: url({{ asset('frontend/assets/images/shapes/global-reach-style1__shape-bg.jpg') }});"></div>
         <div class="container">
             <div class="sec-title withtext text-center">
                <div class="sub-title"><h4>{{ __('messages.global_reach') }}</h4></div>
                <h2>{{ __('messages.traders_across_globe') }}</h2>
            </div>
             <div class="global-reach-style1__map wow fadeInUp animated" data-wow-delay="00ms" data-wow-duration="1700ms">
                <img src="{{ asset('frontend/assets/images/resources/global-reach-v1-map.png') }}" alt="Map">
            </div>
         </div>
    </section>
@endsection

@push('scripts')
    {{-- Anasayfaya özel dashboard/slider script'i --}}
    {{-- NOT: Bu dosya index.html'de yüklendiği için ekliyoruz --}}
@endpush