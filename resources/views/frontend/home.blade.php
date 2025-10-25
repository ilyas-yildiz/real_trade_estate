@extends('frontend.layouts.app')

{{-- SEO Başlığı ve Açıklaması (Ayarlardan veya varsayılan) --}}
@section('title', $settings['seo_title'] ?? 'Tradebro - Anasayfa')
@section('description', $settings['seo_description'] ?? 'Güvenli ve hızlı trading platformu.')

@section('content')

    <section class="main-slider-style1">
        <div class="main-slider-style1__inner">
            
            {{-- Statik Demo Mockup Alanı --}}
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
            <ul class="main-slider-style1__highlights clearfix">
                <li>
                    <div class="icon"><span class="icon-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span></div>
                    <p>Up to <span>$500 Bonus</span> on First Deposit!</p>
                </li>
                <li>
                    <div class="icon"><span class="icon-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span></div>
                    <p>Trading with a <a href="{{ route('register') }}">Free Demo</a> Account!</p>
                </li>
                 <li>
                    <div class="icon"><span class="icon-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span></div>
                    <p>Stay Informed, <a href="#">Subscribe</a> Now!</p>
                </li>
                <li>
                    <div class="icon"><span class="icon-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span></div>
                    <p>Download our Free <a href="#">eBooks</a></p>
                </li>
            </ul>

            {{-- DİNAMİK SLIDER --}}
            <div class="swiper-container banner-slider-two">
                <div class="swiper-wrapper">

                    @forelse ($slides as $slide)
                    <div class="swiper-slide">
                        {{-- DÜZELTME: 'storage/' kaldırıldı (Paylaşımlı sunucu uyumlu) --}}
                        <div class="image-layer" style="background-image: url({{ $slide->image_path ? asset($slide->image_path) : asset('frontend/assets/images/slides/slide-v1-1.jpg') }});">
                        </div>
                        <div class="container">
                            <div class="content-box">
                                <div class="big-title">
                                    <h2>{!! $slide->title !!}</h2> 
                                </div>
                                <div class="text">
                                    <p>{{ $slide->description }}</p>
                                </div>
                                <div class="bottom-box">
                                    <div class="btn-box">
                                        <a class="btn-one" href="{{ $slide->button_url ?? '#' }}">
                                            <span class="txt">{{ $slide->button_text ?? 'Explore Markets' }}</span>
                                            <i class="icon-right-arrow"></i>
                                        </a>
                                    </div>
                                    {{-- Video linki statik --}}
                                    <div class="text-box">
                                        <h4>Master Trading <br>in Minutes...</h4>
                                        <a class="video-popup" title="Video Gallery" href="https://www.youtube.com/watch?v=bZ3pffta3-A">
                                            <span class="icon-play"></span>
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
    {{-- Not: Bu bölüm canlı API gerektirir. Şimdilik STATİK bırakıyoruz. --}}
    <section class="instruments-style1">
        <div class="instruments-style1__shape1">
            <img src="{{ asset('frontend/assets/images/shapes/instruments--v1-shape1.png') }}" alt="Shape">
        </div>
        <div class="instruments-style1__shape2">
            <img src="{{ asset('frontend/assets/images/shapes/instruments--v1-shape2.png') }}" alt="Shape">
        </div>
        <div class="instruments-style1__tab">
            <div class="container">
                <div class="sec-title withtext white text-center">
                    <div class="sub-title"><h4>instruments</h4></div>
                    <h2>Leading Market Price List</h2>
                    <div class="text"><p>Discover the most competitive prices in the market, updated <br>regularly for your advantage.</p></div>
                </div>
                <div class="instruments-style1__inner">
                    <div class="instruments-style1__tab-btn">
                        <ul class="tabs-button-box clearfix">
                            <li data-tab="#forex" class="tab-btn-item active-btn-item"><h4>Forex</h4><div class="icon"><i class="icon-arrow-down"></i></div></li>
                            <li data-tab="#energies" class="tab-btn-item"><h4>Energies</h4><div class="icon"><i class="icon-arrow-down"></i></div></li>
                            <li data-tab="#shares" class="tab-btn-item"><h4>Shares</h4><div class="icon"><i class="icon-arrow-down"></i></div></li>
                            <li data-tab="#indices" class="tab-btn-item"><h4>Indices</h4><div class="icon"><i class="icon-arrow-down"></i></div></li>
                            <li data-tab="#metals" class="tab-btn-item"><h4>Metals</h4><div class="icon"><i class="icon-arrow-down"></i></div></li>
                        </ul>
                    </div>
                    <div class="tabs-content-box">
                        <div class="tab-content-box-item tab-content-box-item-active" id="forex">
                            {{-- Bu kısım (instruments-style1-tab-content-box-item) index.html'den statik olarak alınmalı --}}
                            <p class="text-white">Forex fiyat listesi alanı (Statik)</p>
                        </div>
                        <div class="tab-content-box-item" id="energies">
                             <p class="text-white">Energies fiyat listesi alanı (Statik)</p>
                        </div>
                        {{-- ... (Diğer tab içerikleri statik olarak burada kalabilir) ... --}}
                    </div>
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
                                    <div class="shape1"><img src="{{ asset('frontend/assets/images/about/about-v1-badge.png') }}" alt="Award"></div>
                                    <div class="text"><h5>Top <br>Trading <br>Broker</h5><h6>2023</h6></div>
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
                            <div class="sub-title"><h4>About Tradebro</h4></div>
                            <h2>{!! $about->title !!}</h2>
                        </div>
                        <div class="text">
                            <p>{{ $about->description }}</p>
                        </div>
                        {{-- 'The Goal' kısmı statik --}}
                        <div class="title-box">
                            <h3>The Goal</h3>
                            <h6>Purpose-Driven and Goal-Oriented</h6>
                        </div>
                        <div class="text-box">
                            <div class="icon"><div class="inner"><span class="icon-target"><span class="path1"></span></span></div></div>
                            <div class="text1"><p>Expound the actual teaching of the great of the master-builder human do not know how pursues business it will frequently.</p></div>
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
    @if(isset($services) && $services->count() > 0)
    <section class="account-style1">
        <div class="container">
            <div class="sec-title">
                <div class="sub-title"><h4>Account Types</h4></div>
                <h2>Explore Our Account Options</h2>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="owl-carousel owl-theme thm-owl__carousel account-style1-carousel owl-nav-style-one"
                        data-owl-options='{
                        "loop": true, "autoplay": true, "margin": 30, "nav": true, "dots": false, "smartSpeed": 500, "autoplayTimeout": 10000,
                        "navText": ["<span class=\"left icon-arrow-left\"></span>","<span class=\"icon-arrow-right\"></span>"],
                        "responsive": {"0": {"items": 1}, "768": {"items": 2}, "992": {"items": 2}, "1200": {"items": 3}}
                    }'>

                        @foreach ($services as $service)
                        <div class="single-account-style1">
                            <div class="content-box">
                                <h3><a href="{{ route('frontend.services.detail', $service->slug) }}">{{ $service->title }}</a></h3>
                                <p>{{ $service->short_description ?? Str::limit(strip_tags($service->description), 80) }}</p>
                            </div>
                            <div class="img-box">
                                <div class="inner">
                                    {{-- DÜZELTME: 'storage/' kaldırıldı --}}
                                    <img src="{{ $service->image ? asset($service->image) : asset('frontend/assets/images/resources/account-v1-1.jpg') }}" alt="{{ $service->title }}">
                                </div>
                                <div class="overlay-icon">
                                    <span class="icon-crown"><span class="path1"></span></span>
                                </div>
                            </div>
                            <div class="bottom-box">
                                <a href="{{ route('frontend.services.detail', $service->slug) }}">
                                    Read More
                                    <i class="icon-right-arrow"></i>
                                </a>
                                <p>#{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</p>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    {{-- Bu bölüm STATİK --}}
    <section class="platforms-style1">
         <div class="container">
            <div class="sec-title white">
                <div class="sub-title"><h4>Platforms</h4></div>
                <h2>Powerful Trading Platforms for Every Trader</h2>
            </div>
            {{-- ... (index.html'den statik platform içeriği) ... --}}
        </div>
    </section>
    {{-- Bu bölüm STATİK --}}
    <section class="choose-style1">
         <div class="container">
             <div class="sec-title withtext text-center">
                <div class="sub-title"><h4>Why Choose Us</h4></div>
                <h2>The Top Choice for Traders</h2>
            </div>
            {{-- ... (index.html'den statik "Neden Biz" içeriği) ... --}}
         </div>
    </section>
    {{-- Bu bölüm STATİK --}}
    <section class="how-it-work-style1">
        <div class="container">
            <div class="how-it-work-style1__top">
                <div class="sec-title white">
                    <div class="sub-title"><h4>How it’s Work</h4></div>
                    <h2>Step-by-Step Trading Guide</h2>
                </div>
            </div>
            {{-- ... (index.html'den statik "Nasıl Çalışır" içeriği) ... --}}
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
                                                                <img src="{{ $firstBlog->image ? asset($firstBlog->image) : asset('frontend/assets/images/blog/blog-v1-1.jpg') }}" alt="{{ $firstBlog->title }}">
                                                            </div>
                                                            <div class="content-box">
                                                                <div class="top-box">
                                                                    <div class="category">
                                                                        <div class="icon"><i class="icon-hashtag"></i></div>
                                                                        <h6>{{ $firstBlog->category->name ?? 'Kategori' }}</h6>
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
                                             <div class="shape1"><img class="float-bob-x" src="{{ asset('frontend/assets/images/shapes/blog-v1-shape1.png') }}" alt="Shape"></div>
                                            {{-- ... (Statik subscribe formu) ... --}}
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