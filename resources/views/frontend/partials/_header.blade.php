<header class="main-header main-header-style1">

    <div class="main-header-style1__content">
        <div class="container">
            <div class="main-header-style1__content-inner">
                <div class="main-header-style1__content-top">
                    <div class="main-header-style1__content-top-left">
                        <div class="header-logo-box-style1">
                            <a href="{{ route('frontend.home') }}">
                                <img src="{{ asset('frontend/assets/images/resources/logo-7.png') }}" alt="Logo" title="Real Trade State" width="130">
                            </a>
                        </div>
                        <div class="header-trading-time-style1">
                            <div class="icon">
                                <i class="icon-hour"></i>
                            </div>
                            <div class="text">
                                <p>{{ __('messages.stock_hours') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="main-header-style1__content-top-middle">
                        <div class="btn-box">
                            <a class="btn-one active" href="#">
                                <span class="txt">{{ __('messages.clients') }}</span>
                            </a>
                            <a class="btn-one" href="#">
                                <span class="txt">{{ __('messages.partners') }}</span>
                            </a>
                        </div>
                    </div>

                    <div class="main-header-style1__content-top-right">
                        <div class="header-login-register-style1">
                            <div class="icon">
                                <span class="icon-lock"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span>
                                </span>
                            </div>
                            <div class="title">
                                <h3>{{ __('messages.my_portal') }}</h3>
                                @guest
                                    <p><a href="{{ route('login') }}">{{ __('messages.login') }}</a> - {{ __('messages.or') }} - <a href="{{ route('register') }}">{{ __('messages.register') }}</a></p>
                                @endguest
                                @auth
                                    <p><a href="{{ route('admin.dashboard') }}">{{ __('messages.my_account') }}</a> - (<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-frontend').submit();">{{ __('messages.logout') }}</a>)</p>
                                    <form id="logout-form-frontend" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                @endauth
                            </div>
                        </div>
                        <div class="header-help-center-style1">
                             {{-- Yardım merkezi içeriği --}}
                        </div>
                    </div>
                </div>

                <div class="main-header-style1__content-bottom">
                    <div class="main-header-style1__content-bottom-left">
                        <nav class="main-menu main-menu-style1">
                            <div class="main-menu__wrapper clearfix">
                                <div class="main-menu__wrapper-inner">
                                    <div class="sticky-logo-box-style1">
                                        <a href="{{ route('frontend.home') }}">
                                            <img src="{{ asset('frontend/assets/images/resources/logo-7.png') }}" alt="Logo" title="Real Trade State" width="130">
                                        </a>
                                    </div>
                                    <div class="main-menu-style1__left">
                                        <div class="main-menu-box">
                                            <a href="#" class="mobile-nav__toggler">
                                                <i class="fa fa-bars"></i>
                                            </a>

                                            <ul class="main-menu__list">
                                                {{-- GÜNCELLEME: Menü isimleri Çeviri Fonksiyonu ile Değiştirildi --}}
                                                <li class="{{ request()->routeIs('frontend.home') ? 'current' : '' }}">
                                                    <a href="{{ route('frontend.home') }}">{{ __('messages.home') }}</a>
                                                </li>
                                                <li class="{{ request()->routeIs('frontend.about') ? 'current' : '' }}">
                                                    <a href="{{ route('frontend.about') }}">{{ __('messages.about_us') }}</a>
                                                </li>
                                                <li class="{{ request()->routeIs('frontend.services*') ? 'current' : '' }}">
                                                    <a href="{{ route('frontend.services') }}">{{ __('messages.invest') }}</a>
                                                </li>
                                                <li class="{{ request()->routeIs('frontend.blog*') ? 'current' : '' }}">
                                                    <a href="{{ route('frontend.blog.index') }}">{{ __('messages.blog') }}</a>
                                                </li>
                                                <li class="{{ request()->routeIs('frontend.contact') ? 'current' : '' }}">
                                                    <a href="{{ route('frontend.contact') }}">{{ __('messages.contact') }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </nav>
                        </div>

                    <div class="main-header-style1__content-bottom-right">
                       {{-- GÜNCELLEME: Dil Seçici (Bayraklı ve Açık Yapı) --}}
                        <div class="language-switcher-style1" style="margin-right: 20px;">
                            <div class="d-flex align-items-center gap-3">
                                
                                {{-- İngilizce Seçeneği --}}
                                <a href="{{ route('frontend.lang.switch', 'en') }}" 
                                   class="d-flex align-items-center gap-1 text-decoration-none"
                                   style="opacity: {{ App::getLocale() == 'en' ? '1' : '0.6' }}; transition: 0.3s;">
                                    <img src="{{ asset('admin/images/flags/us.svg') }}" alt="EN" style="width: 20px; height: auto; box-shadow: 0 0 3px rgba(0,0,0,0.2);">
                                    <span style="font-weight: {{ App::getLocale() == 'en' ? '700' : '400' }}; color: var(--thm-white); font-size: 14px;">EN</span>
                                </a>

                                <span style="color: #ccc;">|</span>

                                {{-- Türkçe Seçeneği --}}
                                <a href="{{ route('frontend.lang.switch', 'tr') }}" 
                                   class="d-flex align-items-center gap-1 text-decoration-none"
                                   style="opacity: {{ App::getLocale() == 'tr' ? '1' : '0.6' }}; transition: 0.3s;">
                                    <img src="{{ asset('admin/images/flags/tr.svg') }}" alt="TR" style="width: 20px; height: auto; box-shadow: 0 0 3px rgba(0,0,0,0.2);">
                                    <span style="font-weight: {{ App::getLocale() == 'tr' ? '700' : '400' }}; color: var(--thm-white); font-size: 14px;">TR</span>
                                </a>

                            </div>
                        </div>
                        
                        <div class="header-btn-box-style1">
                            <div class="icon">
                                <i class="icon-candle"></i>
                            </div>
                            <div class="text">
                                <a href="{{ route('register') }}">
                                    {!! __('messages.start_trading') !!} <br>Trading
                                    <i class="icon-right-arrow"></i>
                                </a>
                            </div>
                        </div>
                        <div class="box-search-style1">
                            <a href="#" class="search-toggler">
                                <span class="icon-search"></span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</header>

{{-- Stricky (Yapışkan) Header --}}
<div class="stricky-header stricky-header--style1 stricked-menu main-menu">
    <div class="sticky-header__content"></div>
</div>