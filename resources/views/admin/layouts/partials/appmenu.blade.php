<!-- LOGO -->
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
            {{-- 1. ADMİN MENÜSÜ (role == 2) --}}
            {{-- =================================================== --}}
            @if(Auth::user()->isAdmin())

 {{-- Finansal Yönetim --}}
                <li class="menu-title"><span data-key="t-menu">FİNANSAL Yönetim</span></li>
                 <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.payments*') ? 'active' : '' }}" href="{{ route('admin.payments.index') }}">
                        <i class="ri-wallet-line"></i> <span data-key="t-payments">Ödeme Yönetimi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.withdrawals*') ? 'active' : '' }}" href="{{ route('admin.withdrawals.index') }}">
                        <i class="ri-hand-coin-line"></i> <span data-key="t-withdrawals">Çekim Talepleri</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.financial.report') ? 'active' : '' }}" href="{{ route('admin.financial.report') }}">
                        <i class="ri-book-read-line"></i> <span data-key="t-financial-report">Genel Hesap Dökümü</span>
                    </a>
                </li>


                <li class="menu-title"><span data-key="t-menu">SİTE Yönetimi</span></li>
              
                {{-- Mevcut Admin Linkleri --}}
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->is('admin/categories*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                        <i class="mdi mdi-tag-outline"></i> <span data-key="t-widgets">Blog Kategorileri</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->is('admin/galleries*') ? 'active' : '' }}" href="{{ route('admin.galleries.index') }}">
                        <i class="mdi mdi-image"></i> <span data-key="t-widgets">Galeri</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->is('admin/blogs*') ? 'active' : '' }}" href="{{ route('admin.blogs.index') }}">
                        <i class="mdi mdi-newspaper"></i> <span data-key="t-widgets">Blog</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.abouts.index') ? 'active' : '' }}" href="{{ route('admin.abouts.index') }}">
                        <i class="mdi mdi-information-outline"></i> <span data-key="t-widgets">Hakkımızda</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}" href="{{ route('admin.services.index') }}">
                        <i class="mdi mdi-toolbox-outline"></i> <span data-key="t-widgets">Hizmetler</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}" href="{{ route('admin.projects.index') }}">
                        <i class="mdi mdi-briefcase-variant-outline"></i> <span data-key="t-widgets">Projeler</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.authors.*') ? 'active' : '' }}" href="{{ route('admin.authors.index') }}">
                        <i class="mdi mdi-account-tie"></i> <span data-key="t-widgets">Köşe Yazarları</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                        <i class="mdi mdi-cog"></i> <span data-key="t-widgets">Ayarlar</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.slides.*') ? 'active' : '' }}" href="{{ route('admin.slides.index') }}">
                        <i class="mdi mdi-image-multiple-outline"></i> <span data-key="t-widgets">Slide Yönetimi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.references.*') ? 'active' : '' }}" href="{{ route('admin.references.index') }}">
                        <i class="mdi mdi-account-group"></i> <span data-key="t-widgets">Referans Yönetimi</span>
                    </a>
                </li>

               

                {{-- Sistem --}}
                <li class="menu-title"><span data-key="t-menu">Sistem</span></li>
                <li class="nav-item">
                <a class="nav-link menu-link {{ request()->routeIs('admin.deposit_methods.index') ? 'active' : '' }}" href="{{ route('admin.deposit_methods.index') }}">
                    <i class="ri-add-box-line"></i> <span data-key="t-deposit-methods">Yatırım Hesapları (Şirket)</span>
                </a>
            </li>
                <li class="nav-item">
                <a class="nav-link menu-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <i class="ri-user-settings-line"></i> <span data-key="t-users">Kullanıcı Yönetimi</span>
                </a>
            </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                        <i class="ri-settings-4-line"></i> <span data-key="t-settings">Genel Ayarlar</span>
                    </a>
                </li>
                <li class="nav-item">
                <a class="nav-link menu-link {{ request()->routeIs('admin.password_requests.index') ? 'active' : '' }}" href="{{ route('admin.password_requests.index') }}">
                    <i class="ri-lock-password-line"></i> <span data-key="t-pass-requests">Şifre Talepleri</span>
                    {{-- YENİ: Menü Rozeti --}}
                    @php
                        // Sadece 'NewPasswordRequestNotification' tipindeki okunmamışları say
                        $passRequestCount = Auth::user()->unreadNotifications
                            ->where('type', 'App\Notifications\NewPasswordRequestNotification')
                            ->count();
                    @endphp
                    
                    @if($passRequestCount > 0)
                        <span class="badge badge-pill bg-danger ms-2" data-key="t-new">{{ $passRequestCount }}</span>
                    @endif
                </a>
            </li>
                {{-- Not: Buraya 'Kullanıcı Yönetimi' ve 'Bayi Yönetimi' linkleri eklenebilir --}}


            {{-- =================================================== --}}
            {{-- 2. BAYİ MENÜSÜ (role == 1) --}}
            {{-- =================================================== --}}
            @elseif(Auth::user()->isBayi())
           {{-- PASİFE ALINDI (Şirket İsteği)
                <li class="nav-item">
                    <a class="text-decoration-none" href="{{ route('admin.profile.statement') }}">
                        <div class="card bg-primary-subtle border-0 mx-2 mt-2">
                            <div class="card-body p-3">
                                <h6 class="text-primary-emphasis mb-1">Mevcut Bakiye</h6>
                                <h5 class="text-primary-emphasis mb-0">
                                    {{ number_format(Auth::user()->balance, 2, ',', '.') }}
                                </h5>
                            </div>
                        </div>
                    </a>
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
              {{-- GÜNCELLEME: Komisyon Raporu Pasife Alındı --}}
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
                {{-- Not: Bayi buraya tıklar ve ref linkini görür --}}
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.profile.index') ? 'active' : '' }}" href="{{ route('admin.profile.index') }}">
                        <i class="ri-user-settings-line"></i> <span data-key="t-profile">Hesap Bilgileri</span>
                    </a>
                </li>


            {{-- =================================================== --}}
            {{-- 3. MÜŞTERİ MENÜSÜ (role == 0) --}}
            {{-- =================================================== --}}
            @elseif(Auth::user()->isCustomer())
           {{-- GÜNCELLEME: ŞİRKET İSTEĞİ ÜZERİNE BU BLOK PASİFE ALINDI --}}
                {{--
                <li class="nav-item">
                    <a class="text-decoration-none" href="{{ route('admin.profile.statement') }}">
                        <div class="card bg-success-subtle border-0 mx-2 mt-2">
                            <div class="card-body p-3">
                                <h6 class="text-success-emphasis mb-1">Mevcut Bakiye</h6>
                                <h5 class="text-success-emphasis mb-0">
                                    {{ number_format(Auth::user()->balance, 2, ',', '.') }}
                                </h5>
                            </div>
                        </div>
                    </a>
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