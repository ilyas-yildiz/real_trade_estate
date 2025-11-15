@extends('admin.layouts.app')

@section('title', 'Bildirimler')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Tüm Bildirimler</h4>
                <div class="flex-shrink-0">
                    @if(Auth::user()->unreadNotifications->count() > 0)
                        <a href="{{ route('admin.notifications.readAll') }}" class="btn btn-soft-info btn-sm">
                            <i class="ri-check-double-line align-bottom"></i> Tümünü Okundu Say
                        </a>
                    @endif
                </div>
            </div>

            <div class="card-body">
                
                {{-- Başarı/Hata mesajları --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- =================================================== --}}
                {{-- 1. ADMİN İÇİN SEKMELİ GÖRÜNÜM --}}
                {{-- =================================================== --}}
                @if(Auth::user()->isAdmin())
                    
                    <ul class="nav nav-tabs nav-tabs-custom nav-success nav-justified mb-3" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#tab_pass" role="tab">
                                Şifre Talepleri <span class="badge badge-pill bg-danger">{{ $passwordRequests->total() }}</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab_payments" role="tab">
                                Ödeme Bildirimleri <span class="badge badge-pill bg-danger">{{ $paymentRequests->total() }}</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab_withdrawals" role="tab">
                                Çekim Talepleri <span class="badge badge-pill bg-danger">{{ $withdrawalRequests->total() }}</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#tab_users" role="tab">
                                Yeni Üyeler <span class="badge badge-pill bg-danger">{{ $newUserRequests->total() }}</span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        
                        {{-- Sekme 1: Şifre Talepleri --}}
                        <div class="tab-pane active" id="tab_pass" role="tabpanel">
                            @include('admin.notifications.partials._notification_table', ['notifications' => $passwordRequests, 'pageName' => 'pass_page'])
                        </div>

                        {{-- Sekme 2: Ödeme Bildirimleri --}}
                        <div class="tab-pane" id="tab_payments" role="tabpanel">
                             @include('admin.notifications.partials._notification_table', ['notifications' => $paymentRequests, 'pageName' => 'pay_page'])
                        </div>

                        {{-- Sekme 3: Çekim Talepleri --}}
                        <div class="tab-pane" id="tab_withdrawals" role="tabpanel">
                             @include('admin.notifications.partials._notification_table', ['notifications' => $withdrawalRequests, 'pageName' => 'withdraw_page'])
                        </div>

                        {{-- Sekme 4: Yeni Üyeler --}}
                        <div class="tab-pane" id="tab_users" role="tabpanel">
                             @include('admin.notifications.partials._notification_table', ['notifications' => $newUserRequests, 'pageName' => 'user_page'])
                        </div>
                    </div>

                {{-- =================================================== --}}
                {{-- 2. MÜŞTERİ/BAYİ İÇİN BASİT LİSTE --}}
                {{-- =================================================== --}}
                @else
                    @include('admin.notifications.partials._notification_table', ['notifications' => $notifications, 'pageName' => 'page'])
                @endif

            </div>
        </div>
    </div>
</div>
@endsection