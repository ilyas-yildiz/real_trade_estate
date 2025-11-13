<div class="layout-width">
    <div class="navbar-header">
        <div class="d-flex">
            <div class="navbar-brand-box horizontal-logo">
                <a href="javascript:void(0);" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ asset('admin/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('admin/images/logo-dark.png') }}" alt="" height="17">
                    </span>
                </a>

                <a href="{{ url('/') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset('admin/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset('admin/images/logo-light.png') }}" alt="" height="17">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none" id="topnav-hamburger-icon">
                <span class="hamburger-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>

            <form class="app-search d-none d-md-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search..." autocomplete="off" id="search-options" value="">
                    <span class="mdi mdi-magnify search-widget-icon"></span>
                    <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none" id="search-close-options"></span>
                </div>
            </form>
        </div>

        <div class="d-flex align-items-center">

            {{-- Dil Seçici vb. (Aynı kaldı) --}}
          <div class="dropdown d-md-none topbar-head-dropdown header-item">
                <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-search fs-22"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown ms-1 topbar-head-dropdown header-item">
                <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img id="header-lang-img" src="{{ asset('admin/images/flags/us.svg') }}" alt="Header Language" height="20" class="rounded">
                </button>
                <div class="dropdown-menu dropdown-menu-end">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item language py-2" data-lang="en" title="English">
                        <img src="{{ asset('admin/images/flags/us.svg') }}" alt="user-image" class="me-2 rounded" height="18">
                        <span class="align-middle">English</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="sp" title="Spanish">
                        <img src="{{ asset('admin/images/flags/spain.svg') }}" alt="user-image" class="me-2 rounded" height="18">
                        <span class="align-middle">Española</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="gr" title="German">
                        <img src="{{ asset('admin/images/flags/germany.svg') }}" alt="user-image" class="me-2 rounded" height="18"> <span class="align-middle">Deutsche</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="it" title="Italian">
                        <img src="{{ asset('admin/images/flags/italy.svg') }}" alt="user-image" class="me-2 rounded" height="18">
                        <span class="align-middle">Italiana</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="ru" title="Russian">
                        <img src="{{ asset('admin/images/flags/russia.svg') }}" alt="user-image" class="me-2 rounded" height="18">
                        <span class="align-middle">русский</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="ch" title="Chinese">
                        <img src="{{ asset('admin/images/flags/china.svg') }}" alt="user-image" class="me-2 rounded" height="18">
                        <span class="align-middle">中国人</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="fr" title="French">
                        <img src="{{ asset('admin/images/flags/french.svg') }}" alt="user-image" class="me-2 rounded" height="18">
                        <span class="align-middle">français</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item language" data-lang="ar" title="Arabic">
                        <img src="{{ asset('admin/images/flags/ae.svg') }}" alt="user-image" class="me-2 rounded" height="18">
                        <span class="align-middle">Arabic</span>
                    </a>
                </div>
            </div>

            <div class="ms-1 header-item d-none d-sm-flex">
                <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" data-toggle="fullscreen">
                    <i class='bx bx-fullscreen fs-22'></i>
                </button>
            </div>

            <div class="ms-1 header-item d-none d-sm-flex">
                <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode shadow-none">
                    <i class='bx bx-moon fs-22'></i>
                </button>
            </div>

            {{-- =================================================== --}}
            {{-- YENİ: BİLDİRİM ZARFI (Notification Dropdown) --}}
            {{-- =================================================== --}}
            <div class="dropdown topbar-head-dropdown ms-1 header-item">
                <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class='bx bx-bell fs-22'></i>
                    @if(Auth::user()->unreadNotifications->count() > 0)
                        <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">
                            {{ Auth::user()->unreadNotifications->count() }}
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">

                    <div class="dropdown-head bg-primary bg-pattern rounded-top">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0 fs-16 fw-semibold text-white"> Bildirimler </h6>
                                </div>
                                <div class="col-auto dropdown-tabs">
                                    <a href="{{ route('admin.notifications.readAll') }}" class="badge bg-light-subtle text-body fs-13 me-1">Tümünü Oku</a>
                                    <span class="badge bg-light-subtle text-body fs-13"> {{ Auth::user()->unreadNotifications->count() }} Yeni</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-content" id="notificationItemsTabContent">
                        <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                            <div data-simplebar style="max-height: 300px;" class="pe-2">
                                
                                @forelse(Auth::user()->unreadNotifications as $notification)
                                    <div class="text-reset notification-item d-block dropdown-item position-relative">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-{{ $notification->data['color'] ?? 'primary' }}-subtle text-{{ $notification->data['color'] ?? 'primary' }} rounded-circle fs-16">
                                                    <i class="{{ $notification->data['icon'] ?? 'bx bx-message-square-dots' }}"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                    <a href="{{ route('admin.notifications.read', $notification->id) }}" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-13 fw-semibold">{{ $notification->data['message'] }}</h6>
                                                </a>
                                                <div class="fs-13 text-muted">
                                                    <p class="mb-1">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                            <div class="px-2 fs-15">
                                                {{-- Okundu olarak işaretle butonu (JS gerektirir, şimdilik basit) --}}
                                                {{-- <a href="#" class="text-success"><i class="ri-checkbox-circle-line"></i></a> --}}
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="w-25 w-sm-50 pt-3 mx-auto">
                                        <img src="{{ asset('admin/images/svg/bell.svg') }}" class="img-fluid" alt="user-pic">
                                    </div>
                                    <div class="text-center pb-5 mt-2">
                                        <h6 class="fs-18 fw-semibold lh-base">Hiç bildiriminiz yok.</h6>
                                    </div>
                                @endforelse

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- BİLDİRİM ZARFI SONU --}}


            <div class="dropdown ms-sm-3 header-item topbar-user">
                <button type="button" class="btn shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="d-flex align-items-center">
                        <img class="rounded-circle header-profile-user" src="{{ asset('admin/images/users/avatar-3.jpg') }}" alt="Header Avatar">
                        <span class="text-start ms-xl-2">
                            <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ Auth::user()->name }}</span>
                            <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">Real Trade Estate</span>
                        </span>
                    </span>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <h6 class="dropdown-header">Hoş Geldin {{ Auth::user()->name }}</h6>
                    <a class="dropdown-item" href="{{ route('admin.profile.index') }}"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profil</span></a>
                    
                    {{-- GÜNCELLEME: Mesajlar -> Bildirimler ve Link Eklendi --}}
<a class="dropdown-item" href="{{ route('admin.notifications.index') }}">
    <i class="mdi mdi-bell-outline text-muted fs-16 align-middle me-1"></i> 
    <span class="align-middle">Bildirimler</span>
    @if(Auth::user()->unreadNotifications->count() > 0)
        <span class="badge bg-danger rounded-pill ms-1">{{ Auth::user()->unreadNotifications->count() }}</span>
    @endif
</a>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('admin.settings.index') }}"><span class="badge bg-success-subtle text-success mt-1 float-end">New</span><i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Ayarlar</span></a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                        <span class="align-middle" data-key="t-logout">Çıkış Yap</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>