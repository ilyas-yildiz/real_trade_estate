<header class="main-header main-header-style1">

    <div class="main-header-style1__content">
        <div class="container">
            <div class="main-header-style1__content-inner">
                <div class="main-header-style1__content-top">
                    <div class="main-header-style1__content-top-left">
                        <div class="header-logo-box-style1">
                            <a href="{{ route('frontend.home') }}">
                                {{-- Logo'yu ileride $settings'den çekebiliriz, şimdilik statik --}}
                                <img src="{{ asset('frontend/assets/images/resources/logo-1.png') }}" alt="Logo" title="Tradebro">
                            </a>
                        </div>
                        {{-- Opsiyonel: Trading saatleri - Şimdilik statik --}}
                        <div class="header-trading-time-style1">
                            <div class="icon">
                                <i class="icon-hour"></i>
                            </div>
                            <div class="text">
                                <p><span>Stock:</span> 9.30 am to 4.00 pm</p>
                                {{-- Detaylı saatler (hover) - statik kalabilir --}}
                            </div>
                        </div>
                    </div>

                    <div class="main-header-style1__content-top-middle">
                        {{-- Opsiyonel: Clients/Partners butonları - Şimdilik statik --}}
                        <div class="btn-box">
                            <a class="btn-one active" href="#">
                                <span class="txt">Clients</span>
                            </a>
                            <a class="btn-one" href="#">
                                <span class="txt">Partners</span>
                            </a>
                        </div>
                    </div>

                    <div class="main-header-style1__content-top-right">
                        {{-- Login/Register Linkleri --}}
                        <div class="header-login-register-style1">
                            <div class="icon">
                                <span class="icon-lock"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span>
                                </span>
                            </div>
                            <div class="title">
                                <h3>My Portal</h3>
                                {{-- Auth Kontrolü --}}
                                @guest
                                    <p><a href="{{ route('login') }}">Login</a> - or - <a href="{{ route('register') }}">Register</a></p>
                                @endguest
                                @auth
                                    <p><a href="{{ route('admin.dashboard') }}">Hesabım</a> - (<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-frontend').submit();">Çıkış Yap</a>)</p>
                                    <form id="logout-form-frontend" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                @endauth
                                {{-- Hover detayları (statik kalabilir) --}}
                            </div>
                        </div>
                        {{-- Opsiyonel: Yardım Merkezi - Şimdilik statik --}}
                        <div class="header-help-center-style1">
                            {{-- ... (Yardım merkezi içeriği) ... --}}
                        </div>
                    </div>
                </div>

                <div class="main-header-style1__content-bottom">
                    <div class="main-header-style1__content-bottom-left">
                        <!--Start Main Menu Style1-->
                        <nav class="main-menu main-menu-style1">
                            <div class="main-menu__wrapper clearfix">
                                <div class="main-menu__wrapper-inner">
                                    <div class="sticky-logo-box-style1">
                                        <a href="{{ route('frontend.home') }}">
                                            <img src="{{ asset('frontend/assets/images/resources/logo-1.png') }}" alt="Logo" title="Tradebro">
                                        </a>
                                    </div>
                                    <div class="main-menu-style1__left">
                                        <div class="main-menu-box">
                                            <a href="#" class="mobile-nav__toggler">
                                                <i class="fa fa-bars"></i>
                                            </a>

                                            <ul class="main-menu__list">
                                                {{-- Dinamik Menü Linkleri --}}
                                                <li class="{{ request()->routeIs('frontend.home') ? 'current' : '' }}">
                                                    <a href="{{ route('frontend.home') }}">Anasayfa</a>
                                                </li>
                                                <li class="{{ request()->routeIs('frontend.about') ? 'current' : '' }}">
                                                    <a href="{{ route('frontend.about') }}">Hakkımızda</a>
                                                </li>
                                                <li class="{{ request()->routeIs('frontend.services*') ? 'current' : '' }}">
                                                    <a href="{{ route('frontend.services') }}">Hizmetler</a>
                                                </li>
                                                 <li class="{{ request()->routeIs('frontend.projects*') ? 'current' : '' }}">
                                                    <a href="{{ route('frontend.projects') }}">Projeler</a>
                                                </li>
                                                <li class="{{ request()->routeIs('frontend.blog*') ? 'current' : '' }}">
                                                    <a href="{{ route('frontend.blog.index') }}">Blog</a>
                                                </li>
                                                <li class="{{ request()->routeIs('frontend.contact') ? 'current' : '' }}">
                                                    <a href="{{ route('frontend.contact') }}">İletişim</a>
                                                </li>
                                                {{-- 
                                                    Temadaki orijinal çok seviyeli (dropdown) menü yapısı 
                                                    ihtiyaç duyulursa buraya eklenebilir, şimdilik basit tuttum.
                                                --}}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </nav>
                        <!--End Main Menu Style1-->
                    </div>

                    <div class="main-header-style1__content-bottom-right">
                        {{-- Dil Seçici (Statik) --}}
                        <div class="language-switcher-style1">
                            <div class="icon">
                                <i class="icon-language"></i>
                            </div>
                            <div class="select-box clearfix">
                                <select class="wide">
                                    <option data-display="TR">TR</option>
                                    <option value="1">EN</option>
                                </select>
                            </div>
                        </div>
                        {{-- Başlangıç Butonu (Statik) --}}
                        <div class="header-btn-box-style1">
                            <div class="icon">
                                <i class="icon-candle"></i>
                            </div>
                            <div class="text">
                                <a href="{{ route('register') }}">
                                    İşleme <br>Başla
                                    <i class="icon-right-arrow"></i>
                                </a>
                            </div>
                        </div>
                        {{-- Arama Butonu (Statik) --}}
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
