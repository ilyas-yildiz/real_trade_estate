<!-- LOGO (Bu kısım aynı kaldı) -->
<div class="navbar-brand-box">
    <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
        <span class="logo-sm">
            <img src="{{ asset('admin/images/enderunlogodisi.png') }}" alt="" height="25">
        </span>
        <span class="logo-lg">
            <img src="{{ asset('admin/images/enderunlogodisi.png') }}" alt="" height="70">
        </span>
    </a>
    <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
        <span class="logo-sm">
            <img src="{{ asset('admin/images/enderunlogodisi.png') }}" alt="" height="25">
        </span>
        <span class="logo-lg">
            <img src="{{ asset('admin/images/enderunlogodisi.png') }}" alt="" height="70">
        </span>
    </a>
    <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
        <i class="ri-record-circle-line"></i>
    </button>
</div>

<div id="scrollbar">
    <div class="container-fluid">
        <div id="two-column-menu"></div>
        <ul class="navbar-nav" id="navbar-nav">
            
            {{-- =================================================== --}}
            {{-- 1. ADMİN MENÜSÜ (GÜNCELLENDİ) --}}
            {{-- =================================================== --}}
            @if(Auth::user()->isAdmin())

                {{-- Dashboard (Her zaman açık) --}}
                <li class="menu-title"><span data-key="t-menu">Admin Paneli</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>

                {{-- GÜNCELLEME: 1. AÇILIR MENÜ (Finansal) --}}
                <li class="nav-item">
                    {{-- 'menu-link' class'ı kalmalı, 'href' ID'yi işaret etmeli --}}
                    <a class="nav-link menu-link {{ request()->routeIs('admin.payments*') || request()->routeIs('admin.withdrawals*') || request()->routeIs('admin.financial.report') ? 'active' : '' }}" 
                       href="#sidebarFinansal" data-bs-toggle="collapse" role="button" 
                       aria-expanded="{{ request()->routeIs('admin.payments*') || request()->routeIs('admin.withdrawals*') || request()->routeIs('admin.financial.report') ? 'true' : 'false' }}" 
                       aria-controls="sidebarFinansal">
                        <i class="ri-money-dollar-box-line"></i> <span data-key="t-finansal">FİNANSAL Yönetim</span>
                    </a>
                    {{-- Açılacak menü: 'collapse menu-dropdown' ve 'id' eşleşmeli --}}
                    <div class="collapse menu-dropdown {{ request()->routeIs('admin.payments*') || request()->routeIs('admin.withdrawals*') || request()->routeIs('admin.financial.report') ? 'show' : '' }}" id="sidebarFinansal">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ request()->routeIs('admin.payments*') ? 'active' : '' }}" href="{{ route('admin.payments.index') }}">
                                    <span data-key="t-payments">Ödeme Yönetimi</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ request()->routeIs('admin.withdrawals*') ? 'active' : '' }}" href="{{ route('admin.withdrawals.index') }}">
                                    <span data-key="t-withdrawals">Çekim Talepleri</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ request()->routeIs('admin.financial.report') ? 'active' : '' }}" href="{{ route('admin.financial.report') }}">
                                    <span data-key="t-financial-report">Genel Hesap Dökümü</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- GÜNCELLEME: 2. AÇILIR MENÜ (Site Yönetimi) --}}
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->is('admin/categories*') || request()->is('admin/galleries*') || request()->is('admin/blogs*') || request()->routeIs('admin.abouts.index') || request()->routeIs('admin.services.*') || request()->routeIs('admin.projects.*') || request()->routeIs('admin.authors.*') || request()->routeIs('admin.slides.*') || request()->routeIs('admin.references.*') ? 'active' : '' }}" 
                       href="#sidebarSite" data-bs-toggle="collapse" role="button" 
                       aria-expanded="{{ request()->is('admin/categories*') || request()->is('admin/galleries*') || request()->is('admin/blogs*') || request()->routeIs('admin.abouts.index') || request()->routeIs('admin.services.*') || request()->routeIs('admin.projects.*') || request()->routeIs('admin.authors.*') || request()->routeIs('admin.slides.*') || request()->routeIs('admin.references.*') ? 'true' : 'false' }}" 
                       aria-controls="sidebarSite">
                        <i class="ri-global-line"></i> <span data-key="t-site">SİTE Yönetimi</span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->is('admin/categories*') || request()->is('admin/galleries*') || request()->is('admin/blogs*') || request()->routeIs('admin.abouts.index') || request()->routeIs('admin.services.*') || request()->routeIs('admin.projects.*') || request()->routeIs('admin.authors.*') || request()->routeIs('admin.slides.*') || request()->routeIs('admin.references.*') ? 'show' : '' }}" id="sidebarSite">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ request()->is('admin/categories*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                                    <span data-key="t-widgets">Blog Kategorileri</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ request()->is('admin/galleries*') ? 'active' : '' }}" href="{{ route('admin.galleries.index') }}">
                                    <span data-key="t-widgets">Galeri</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ request()->is('admin/blogs*') ? 'active' : '' }}" href="{{ route('admin.blogs.index') }}">
                                    <span data-key="t-widgets">Blog</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ request()->routeIs('admin.abouts.index') ? 'active' : '' }}" href="{{ route('admin.abouts.index') }}">
                                    <span data-key="t-widgets">Hakkımızda</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}" href="{{ route('admin.services.index') }}">
                                    <span data-key="t-widgets">Hizmetler</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}" href="{{ route('admin.projects.index') }}">
                                    <span data-key="t-widgets">Projeler</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ request()->routeIs('admin.authors.*') ? 'active' : '' }}" href="{{ route('admin.authors.index') }}">
                                    <span data-key="t-widgets">Köşe Yazarları</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ request()->routeIs('admin.slides.*') ? 'active' : '' }}" href="{{ route('admin.slides.index') }}">
                                    <span data-key="t-widgets">Slide Yönetimi</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ request()->routeIs('admin.references.*') ? 'active' : '' }}" href="{{ route('admin.references.index') }}">
                                    <span data-key="t-widgets">Referans Yönetimi</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- GÜNCELLEME: 3. AÇILIR MENÜ (Sistem) --}}
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.deposit_methods.index') || request()->routeIs('admin.users*') || request()->routeIs('admin.settings*') || request()->routeIs('admin.password_requests.index') ? 'active' : '' }}" 
                       href="#sidebarSistem" data-bs-toggle="collapse" role="button" 
                       aria-expanded="{{ request()->routeIs('admin.deposit_methods.index') || request()->routeIs('admin.users*') || request()->routeIs('admin.settings*') || request()->routeIs('admin.password_requests.index') ? 'true' : 'false' }}" 
                       aria-controls="sidebarSistem">
                        <i class="ri-settings-2-line"></i> <span data-key="t-sistem">Sistem</span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('admin.deposit_methods.index') || request()->routeIs('admin.users*') || request()->routeIs('admin.settings*') || request()->routeIs('admin.password_requests.index') ? 'show' : '' }}" id="sidebarSistem">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ request()->routeIs('admin.deposit_methods.index') ? 'active' : '' }}" href="{{ route('admin.deposit_methods.index') }}">
                                    <span data-key="t-deposit-methods">Yatırım Hesapları (Şirket)</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                    <span data-key="t-users">Kullanıcı Yönetimi</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                                    <span data-key="t-settings">Genel Ayarlar</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link menu-link {{ request()->routeIs('admin.password_requests.index') ? 'active' : '' }}" href="{{ route('admin.password_requests.index') }}">
                                    <span data-key="t-pass-requests">Şifre Talepleri</span>
                                    @php
                                        $passRequestCount = Auth::user()->unreadNotifications
                                            ->where('type', 'App\Notifications\NewPasswordRequestNotification')
                                            ->count();
                                    @endphp
                                    @if($passRequestCount > 0)
                                        <span class="badge badge-pill bg-danger ms-2" data-key="t-new">{{ $passRequestCount }}</span>
                                    @endif
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>


            {{-- =================================================== --}}
            {{-- 2. BAYİ MENÜSÜ (Aynı Kaldı) --}}
            {{-- =================================================== --}}
            @elseif(Auth::user()->isBayi())
                
                {{-- PASİFE ALINDI (Şirket İsteği) --}}
                {{--
                <li class="nav-item">
                    ... (Bakiye Kartı) ...
                </li>
                --}}

                <li class="menu-title"><span data-key="t-menu">IB Paneli</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('bayi.dashboard') ? 'active' : '' }}" href="{{ route('bayi.dashboard') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboard">IB Dashboard</span>
                    </a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('bayi.customers') ? 'active' : '' }}" href="{{ route('bayi.customers') }}">
                        <i class="ri-team-line"></i> <span data-key="t-customers">Müşterilerim</span>
                    </a>
                </li>
                
                <li class="menu-title"><span data-key="t-menu">Finansal Raporlar</span></li>
                
                {{-- Komisyon Raporu Pasife Alındı --}}
                {{--
                 <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('bayi.commissions') ? 'active' : '' }}" href="{{ route('bayi.commissions') }}">
                        <i class="ri-pie-chart-line"></i> <span data-key="t-commissions">Komisyon Raporum</span>
                    </a>
                </li>
                --}}
                
                 <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('bayi.withdrawals') ? 'active' : '' }}" href="{{ route('bayi.withdrawals') }}">
                        <i class="ri-line-chart-line"></i> <span data-key="t-reports">Müşteri Çekim Raporu</span>
                    </a>
                </li>

                <li class="menu-title"><span data-key="t-menu">Kişisel İşlemler</span></li>
                
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.deposit_methods.show_page') ? 'active' : '' }}" href="{{ route('admin.deposit_methods.show_page') }}">
                        <i class="ri-question-line"></i> <span data-key="t-how-to-deposit">Nasıl Para Yollanır?</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.withdrawals*') ? 'active' : '' }}" href="{{ route('admin.withdrawals.index') }}">
                        <i class="ri-hand-coin-line"></i> <span data-key="t-my-withdrawals">Çekim Taleplerim</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.profile.index') ? 'active' : '' }}" href="{{ route('admin.profile.index') }}">
                        <i class="ri-user-settings-line"></i> <span data-key="t-profile">Hesap Bilgileri</span>
                    </a>
                </li>


            {{-- =================================================== --}}
            {{-- 3. MÜŞTERİ MENÜSÜ (Aynı Kaldı) --}}
            {{-- =================================================== --}}
            @elseif(Auth::user()->isCustomer())
                
                {{-- Bakiye Pasife Alındı --}}
                {{--
                <li class="nav-item">
                   ... (Bakiye Kartı) ...
                </li>
                --}}
                
                <li class="menu-title"><span data-key="t-menu">Müşteri Paneli</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.profile.index') ? 'active' : '' }}" href="{{ route('admin.profile.index') }}">
                        <i class="ri-bank-card-line"></i> <span data-key="t-profile">Ödeme Hesaplarım</span>
                    </a>
                </li>

                <li class="menu-title"><span data-key="t-menu">Finansal İşlemler</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.deposit_methods.show_page') ? 'active' : '' }}" href="{{ route('admin.deposit_methods.show_page') }}">
                        <i class="ri-question-line"></i> <span data-key="t-how-to-deposit">Nasıl Para Yollanır?</span>
                    </a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.payments*') ? 'active' : '' }}" href="{{ route('admin.payments.index') }}">
                        <i class="ri-wallet-line"></i> <span data-key="t-payments">Ödeme Bildirimlerim</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.withdrawals*') ? 'active' : '' }}" href="{{ route('admin.withdrawals.index') }}">
                        <i class="ri-hand-coin-line"></i> <span data-key="t-withdrawals">Çekim Taleplerim</span>
                    </a>
                </li>
            @endif

        </ul>
    </div>
</div>