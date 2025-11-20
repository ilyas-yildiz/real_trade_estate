@extends('frontend.layouts.app')

{{-- Sayfa başlığı: Çeviri metodu ile --}}
@section('title', $service->getTranslation('title') . ' - ' . __('messages.invest')) 

{{-- Meta açıklaması: Çeviri metodu ile --}}
@section('description', Str::limit(strip_tags($service->getTranslation('content')), 160)) 

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
                        {{-- Hizmet başlığı (Düzeltildi) --}}
                        <h2>{{ $service->getTranslation('title') }}</h2>
                    </div>
                    <div class="breadcrumb-menu">
                        <ul class="clearfix">
                            {{-- Çeviri --}}
                            <li><a href="{{ route('frontend.home') }}">{{ __('messages.home') }}</a></li>
                            <li><span class="icon-right-arrow"></span></li>
                            <li><a href="{{ route('frontend.services') }}">{{ __('messages.invest') }}</a></li>
                            <li><span class="icon-right-arrow"></span></li>
                            {{-- Aktif sayfa adı (Düzeltildi) --}}
                            <li class="active">{{ Str::limit($service->getTranslation('title'), 30) }}</li> 
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- İçerik Alanı --}}
    <section class="blog-details pdtop pdbottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-12">
                    <div class="blog-details__content">
                        
                        {{-- Ana Görsel --}}
                        <div class="blog-details-top">
                            <div class="img-box">
                                @if($service->image_url)
                                    {{-- GÜNCELLEME: Resim yolu '800x600' klasörüne göre ayarlandı --}}
                                    {{-- Alt etiketine çevrilmiş başlık eklendi --}}
                                    <img src="{{ asset('storage/service-images/800x600/' . $service->image_url) }}" alt="{{ $service->getTranslation('title') }}">
                                @else
                                    {{-- Varsayılan görsel --}}
                                    <img src="{{ asset('frontend/assets/images/resources/market-v1-1.jpg') }}" alt="{{ $service->getTranslation('title') }}">
                                @endif
                            </div>
                        </div>

                        {{-- Hizmet İçeriği (HTML) --}}
                        <div class="blog-details-text1 mt-4">
                            {{-- DÜZELTME: İçerik çevirisi --}}
                            {!! $service->getTranslation('content') !!}
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