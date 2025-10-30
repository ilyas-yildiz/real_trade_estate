@extends('frontend.layouts.app')

{{-- GÜNCELLEME: SEO Başlığı ve Açıklaması --}}
@section('title', 'Services - Real Trade Estate')
@section('description', 'Explore the investment services and account types offered by Real Trade Estate.')

@section('content')

    <section class="breadcrumb-style1">
        <div class="breadcrumb-style1__inner">
            <div class="breadcrumb-style1-bg"
                 style="background-image: url({{ asset('frontend/assets/images/breadcrumb/breadcrumb-1.jpg') }});">
            </div>
            <div class="container">
                <div class="inner-content">
                    <div class="title">
                        {{-- GÜNCELLEME: Sayfa başlığı (Menü ile aynı) --}}
                        <h2>Invest</h2>
                    </div>
                    <div class="breadcrumb-menu">
                        <ul class="clearfix">
                            <li><a href="{{ route('frontend.home') }}">Home</a></li>
                            <li><span class="icon-right-arrow"></span></li>
                            <li class="active">Invest</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- GÜNCELLEME: Dinamik Hizmet Listeleme Bölümü --}}
    {{-- Not: Temanın padding class'ları için pdtop/pdbottom eklendi --}}
    <section class="market-style1 pdtop pdbottom">
        <div class="container">
            <div class="sec-title withtext text-center">
                <div class="sub-title">
                    {{-- GÜNCELLEME: Başlık (home.blade.php ile uyumlu) --}}
                    <h4>Invest</h4>
                </div>
                <h2>Explore Our Account Options</h2>
                <div class="text">
                    <p>
                        Discover the most competitive prices in the market, updated <br>regularly for your
                        advantage.
                    </p>
                </div>
            </div>
            <div class="row">

                {{-- GÜNCELLEME: Forelse döngüsü başladı --}}
                @forelse ($services as $service)
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="single-market-style1">
                            <div class="img-box img-box3">
                                {{-- GÜNCELLEME: Dinamik resim. Admin paneldeki upload yoluna göre 'service-images' klasör adını onayla --}}
                                <img src="{{ $service->image_url ? asset('storage/service-images/400x300/' . $service->image_url) : asset('frontend/assets/images/resources/market-v1-1.jpg') }}" alt="{{ $service->title }}">
                            </div>
                            <div class="content-box">
                                <div class="shape"
                                     style="background-image: url({{ asset('frontend/assets/images/shapes/market-v2-shape1.png') }});">
                                </div>
                                <div class="title">
                                    <h3>
                                        {{-- GÜNCELLEME: Dinamik link ve başlık --}}
                                        <a href="{{ route('frontend.services.detail', $service->slug) }}">{{ $service->title }}</a>
                                    </h3>
                                </div>
                                <div class="text">
                                    <div class="icon">
                                        {{-- 
                                            GÜNCELLEME: Bu ikon statik bırakıldı.
                                            Eğer 'services' tablosunda 'icon' sütunu varsa, burayı dinamikleştirebiliriz.
                                            Şimdilik ilk örneği (currency-exchange) baz aldım.
                                        --}}
                                        <span class="icon-currency-exchange"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span><span class="path5"></span><span
                                                class="path6"></span>
                                        </span>
                                    </div>
                                    {{-- GÜNCELLEME: Dinamik kısa açıklama (home.blade.php'deki mantıkla aynı) --}}
<p>{{ \Illuminate\Support\Str::limit(strip_tags($service->content ?? ''), 70) }}</p>
                                </div>
                                <div class="btn-box">
                                    {{-- GÜNCELLEME: Dinamik link --}}
                                    <a class="btn-one" href="{{ route('frontend.services.detail', $service->slug) }}">
                                        <span class="txt">Read More</span>
                                        <i class="icon-right-arrow"></i>
                                    </a>
                                </div>
                                <div class="count-box">
                                    {{-- GÜNCELLEME: Dinamik sayaç ($loop->iteration 1'den başlar) --}}
                                    <h2>{{ str_pad($loop->iteration + (($services->currentPage() - 1) * $services->perPage()), 2, '0', STR_PAD_LEFT) }}.</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    {{-- Eğer hiç hizmet yoksa --}}
                    <div class="col-12">
                        <p class="text-center">No services are available at the moment.</p>
                    </div>
                @endforelse
                {{-- GÜNCELLEME: Döngü bitti --}}

            </div>

            {{-- GÜNCELLEME: Pagination Linkleri (Controller'da paginate() kullandığımız için) --}}
            <div class="row">
                <div class="col-12">
                    {{-- 
                        Temanın kendi CSS'ine uyması için linkleri bir wrapper içine aldım.
                        Gerekirse 'vendor/pagination/custom.blade.php' dosyası oluşturup özelleştirebilirsin.
                    --}}
                    <div class="pagination-wrapper text-center">
                         {{ $services->links() }}
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection

{{-- Bu sayfa için özel bir script gerekmiyorsa boş bırakabiliriz --}}
@push('scripts')
@endpush