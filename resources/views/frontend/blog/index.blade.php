@extends('frontend.layouts.app')

{{-- GÜNCELLEME: SEO Başlığı ve Açıklaması --}}
@section('title', 'Blog - Real Trade Estate')
@section('description', 'Read the latest news, updates, and market analysis from Real Trade Estate.')

@section('content')

    <section class="breadcrumb-style1">
        <div class="breadcrumb-style1__inner">
            <div class="breadcrumb-style1-bg"
                 style="background-image: url({{ asset('frontend/assets/images/breadcrumb/breadcrumb-1.jpg') }});">
            </div>
            <div class="container">
                <div class="inner-content">
                    <div class="title">
                        {{-- GÜNCELLEME: Sayfa başlığı --}}
                        <h2>Our Blog</h2>
                    </div>
                    <div class="breadcrumb-menu">
                        <ul class="clearfix">
                            <li><a href="{{ route('frontend.home') }}">Home</a></li>
                            <li><span class="icon-right-arrow"></span></li>
                            <li class="active">Blog</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- GÜNCELLEME: Dinamik Blog Listeleme Bölümü --}}
    <section class="blog-page-one pdtop pdbottom">
        <div class="container">
            <div class="row">

                {{-- GÜNCELLEME: Forelse döngüsü başladı --}}
                @forelse ($blogs as $blog)
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="single-blog-style5 single-blog-style5--style6">
                            <div class="img-box">
                                {{-- GÜNCELLEME: Dinamik resim (home.blade.php'deki mantıkla aynı) --}}
                                <img src="{{ $blog->image_url ? asset('storage/blog-images/365x182/' . $blog->image_url) : asset('frontend/assets/images/blog/blog-v4-1.jpg') }}" alt="{{ $blog->title }}">
                                <div class="overlay-icon">
                                    {{-- GÜNCELLEME: Fancybox linki de dinamik resme bağlandı --}}
                                    <a class="lightbox-image" data-fancybox="gallery"
                                       href="{{ $blog->image_url ? asset('storage/blog-images/730x365/' . $blog->image_url) : asset('frontend/assets/images/blog/blog-v4-1.jpg') }}">
                                        <i class="icon-maximize"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="content-box">
                                <div class="top-box">
                                    <div class="category">
                                        <div class="icon">
                                            <i class="icon-hashtag"></i>
                                        </div>
                                        {{-- GÜNCELLEME: Dinamik Kategori --}}
                                        <h6>{{ $blog->category->name ?? 'Category' }}</h6>
                                    </div>
                                    <div class="date">
                                        <div class="icon">
                                            <i class="fa fa fa-calendar"></i>
                                        </div>
                                        {{-- GÜNCELLEME: Dinamik Tarih (Format: 15.09.2025) --}}
                                        <h6>{{ $blog->created_at->format('d.m.Y') }}</h6>
                                    </div>
                                </div>
                                <div class="title-box">
                                    <h3>
                                        {{-- GÜNCELLEME: Dinamik Link ve Başlık --}}
                                        <a href="{{ route('frontend.blog.detail', $blog->slug) }}">
                                            {{ $blog->title }}
                                        </a>
                                    </h3>
                                    {{-- GÜNCELLEME: Dinamik Kısa Açıklama --}}
                                    <p>
                                        {{ $blog->short_description ?? Str::limit(strip_tags($blog->content), 100) }}
                                    </p>
                                </div>
                                <div class="btn-box">
                                    {{-- 
                                        Not: "X Minutes read" alanı veritabanında olmadığı için kaldırıldı.
                                        Sadece "Read More" butonu bırakıldı.
                                    --}}
                                    
                                    {{-- GÜNCELLEME: Dinamik Link --}}
                                    <a class="overlay-btn" href="{{ route('frontend.blog.detail', $blog->slug) }}">
                                        Read More
                                        <i class="icon-right-arrow"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    {{-- Eğer hiç blog yazısı yoksa --}}
                    <div class="col-12">
                        <p class="text-center">No blog posts are available at the moment.</p>
                    </div>
                @endforelse
                {{-- GÜNCELLEME: Döngü bitti --}}

            </div>

            {{-- GÜNCELLEME: Dinamik Pagination Linkleri --}}
            <div class="pagination-wrapper text-center">
                {{-- 
                    Not: Statik HTML'deki '<ul class="styled-pagination clearfix">' yapısını
                    Laravel'in $blogs->links() metoduyla değiştirdim.
                --}}
                {{ $blogs->links() }}
            </div>

        </div>
    </section>

@endsection

{{-- Bu sayfa için özel bir script gerekmiyorsa boş bırakabiliriz --}}
@push('scripts')
@endpush