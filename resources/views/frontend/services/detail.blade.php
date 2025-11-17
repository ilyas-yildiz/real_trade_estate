@extends('frontend.layouts.app')

{{-- Sayfa başlığını hizmet başlığı ile ayarlıyoruz --}}
@section('title', $service->title . ' - ' . __('messages.invest')) 

{{-- Meta açıklamasını hizmet içeriğinden alalım --}}
@section('description', Str::limit(strip_tags($service->content), 160)) 

@section('content')

    {{-- Banner Alanı --}}
    <section class="breadcrumb-style1">
        <div class="breadcrumb-style1__inner">
            <div class="breadcrumb-style1-bg"
                 style="background-image: url({{ asset('frontend/assets/images/breadcrumb/breadcrumb-1.jpg') }});">
            </div>
            <div class="container">
                <div class="inner-content">
                    <div class="title">
                        {{-- Hizmet başlığı --}}
                        <h2>{{ $service->title }}</h2>
                    </div>
                    <div class="breadcrumb-menu">
                        <ul class="clearfix">
                            {{-- GÜNCELLEME: Çeviri --}}
                            <li><a href="{{ route('frontend.home') }}">{{ __('messages.home') }}</a></li>
                            <li><span class="icon-right-arrow"></span></li>
                            <li><a href="{{ route('frontend.services') }}">{{ __('messages.invest') }}</a></li>
                            <li><span class="icon-right-arrow"></span></li>
                            {{-- Aktif sayfa adı (Uzunsa kısaltılabilir) --}}
                            <li class="active">{{ Str::limit($service->title, 30) }}</li> 
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- İçerik Alanı --}}
    <section class="blog-details pdtop pdbottom"> {{-- Stil sınıfını blog detay ile aynı yaptım, tutarlılık için --}}
        <div class="container">
            <div class="row justify-content-center"> {{-- Ortalamak için --}}
                <div class="col-xl-10 col-lg-12"> {{-- Genişlik ayarı --}}
                    <div class="blog-details__content">
                        
                        {{-- Ana Görsel --}}
                        <div class="blog-details-top">
                            <div class="img-box">
                                @if($service->image_url)
                                    {{-- GÜNCELLEME: Dinamik resim yolu --}}
                                    <img src="{{ asset('storage/service-images/' . $service->image_url) }}" alt="{{ $service->title }}">
                                @else
                                    {{-- Varsayılan görsel --}}
                                    <img src="{{ asset('frontend/assets/images/resources/market-v1-1.jpg') }}" alt="{{ $service->title }}">
                                @endif
                            </div>
                        </div>

                        {{-- Hizmet İçeriği (HTML) --}}
                        <div class="blog-details-text1 mt-4">
                            {!! $service->content !!}
                        </div>

                        {{-- Geri Dön Butonu --}}
                        <div class="back-to-blog-post-btn mt-5">
                            <a href="{{ route('frontend.services') }}">
                                <img src="{{ asset('frontend/assets/images/icon/menu-1.png') }}" alt="Icon">
                                {{ __('messages.back_to_services') }}
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection