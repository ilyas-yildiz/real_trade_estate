@extends('frontend.layouts.app')

{{-- SEO Başlığı --}}
@section('title', isset($about) ? $about->title : ($settings['seo_title'] ?? __('messages.about_us') . ' - ' . __('messages.site_title')))
{{-- SEO Açıklaması --}}
@section('description', isset($about) ? Str::limit(strip_tags($about->short_content ?? $about->content), 160) : ($settings['seo_description'] ?? __('messages.meta_description_default')))

@section('content')

    <section class="breadcrumb-style1">
        <div class="breadcrumb-style1__inner">
            <div class="breadcrumb-style1-bg"
                 style="background-image: url({{ asset('frontend/assets/images/breadcrumb/breadcrumb-1.jpg') }});">
            </div>
            <div class="container">
                <div class="inner-content">
                    <div class="title">
                        {{-- GÜNCELLEME: Çeviri --}}
                        <h2>{{ __('messages.about_us') }}</h2>
                    </div>
                    <div class="breadcrumb-menu">
                        <ul class="clearfix">
                            <li><a href="{{ route('frontend.home') }}">{{ __('messages.home') }}</a></li>
                            <li><span class="icon-right-arrow"></span></li>
                            <li class="active">{{ __('messages.about_us') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    {{-- Sadece $about verisi varsa bu bölümü göster --}}
    @if(isset($about))
        <section class="about-style2 pdtop">
            <div class="container">
                <div class="row">

                    <div class="col-xl-7 col-lg-6">
                        <div class="about-style2__left about-style2__left-style3">
                            {{-- Statik dönen şekil --}}
                            <div class="shape1">
                                <img class="rotate-me" src="{{ asset('frontend/assets/images/shapes/about-v2-shape22.png') }}" alt="Shape">
                            </div>
                            {{-- Ana Resim (Dinamik) --}}
                            <div class="img-box1">
                                <img src="{{ $about->image_url ? asset('storage/about-images/800x600/' . $about->image_url) : asset('frontend/assets/images/about/about-v2-11.jpg') }}" alt="{{ $about->title }}">
                            </div>
                            {{-- Küçük resim --}}
                            <div class="img-box2">
                                <img src="{{ asset('frontend/assets/images/about/about-v2-2.jpg') }}" alt="Details">
                            </div>
                            {{-- Yıl kutusu --}}
                            <div class="experience-box">
                                <div class="experience-box__bg"
                                     style="background-image: url({{ asset('frontend/assets/images/shapes/about-v2-shape11.png') }});">
                                </div>
                                <div class="icon">
                                    <span class="icon-bull"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span><span class="path4"></span>
                                    </span>
                                </div>
                                <div class="title">
                                    {{-- GÜNCELLEME: Çeviri --}}
                                    <h2>24+ <span>{{ __('messages.years') }}</span></h2>
                                </div>
                                <div class="text">
                                    {{-- GÜNCELLEME: Çeviri --}}
                                    <h3>{{ __('messages.market_experience') }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-5 col-lg-6">
                        <div class="about-style2__right">
                            <div class="sec-title withtext">
                                <div class="sub-title">
                                    {{-- GÜNCELLEME: 'About Real Trade Estate' --}}
                                    <h4>{{ __('messages.about_title_prefix') }} Real Trade Estate</h4>
                                </div>
                                {{-- Ana Başlık (Dinamik - Modelden JSON çevrili gelir) --}}
                                <h2>{{ $about->title }}</h2>
                                {{-- Ana İçerik (Dinamik - HTML destekli) --}}
                                <div class="text">
                                    {!! $about->content !!}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    @else
        {{-- Eğer veritabanında hakkımızda içeriği yoksa --}}
        <section class="pdtop pdbottom">
            <div class="container">
                <p class="text-center">{{ __('messages.content_not_available') }}</p>
            </div>
        </section>
    @endif

@endsection

{{-- Sayfaya özel script gerekmiyorsa bu bölüm boş kalabilir veya silinebilir --}}
@push('scripts')
@endpush