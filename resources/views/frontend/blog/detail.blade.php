@extends('frontend.layouts.app')

{{-- SEO Başlığı --}}
@section('title', $blog->getTranslation('title') . ' - ' . __('messages.site_title'))

{{-- Meta Description --}}
@section('description', $blog->getTranslation('short_description') ?? Str::limit(strip_tags($blog->getTranslation('content')), 160))

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
                        <h2>{{ __('messages.blog_details') }}</h2>
                    </div>
                    <div class="breadcrumb-menu">
                        <ul class="clearfix">
                            <li><a href="{{ route('frontend.home') }}">{{ __('messages.home') }}</a></li>
                            <li><span class="icon-right-arrow"></span></li>
                            <li><a href="{{ route('frontend.blog.index') }}">{{ __('messages.blog') }}</a></li>
                            <li><span class="icon-right-arrow"></span></li>
                            {{-- GÜNCELLEME: Başlık Çevirisi --}}
                            <li class="active">{{ Str::limit($blog->getTranslation('title'), 30) }}</li>
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
                                        {{-- Dinamik Kategori --}}
                                        <h6>{{ $blog->category->name ?? __('messages.category') }}</h6>
                                    </div>
                                    <ul>
                                        <li>
                                            <div class="icon">
                                                <i class="fa fa fa-calendar"></i>
                                            </div>
                                            {{-- Dinamik Tarih --}}
                                            <h6>{{ $blog->created_at->format('d.m.Y') }}</h6>
                                        </li>
                                        <li>
                                            <div class="icon">
                                                <i class="icon-add-user"></i>
                                            </div>
                                            {{-- Dinamik Yazar --}}
                                            <h6>{{ $blog->user->name ?? 'Admin' }}</h6>
                                        </li>
                                    </ul>
                                </div>
                                <div class="title-box">
                                    {{-- GÜNCELLEME: Başlık Çevirisi --}}
                                    <h3>{{ $blog->getTranslation('title') }}</h3>
                                </div>
                            </div>
                       <div class="img-box">
                                {{-- GÜNCELLEME: Yol 'blog-images/730x365/' olarak düzeltildi --}}
                                <img src="{{ $blog->image_url ? asset('storage/blog-images/730x365/' . $blog->image_url) : asset('frontend/assets/images/blog/blog-v5-2.jpg') }}" 
                                     alt="{{ $blog->getTranslation('title') }}">
                            </div>
                        </div>

                        <div class="blog-details-text1">
                            {{-- GÜNCELLEME: İçerik Çevirisi --}}
                            {!! $blog->getTranslation('content') !!}
                        </div>

                        {{-- Yazar Kutusu --}}
                        <div class="blog-details-author">
                            <div class="blog-details-author-inner">
                                <div class="img-box">
                                    <img src="{{ asset('frontend/assets/images/blog/author-1.jpg') }}" alt="author">
                                </div>
                                <div class="content-box">
                                    <div class="top">
                                        {{-- GÜNCELLEME: Çeviri --}}
                                        <h4>{{ __('messages.author') }}</h4>
                                        <h3>{{ $blog->user->name ?? 'Admin' }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Geri Dön Butonu --}}
                        <div class="back-to-blog-post-btn">
                            <a href="{{ route('frontend.blog.index') }}">
                                <img src="{{ asset('frontend/assets/images/icon/menu-1.png') }}" alt="Icon">
                                {{ __('messages.back_to_blog') }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="blog-page__sidebar">
                        
                        <div class="sidebar-search-box-one">
                            <form class="search-form" action="#">
                                <input placeholder="{{ __('messages.search_placeholder') }}" type="text">
                                <button type="submit">
                                    <i class="icon-search"></i>
                                </button>
                            </form>
                        </div>
                        
                        <div class="single-sidebar-box">
                            <div class="sidebar-title">
                                <h3>{{ __('messages.categories') }}</h3>
                            </div>
                            <ul class="single-sidebar__categories clearfix">
                                @forelse ($categories as $category)
                                    <li>
                                        <a href="{{ route('frontend.blog.index', ['category' => $category->slug]) }}">
                                            <p>{{ $category->name }}</p>
                                            <div class="icon">
                                                <i class="icon-arrow-right"></i>
                                            </div>
                                        </a>
                                    </li>
                                @empty
                                    <li><p>{{ __('messages.no_categories') }}</p></li>
                                @endforelse
                            </ul>
                        </div>
                        
                        <div class="single-sidebar-box">
                            <div class="sidebar-title">
                                <h3>{{ __('messages.latest_posts') }}</h3>
                            </div>
                            <ul class="single-sidebar__post clearfix">
                                @forelse ($latestBlogs as $latestPost)
                                    <li>
                                        <div class="category">
                                            <div class="icon">
                                                <i class="icon-hashtag"></i>
                                            </div>
                                            <h6>{{ $latestPost->category->name ?? __('messages.category') }}</h6>
                                        </div>
                                        <div class="title-box">
                                            <h4>
                                                <a href="{{ route('frontend.blog.detail', $latestPost->slug) }}">
                                                    {{ $latestPost->getTranslation('title') }}
                                                </a>
                                            </h4>
                                        </div>
                                        <div class="btn-box">
                                            <a class="overlay-btn" href="{{ route('frontend.blog.detail', $latestPost->slug) }}">
                                                {{ __('messages.read_more') }}
                                                <i class="icon-right-arrow"></i>
                                            </a>
                                        </div>
                                    </li>
                                @empty
                                     <li><p>{{ __('messages.no_recent_posts') }}</p></li>
                                @endforelse
                            </ul>
                        </div>

                        {{-- Subscribe Formu --}}
                        <div class="subscribe-sidebar-box">
                            <div class="shape1">
                                <img src="{{ asset('frontend/assets/images/shapes/subscribe-sidebar-form-v1-shape1.png') }}" alt="Shape">
                            </div>
                            <div class="shape2">
                                <img src="{{ asset('frontend/assets/images/shapes/subscribe-sidebar-form-v1-shape2.png') }}" alt="Shape">
                            </div>
                            <div class="tilte-box">
                                <h3>{{ __('messages.subscribe_us') }}</h3>
                                <p>{{ __('messages.subscribe_desc') }}</p>
                            </div>
                            <div class="subscribe-sidebar-form">
                                <form action="#" method="post">
                                    <div class="form-group">
                                        <input type="email" name="email" placeholder="{{ __('messages.email_placeholder') }}" required="">
                                    </div>
                                    <div class="checked-box1">
                                        <input type="checkbox" name="skipper1" id="skipperr" checked="">
                                        <label for="skipper">
                                            <span></span>{{ __('messages.agree_terms') }}
                                        </label>
                                    </div>
                                    <div class="btn-box">
                                        <button class="submit btn-one">
                                            <span class="txt">{{ __('messages.subscribe') }}</span>
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