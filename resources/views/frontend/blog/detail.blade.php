@extends('frontend.layouts.app')

{{-- GÜNCELLEME: SEO Başlığı ve Açıklaması bloga özel --}}
@section('title', $blog->title . ' - Real Trade Estate')
@section('description', $blog->short_description ?? Str::limit(strip_tags($blog->content), 160))

@section('content')

    <section class="breadcrumb-style1">
        <div class="breadcrumb-style1__inner">
            <div class="breadcrumb-style1-bg"
                 style="background-image: url({{ asset('frontend/assets/images/breadcrumb/breadcrumb-1.jpg') }});">
            </div>
            <div class="container">
                <div class="inner-content">
                    <div class="title">
                        <h2>Blog Details</h2>
                    </div>
                    <div class="breadcrumb-menu">
                        <ul class="clearfix">
                            <li><a href="{{ route('frontend.home') }}">Home</a></li>
                            <li><span class="icon-right-arrow"></span></li>
                            <li><a href="{{ route('frontend.blog.index') }}">Blog</a></li>
                            <li><span class="icon-right-arrow"></span></li>
                            {{-- GÜNCELLEME: Aktif blog başlığı --}}
                            <li class="active">{{ Str::limit($blog->title, 30) }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="blog-details pdtop pdbottom">
        <div class="container">
            <div class="row">

                <div class="col-xl-8">
                    <div class="blog-details__content">
                        <div class="blog-details-top">
                            <div class="content-box">
                                <div class="top-box">
                                    <div class="category">
                                        <div class="icon">
                                            <i class="icon-hashtag"></i>
                                        </div>
                                        {{-- GÜNCELLEME: Dinamik Kategori --}}
                                        <h6>{{ $blog->category->name ?? 'Category' }}</h6>
                                    </div>
                                    <ul>
                                        <li>
                                            <div class="icon">
                                                <i class="fa fa fa-calendar"></i>
                                            </div>
                                            {{-- GÜNCELLEME: Dinamik Tarih --}}
                                            <h6>{{ $blog->created_at->format('d.m.Y') }}</h6>
                                        </li>
                                        <li>
                                            <div class="icon">
                                                <i class="icon-add-user"></i>
                                            </div>
                                            {{-- GÜNCELLEME: Dinamik Yazar --}}
                                            <h6>{{ $blog->user->name ?? 'Admin' }}</h6>
                                        </li>
                                        {{-- 
                                            Not: Yorum sayısı (10 Cmts) statik olduğu 
                                            ve veritabanında karşılığı olmadığı için kaldırıldı.
                                        --}}
                                    </ul>
                                </div>
                                <div class="title-box">
                                    <h3>
                                        {{-- GÜNCELLEME: Dinamik Başlık --}}
                                        {{ $blog->title }}
                                    </h3>
                                </div>
                            </div>
                            <div class="img-box">
                                {{-- GÜNCELLEME: İsteğin üzerine $blog->image_url kullanıldı --}}
                                <img src="{{ $blog->image_url ? asset('storage/blog-images/730x365/' . $blog->image_url) : asset('frontend/assets/images/blog/blog-v5-2.jpg') }}" alt="{{ $blog->title }}">
                            </div>
                        </div>

                        {{-- GÜNCELLEME: Dinamik İçerik --}}
                        <div class="blog-details-text1">
                            {{-- 
                                {!! !!} kullanıyoruz ki admin panelinden eklenen
                                <p>, <ul>, <h3> gibi HTML etiketleri düzgün görünsün.
                            --}}
                            {!! $blog->content !!}
                        </div>

                        {{-- 
                            Not: Statik "Quote" (Alıntı), "Tags" (Etiketler), 
                            "Prev/Next Post" (Önceki/Sonraki Yazı) bölümleri
                            veritabanında karşılığı olmadığı için kaldırıldı.
                        --}}

                        {{-- Yazar Kutusu (Basitleştirilmiş) --}}
                        <div class="blog-details-author">
                            <div class="blog-details-author-inner">
                                <div class="img-box">
                                    {{-- TODO: Yazar resmi dinamikleştirilebilir --}}
                                    <img src="{{ asset('frontend/assets/images/blog/author-1.jpg') }}" alt="author">
                                </div>
                                <div class="content-box">
                                    <div class="top">
                                        <h4>Author</h4>
                                        {{-- GÜNCELLEME: Dinamik Yazar Adı --}}
                                        <h3>{{ $blog->user->name ?? 'Admin' }}</h3>
                                    </div>
                                    {{-- 
                                        Not: Statik bio, sosyal medya linkleri vb. kaldırıldı.
                                        Gerekirse user tablosuna "bio" eklenebilir.
                                    --}}
                                </div>
                            </div>
                        </div>

                        {{-- Bloga Geri Dön Butonu --}}
                        <div class="back-to-blog-post-btn">
                            {{-- GÜNCELLEME: Link düzeltildi --}}
                            <a href="{{ route('frontend.blog.index') }}">
                                <img src="{{ asset('frontend/assets/images/icon/menu-1.png') }}" alt="Icon">
                                Back to Blog Post
                            </a>
                        </div>
                    </div>
                </div>

                {{-- GÜNCELLEME: Dinamik Sidebar --}}
                <div class="col-xl-4">
                    <div class="blog-page__sidebar">
                        
                        {{-- Statik Arama Kutusu --}}
                        <div class="sidebar-search-box-one">
                            <form class="search-form" action="#">
                                <input placeholder="Keyword..." type="text">
                                <button type="submit">
                                    <i class="icon-search"></i>
                                </button>
                            </form>
                        </div>
                        
                        <div class="single-sidebar-box">
                            <div class="sidebar-title">
                                <h3>Categories</h3>
                            </div>
                            <ul class="single-sidebar__categories clearfix">
                                @forelse ($categories as $category)
                                    <li>
                                        {{-- GÜNCELLEME: Kategori linki eklendi --}}
                                        <a href="{{ route('frontend.blog.index', ['category' => $category->slug]) }}">
                                            <p>{{ $category->name }}</p>
                                            <div class="icon">
                                                <i class="icon-arrow-right"></i>
                                            </div>
                                        </a>
                                    </li>
                                @empty
                                    <li><p>No categories found.</p></li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="single-sidebar-box">
                            <div class="sidebar-title">
                                <h3>Latest Posts</h3>
                            </div>
                            <ul class="single-sidebar__post clearfix">
                                @forelse ($latestBlogs as $latestPost)
                                    <li>
                                        <div class="category">
                                            <div class="icon">
                                                <i class="icon-hashtag"></i>
                                            </div>
                                            <h6>{{ $latestPost->category->name ?? 'Category' }}</h6>
                                        </div>
                                        <div class="title-box">
                                            <h4>
                                                <a href="{{ route('frontend.blog.detail', $latestPost->slug) }}">
                                                    {{ $latestPost->title }}
                                                </a>
                                            </h4>
                                        </div>
                                        <div class="btn-box">
                                            {{-- Not: "Okuma süresi" kaldırıldı --}}
                                            <a class="overlay-btn" href="{{ route('frontend.blog.detail', $latestPost->slug) }}">
                                                Read More
                                                <i class="icon-right-arrow"></i>
                                            </a>
                                        </div>
                                    </li>
                                @empty
                                     <li><p>No recent posts found.</p></li>
                                @endforelse
                            </ul>
                        </div>
                        {{-- 
                            Not: Statik "Post Tag" (Etiketler) bölümü kaldırıldı.
                        --}}

                        {{-- Statik Abone Ol Kutusu --}}
                        <div class="subscribe-sidebar-box">
                            <div class="shape1">
                                <img src="{{ asset('frontend/assets/images/shapes/subscribe-sidebar-form-v1-shape1.png') }}" alt="Shape">
                            </div>
                            <div class="shape2">
                                <img src="{{ asset('frontend/assets/images/shapes/subscribe-sidebar-form-v1-shape2.png') }}" alt="Shape">
                            </div>
                            <div class="tilte-box">
                                <h3>SubscribeUs</h3>
                                <p>Get updates in your inbox diectly.</p>
                            </div>
                            <div class="subscribe-sidebar-form">
                                <form action="#" method="post">
                                    <div class="form-group">
                                        <input type="email" name="email" placeholder="Email address..." required="">
                                    </div>
                                    <div class="checked-box1">
                                        <input type="checkbox" name="skipper1" id="skipperr" checked="">
                                        <label for="skipper">
                                            <span></span>I agree terms & conditions.
                                        </label>
                                    </div>
                                    <div class="btn-box">
                                        <button class="submit btn-one">
                                            <span class="txt">Subscribe</span>
                                            <i class="icon-right-arrow"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                </div>

            </div>
        </div>
    </section>
    @endsection

{{-- Bu sayfa için özel bir script gerekmiyorsa boş bırakabiliriz --}}
@push('scripts')
@endpush