@extends('frontend.layouts.app')

{{-- SEO Başlığı --}}
@section('title', __('messages.blog') . ' - ' . __('messages.site_title'))

{{-- Meta Description --}}
@section('description', __('messages.meta_description_default'))

@section('content')

    <section class="breadcrumb-style1">
        <div class="breadcrumb-style1__inner">
            <div class="breadcrumb-style1-bg"
                 style="background-image: url({{ asset('frontend/assets/images/breadcrumb/breadcrumb-1.jpg') }});">
            </div>
            <div class="container">
                <div class="inner-content">
                    <div class="title">
                        <h2>{{ __('messages.our_blog') }}</h2>
                    </div>
                    <div class="breadcrumb-menu">
                        <ul class="clearfix">
                            <li><a href="{{ route('frontend.home') }}">{{ __('messages.home') }}</a></li>
                            <li><span class="icon-right-arrow"></span></li>
                            <li class="active">{{ __('messages.blog') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="blog-page-one pdtop pdbottom">
        <div class="container">
            <div class="row">

                @forelse ($blogs as $blog)
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="single-blog-style5 single-blog-style5--style6">
                            <div class="img-box">
                                <img src="{{ $blog->image_url ? asset('storage/blog-images/365x182/' . $blog->image_url) : asset('frontend/assets/images/blog/blog-v4-1.jpg') }}" 
                                     alt="{{ $blog->getTranslation('title') }}">
                                <div class="overlay-icon">
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
                                        {{-- Kategori Çevirisi (Eğer kategori adı da çevriliyorsa) --}}
                                        {{-- Şimdilik name string olduğu varsayılıyor --}}
                                        <h6>{{ $blog->category->name ?? __('messages.category') }}</h6>
                                    </div>
                                    <div class="date">
                                        <div class="icon">
                                            <i class="fa fa fa-calendar"></i>
                                        </div>
                                        <h6>{{ $blog->created_at->format('d.m.Y') }}</h6>
                                    </div>
                                </div>
                                <div class="title-box">
                                    <h3>
                                        {{-- DÜZELTME: Başlık Çevirisi --}}
                                        <a href="{{ route('frontend.blog.detail', $blog->slug) }}">
                                            {{ $blog->getTranslation('title') }}
                                        </a>
                                    </h3>
                                    {{-- DÜZELTME: Kısa Açıklama Çevirisi --}}
                                    <p>
                                        {{ $blog->getTranslation('short_description') ?? Str::limit(strip_tags($blog->getTranslation('content')), 100) }}
                                    </p>
                                </div>
                                <div class="btn-box">
                                    <a class="overlay-btn" href="{{ route('frontend.blog.detail', $blog->slug) }}">
                                        {{ __('messages.read_more') }}
                                        <i class="icon-right-arrow"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">{{ __('messages.no_blog_posts') }}</p>
                    </div>
                @endforelse

            </div>

            <div class="pagination-wrapper text-center">
                {{ $blogs->links() }}
            </div>

        </div>
    </section>

@endsection