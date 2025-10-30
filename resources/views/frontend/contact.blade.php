@extends('frontend.layouts.app')

{{-- GÜNCELLEME: SEO Başlığı ve Açıklaması --}}
@section('title', 'Contact Us - Real Trade Estate')
@section('description', 'Get in touch with Real Trade Estate. Contact us for support, inquiries, or feedback.')

@section('content')

    <section class="breadcrumb-style1">
        <div class="breadcrumb-style1__inner">
            <div class="breadcrumb-style1-bg"
                 style="background-image: url({{ asset('frontend/assets/images/breadcrumb/breadcrumb-1.jpg') }});">
            </div>
            <div class="container">
                <div class="inner-content">
                    <div class="title">
                        <h2>Contact Us</h2>
                    </div>
                    <div class="breadcrumb-menu">
                        <ul class="clearfix">
                            <li><a href="{{ route('frontend.home') }}">Home</a></li>
                            <li><span class="icon-right-arrow"></span></li>
                            <li class="active">Contact</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="quick-contact-style1 pdtop"> {{-- GÜNCELLEME: pdtop class'ı eklendi --}}
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-5">
                    <div class="quick-contact-style1__content">
                        <div class="sec-title withtext">
                            <div class="sub-title">
                                <h4>Contact</h4>
                            </div>
                            <h2>Let’s Talk, Experts Ready Help You</h2>
                            <div class="text">
                                <p>Get the professional guidance and support you need from our experts.</p>
                            </div>
                        </div>
                        <div class="social-link">
                            <h4>Get Social</h4>
                            {{-- GÜNCELLEME: Dinamik Sosyal Medya Linkleri ($settings'den) --}}
                            <ul>
                                @if(!empty($settings['facebook_url']))
                                    <li><a href="{{ $settings['facebook_url'] }}" target="_blank"><i class="icon-facebook"></i></a></li>
                                @endif
                                @if(!empty($settings['twitter_url'])) {{-- twitter_url eklendi (şablonda vardı) --}}
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
                        {{-- Statik SSS Kutusu --}}
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
                                    <p>Answers to 100+ Questions.</p>
                                    <a href="#"> {{-- TODO: SSS sayfası rotası eklenecek --}}
                                        Explore Faq’s
                                        <i class="icon-right-arrow"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-7">
                    {{-- Statik Geri Arama ve Canlı Sohbet Kutuları (İsteğe bağlı olarak dinamikleştirilebilir) --}}
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
                                <h3>Request Call Back</h3>
                                <p>Share your ph num, we will back.</p>
                            </div>
                            <form id="quick-contact-form" name="quick-contact_form" class="default-form1"
                                  action="javascript:void(0);" method="post">
                                <div class="form-group">
                                    <div class="input-box">
                                        <input type="text" name="form_phone" id="formPhonee"
                                               placeholder="Enter ph num" value="">
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
                                <h3>Live Chat</h3>
                                <p>Chat live with our forex specialist.
                                </p>
                            </div>
                            <div class="btn-box">
                                <a class="btn-one" href="#">
                                    <span class="txt">Start Chat</span>
                                    <i class="icon-right-arrow"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <div class="quick-contact-style1-info">
                        <div class="inner-title">
                            <h3>Contact Info</h3>
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
                                        <h4>United States</h4>
                                        {{-- GÜNCELLEME: Dinamik Adres --}}
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
                                        <h4>Phone</h4>
                                        {{-- GÜNCELLEME: Dinamik Telefon --}}
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
                                        <h4>Email</h4>
                                        {{-- GÜNCELLEME: Dinamik Email ('Tradebro' kaldırıldı) --}}
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
                                        <h4>Office Hours</h4>
                                        {{-- GÜNCELLEME: Dinamik Çalışma Saatleri --}}
                                        <p>{{ $settings['office_hours'] ?? 'Mon - Sat: 8.30am to 5.30pm' }}</p>
                                    </div>
                                </li>
                            </ul>
                            <div class="btn-box">
                                {{-- GÜNCELLEME: Dinamik Google Maps Linki --}}
                                <a class="btn-one"
                                   href="{{ $settings['google_maps_url'] ?? '#' }}" target="_blank">
                                    <span class="txt">View On Map</span>
                                    <i class="icon-right-arrow"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="main-contact-form pdbottom"> {{-- GÜNCELLEME: pdbottom class'ı eklendi --}}
        <div class="container">
            <div class="sec-title text-center">
                <div class="sub-title">
                    <h4>Send Message</h4>
                </div>
                <h2>Send Us a Message Anytime</h2>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="contact-form">
                        {{-- GÜNCELLEME: Form rotası, method ve @csrf eklendi --}}
                        <form id="contact-form" name="contact_form" class="default-form2"
                              action="{{ route('frontend.contact.submit') }}" method="post">
                            @csrf

                            {{-- GÜNCELLEME: Başarı ve Hata Mesajları Alanı --}}
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
                                            {{-- GÜNCELLEME: 'name' ve 'old()' eklendi --}}
                                            <input type="text" name="name" id="formName"
                                                   placeholder="Your name" required="" value="{{ old('name') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <div class="input-box">
                                            {{-- Not: Controller bu alanı doğrulamıyor, ama formda tutabiliriz --}}
                                            <input type="text" name="phone" id="formPhone"
                                                   placeholder="Phone number" value="{{ old('phone') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <div class="input-box">
                                            {{-- GÜNCELLEME: 'email' ve 'old()' eklendi --}}
                                            <input type="email" name="email" id="formEmail"
                                                   placeholder="Email address" required="" value="{{ old('email') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <div class="input-box">
                                            {{-- Not: Controller bu alanı doğrulamıyor, ama formda tutabiliriz --}}
                                            <input type="text" name="subject" id="formSubject"
                                                   placeholder="Subject" value="{{ old('subject') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="form-group">
                                        <div class="input-box">
                                            {{-- GÜNCELLEME: 'message' ve 'old()' eklendi --}}
                                            <textarea name="message" id="formMessage"
                                                      placeholder="Message goes here" required="">{{ old('message') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="button-box">
                                        <input id="form_botcheck" name="form_botcheck" class="form-control"
                                               type="hidden" value="">
                                        <div class="btn-box">
                                            <button class="btn-one" type="submit"
                                                    data-loading-text="Please wait...">
                                                <span class="txt">Send Your Message</span>
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

{{-- Bu sayfa için özel bir script gerekmiyorsa boş bırakabiliriz --}}
@push('scripts')
@endpush