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

<div id="scrollbar" class="position-relative">
    <div class="container-fluid">

        <div id="two-column-menu"></div>
        <ul class="navbar-nav" id="navbar-nav">

            <!-- === BÖLÜM 1: TÜM KULLANICILAR (Üye ve Admin) === -->
            <li class="menu-title"><span data-key="t-menu">Kullanıcı Menüsü</span></li>
            <li class="nav-item">
                <a class="nav-link menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="mdi mdi-home"></i> <span data-key="t-widgets">Anasayfa</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link menu-link {{ request()->routeIs('admin.profile.index') ? 'active' : '' }}" href="{{ route('admin.profile.index') }}">
                    <i class="mdi mdi-account-cog"></i> <span data-key="t-profile">Profilim</span>
                </a>
            </li>
            {{-- YENİ EKLENDİ: Yeni Ödeme Bildirimi Linki --}}
            {{-- Not: Sadece admin olmayanlar bu linki görmeli --}}
            @if(!Auth::user()->is_admin)
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.payments.create') ? 'active' : '' }}" href="{{ route('admin.payments.create') }}">
                        <i class="ri-upload-cloud-2-line"></i> <span data-key="t-payment-create">Yeni Ödeme Bildirimi</span>
                    </a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.payments.index') ? 'active' : '' }}" href="{{ route('admin.payments.index') }}">
                        <i class="ri-list-check-3"></i> <span data-key="t-payment-index">Ödeme Bildirimlerim</span>
                    </a>
                </li>
            @endif


            <!-- === BÖLÜM 2: SADECE ADMİNLER === -->
            @if(Auth::user()->is_admin)
                <li class="menu-title"><span data-key="t-menu">Admin Yönetimi</span></li>
                {{-- YENİ EKLENDİ: Admin için Ödeme Yönetimi Linki --}}
                 <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}" href="{{ route('admin.payments.index') }}">
                        <i class="ri-bank-card-line"></i> <span data-key="t-payment-admin">Ödeme Yönetimi</span>
                    </a>
                </li>
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
            @endif
            <!-- === ADMİN BÖLÜMÜ SONU === -->


            <!-- === BÖLÜM 3: TEKRAR TÜM KULLANICILAR === -->
            <li class="nav-item">
                <a class="nav-link menu-link" href="{{ url('/') }}" target="_blank">
                    <i class="mdi mdi-web"></i> <span data-key="t-widgets">Siteye Git</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Sidebar Footer -->
    <div class="sidebar-footer text-center text-white">
        Enderun AI CMS (V.1.1)
    </div>
</div>

<div class="sidebar-background">
</div>