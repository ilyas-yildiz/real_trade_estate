@extends('frontend.layouts.app')

{{-- SEO Başlığı (Dil dosyasından) --}}
@section('title', __('messages.invest') . ' - ' . __('messages.site_title'))

{{-- Meta Description (Dil dosyasından) --}}
@section('description', __('messages.meta_description_default'))

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
                        {{-- GÜNCELLEME: Çeviri --}}
                        <h2>{{ __('messages.invest') }}</h2>
                    </div>
                    <div class="breadcrumb-menu">
                        <ul class="clearfix">
                            <li><a href="{{ route('frontend.home') }}">{{ __('messages.home') }}</a></li>
                            <li><span class="icon-right-arrow"></span></li>
                            <li class="active">{{ __('messages.invest') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Hizmetler Listesi --}}
    <section class="market-style1 pdtop pdbottom">
        <div class="container">
            <div class="sec-title withtext text-center">
                <div class="sub-title">
                    {{-- GÜNCELLEME: Çeviri --}}
                    <h4>{{ __('messages.our_services') }}</h4>
                </div>
                {{-- GÜNCELLEME: Çeviri --}}
                <h2>{{ __('messages.explore_account_options') }}</h2>
                <div class="text">
                    {{-- GÜNCELLEME: Çeviri --}}
                    <p>{{ __('messages.services_desc') }}</p>
                </div>
            </div>
            <div class="row">

                @forelse($services as $service)
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="single-market-style1">
                            <div class="img-box img-box3">
                                {{-- GÜNCELLEME: Dinamik resim yolu (home.blade.php ile aynı mantık) --}}
                                <img src="{{ $service->image ? asset($service->image) : asset('frontend/assets/images/resources/market-v1-1.jpg') }}" alt="{{ $service->title }}">
                            </div>
                            <div class="content-box">
                                <div class="shape"
                                     style="background-image: url({{ asset('frontend/assets/images/shapes/market-v2-shape1.png') }});">
                                </div>
                                <div class="title">
                                    <h3>
                                        <a href="{{ route('frontend.services.detail', $service->slug) }}">{{ $service->title }}</a>
                                    </h3>
                                </div>
                                <div class="text">
                                    <div class="icon">
                                        {{-- İkon statik kalabilir veya veritabanında varsa dinamikleştirilebilir --}}
                                        <span class="icon-currency-exchange"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span><span class="path5"></span><span
                                                class="path6"></span>
                                        </span>
                                    </div>
                                    {{-- Kısa Açıklama --}}
                                    <p>{{ Str::limit(strip_tags($service->content), 70) }}</p>
                                </div>
                                <div class="btn-box">
                                    <a class="btn-one" href="{{ route('frontend.services.detail', $service->slug) }}">
                                        <span class="txt">{{ __('messages.read_more') }}</span>
                                        <i class="icon-right-arrow"></i>
                                    </a>
                                </div>
                                <div class="count-box">
                                    {{-- Sayfalama uyumlu sıra numarası --}}
                                    <h2>{{ str_pad($loop->iteration + (($services->currentPage() - 1) * $services->perPage()), 2, '0', STR_PAD_LEFT) }}.</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">{{ __('messages.no_services_found') }}</p>
                    </div>
                @endforelse

            </div>

            {{-- Pagination Linkleri --}}
            <div class="row">
                <div class="col-12">
                    <div class="pagination-wrapper text-center mt-4">
                         {{ $services->links() }}
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection