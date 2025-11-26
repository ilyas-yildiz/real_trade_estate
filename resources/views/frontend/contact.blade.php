@extends('frontend.layouts.app')

{{-- SEO Başlığı --}}
@section('title', __('messages.contact') . ' - ' . __('messages.site_title'))

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
                        {{-- GÜNCELLEME: Çeviri --}}
                        <h2>{{ __('messages.contact_us') }}</h2>
                    </div>
                    <div class="breadcrumb-menu">
                        <ul class="clearfix">
                            <li><a href="{{ route('frontend.home') }}">{{ __('messages.home') }}</a></li>
                            <li><span class="icon-right-arrow"></span></li>
                            <li class="active">{{ __('messages.contact') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="quick-contact-style1 pdtop">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-5">
                    <div class="quick-contact-style1__content">
                        <div class="sec-title withtext">
                            <div class="sub-title">
                                <h4>{{ __('messages.contact') }}</h4>
                            </div>
                            {{-- GÜNCELLEME: Çeviri --}}
                            <h2>{{ __('messages.lets_talk') }}</h2>
                            <div class="text">
                                <p>{{ __('messages.contact_desc') }}</p>
                            </div>
                        </div>
                        <div class="social-link">
                            <h4>{{ __('messages.get_social') }}</h4>
                            <ul>
                                @if(!empty($settings['facebook_url']))
                                    <li><a href="{{ $settings['facebook_url'] }}" target="_blank"><i class="icon-facebook"></i></a></li>
                                @endif
                                @if(!empty($settings['twitter_url']))
                                    <li><a href="{{ $settings['twitter_url'] }}" target="_blank"><i class="icon-twitter"></i></a></li>
                                @endif
                                @if(!empty($settings['youtube_url']))
                                    <li><a href="{{ $settings['youtube_url'] }}" target="_blank"><i class="icon-youtube"></i></a></li>
                                @endif
                                @if(!empty($settings['instagram_url']))
                                    <li><a href="{{ $settings['instagram_url'] }}" target="_blank"><i class="icon-social"></i></a></li>
                                @endif
                            </ul>
                        </div>
                        
                        <div class="faq-box">
                            <div class="faq-box-inner">
                                <div class="icon">
                                    <span class="icon-guide"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span><span
                                            class="path4"></span><span class="path5"></span><span
                                            class="path6"></span><span class="path7"></span><span
                                            class="path8"></span><span class="path9"></span><span
                                            class="path10"></span>
                                    </span>
                                </div>
                                <div class="text">
                                    {{-- GÜNCELLEME: Çeviri --}}
                                    <p>{{ __('messages.faq_text') }}</p>
                                    <a href="#">
                                        {{ __('messages.explore_faq') }}
                                        <i class="icon-right-arrow"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-7">
                    
                    <div class="quick-contact-style1__inner">
                        <div class="single-quick-contact-style1">
                            <div class="icon">
                                <span class="icon-telephone"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span><span
                                        class="path4"></span><span class="path5"></span><span
                                        class="path6"></span><span class="path7"></span>
                                </span>
                            </div>
                            <div class="title">
                                <h3>{{ __('messages.request_callback') }}</h3>
                                <p>{{ __('messages.callback_desc') }}</p>
                            </div>
                            {{-- Form (Şimdilik JS placeholder) --}}
                            <form id="quick-contact-form" name="quick-contact_form" class="default-form1"
                                  action="javascript:void(0);" method="post">
                                <div class="form-group">
                                    <div class="input-box">
                                        <input type="text" name="form_phone" id="formPhonee"
                                               placeholder="{{ __('messages.enter_phone') }}" value="">
                                    </div>
                                </div>
                                <button type="submit" data-loading-text="Please wait...">
                                    <i class="icon-right-arrow"></i>
                                </button>
                            </form>
                        </div>
                        <div class="single-quick-contact-style1">
                            <div class="icon">
                                <span class="icon-chat-1"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span><span class="path4"></span>
                                </span>
                            </div>
                            <div class="title">
                                <h3>{{ __('messages.live_chat') }}</h3>
                                <p>{{ __('messages.live_chat_desc') }}</p>
                            </div>
                            <div class="btn-box">
                                <a class="btn-one" href="#">
                                    <span class="txt">{{ __('messages.start_chat') }}</span>
                                    <i class="icon-right-arrow"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <div class="quick-contact-style1-info">
                        <div class="inner-title">
                            <h3>{{ __('messages.contact_info') }}</h3>
                        </div>
                        <div class="list-item">
                            <ul>
                                <li>
                                    <div class="icon">
                                        <span class="icon-map"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span><span class="path5"></span><span
                                                class="path6"></span>
                                        </span>
                                    </div>
                                    <div class="text">
                                        {{-- Ülke Adı --}}
                                        <h4>{{ __('messages.location') }}</h4>
                                        {{-- Dinamik Adres --}}
                                        <p>{{ $settings['address'] ?? '280/5 Granite Run Drive Suite, Houston - 90010.' }}</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <span class="icon-phone-vibration"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span><span class="path5"></span><span
                                                class="path6"></span><span class="path7"></span><span
                                                class="path8"></span><span class="path9"></span>
                                        </span>
                                    </div>
                                    <div class="text">
                                        <h4>{{ __('messages.phone') }}</h4>
                                        {{-- Dinamik Telefon --}}
                                        <p><a href="tel:{{ $settings['phone'] ?? '+180098765432' }}">{{ $settings['phone'] ?? '+1 800.98.76.5432' }}</a></p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <span class="icon-read"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span>
                                        </span>
                                    </div>
                                    <div class="text">
                                        <h4>{{ __('messages.email') }}</h4>
                                        {{-- Dinamik Email --}}
                                        <p><a href="mailto:{{ $settings['email'] ?? 'sendmail@realtrade.com' }}">{{ $settings['email'] ?? 'sendmail@realtrade.com' }}</a></p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <span class="icon-alarm-clock"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span><span class="path5"></span><span
                                                class="path6"></span><span class="path7"></span><span
                                                class="path8"></span><span class="path9"></span>
                                        </span>
                                    </div>
                                    <div class="text">
                                        <h4>{{ __('messages.office_hours') }}</h4>
                                        {{-- Dinamik Çalışma Saatleri --}}
                                        <p>{{ $settings['office_hours'] ?? 'Mon - Sat: 8.30am to 5.30pm' }}</p>
                                    </div>
                                </li>
                            </ul>
                            <div class="btn-box">
                                {{-- Dinamik Google Maps Linki --}}
                                <a class="btn-one"
                                   href="{{ $settings['google_maps_url'] ?? '#' }}" target="_blank">
                                    <span class="txt">{{ __('messages.view_on_map') }}</span>
                                    <i class="icon-right-arrow"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="main-contact-form pdbottom">
        <div class="container">
            <div class="sec-title text-center">
                <div class="sub-title">
                    <h4>{{ __('messages.send_message') }}</h4>
                </div>
                <h2>{{ __('messages.send_message_anytime') }}</h2>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="contact-form">
                        <form id="contact-form" name="contact_form" class="default-form2"
                              action="{{ route('frontend.contact.submit') }}" method="post">
                            @csrf

                            {{-- Başarı ve Hata Mesajları --}}
                            @if ($errors->any())
                                <div class="alert alert-danger mb-3">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(session('success'))
                                <div class="alert alert-success mb-3">
                                    {{ session('success') }}
                                </div>
                            @endif
                            
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <div class="input-box">
                                            <input type="text" name="name" id="formName"
                                                   placeholder="{{ __('messages.your_name') }}" required="" value="{{ old('name') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <div class="input-box">
                                            <input type="text" name="phone" id="formPhone"
                                                   placeholder="{{ __('messages.phone_number') }}" value="{{ old('phone') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <div class="input-box">
                                            <input type="email" name="email" id="formEmail"
                                                   placeholder="{{ __('messages.email_address') }}" required="" value="{{ old('email') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <div class="input-box">
                                            <input type="text" name="subject" id="formSubject"
                                                   placeholder="{{ __('messages.subject') }}" value="{{ old('subject') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="form-group">
                                        <div class="input-box">
                                            <textarea name="message" id="formMessage"
                                                      placeholder="{{ __('messages.message_here') }}" required="">{{ old('message') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="button-box">
                                        <div class="btn-box">
                                            <button class="btn-one" type="submit"
                                                    data-loading-text="Please wait...">
                                                <span class="txt">{{ __('messages.send_your_message') }}</span>
                                                <i class="icon-right-arrow"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
@endsection