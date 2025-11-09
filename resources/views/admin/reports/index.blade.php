@extends('admin.layouts.app')

@section('title', 'Genel Finansal Rapor')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Genel Finansal Rapor (Kasa Defteri)</h4>
            </div>
            <div class="card-body">
                <p class="text-muted">Platformdaki tüm onaylanmış para giriş, çıkış ve komisyon giderlerinin dökümü.</p>
                
                {{-- İstatistik Kartları --}}
                <div class="row">
                    {{-- 1. Kart: Toplam Yatırılan --}}
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-animate bg-success-subtle border-0">
                            <div class="card-body">
                                <h5 class="text-success mb-0">Toplam Yatırılan (Onaylı)</h5>
                                <p class="mb-0 text-success-emphasis small">(Sadece Müşteri Yatırımları)</p>
                                <h4 class="mt-2 ff-secondary text-success">+ {{ number_format($stats['total_deposits_approved'], 2, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                    {{-- 2. Kart: Toplam Çekilen --}}
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-animate bg-danger-subtle border-0">
                            <div class="card-body">
                                {{-- GÜNCELLEME: Açıklama eklendi --}}
                                <h5 class="text-danger mb-0">Toplam Çekilen (Onaylı)</h5>
                                <p class="mb-0 text-danger-emphasis small">(Sadece Müşteri Çekimleri)</p>
                                <h4 class="mt-2 ff-secondary text-danger">- {{ number_format($stats['total_withdrawals_approved'], 2, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                    {{-- 3. Kart: Toplam Komisyon Gideri --}}
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-animate bg-danger-subtle border-0">
                            <div class="card-body">
                                {{-- GÜNCELLEME: Açıklama eklendi --}}
                                <h5 class="text-danger mb-0">Toplam Komisyon Gideri</h5>
                                <p class="mb-0 text-danger-emphasis small">(Sadece Bayi Kazançları)</p>
                                <h4 class="mt-2 ff-secondary text-danger">- {{ number_format($stats['total_commissions_paid'], 2, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                    {{-- 4. Kart: Net Bakiye (Kasa) --}}
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-animate bg-primary-subtle border-0">
                            <div class="card-body">
                                <h5 class="text-primary mb-0">Net Bakiye (Kasa)</h5>
                                <p class="mb-0 text-primary-emphasis small">(Onaylanmış Girişler - Çıkışlar - Komisyonlar)</p>
                                <h4 class="mt-2 ff-secondary text-primary">{{ number_format($stats['net_balance'], 2, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- 5. Kart: Bekleyen Ödemeler (Giriş) --}}
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-animate bg-warning-subtle border-0">
                            <div class="card-body">
                                <h5 class="text-warning mb-0">Bekleyen Ödemeler (Giriş)</h5>
                                <p class="mb-0 text-warning-emphasis small">(Onay Bekleyen Müşteri Ödemeleri)</p>
                                <h4 class="mt-2 ff-secondary text-warning">{{ number_format($stats['total_pending_deposits'], 2, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                    {{-- 6. Kart: Bekleyen Çekimler (Çıkış) --}}
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-animate bg-warning-subtle border-0">
                            <div class="card-body">
                                <h5 class="text-warning mb-0">Bekleyen Çekimler (Pending)</h5>
                                <p class="mb-0 text-warning-emphasis small">(Müşteri/Bayi Talepleri)</p>
                                <h4 class="mt-2 ff-secondary text-warning">{{ number_format($stats['total_pending_withdrawals'], 2, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                    {{-- 7. Kart: Süreçteki Çekimler --}}
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-animate bg-info-subtle border-0">
                            <div class="card-body">
                                <h5 class="text-info mb-0">Süreçteki Çekimler (Processing)</h5>
                                <p class="mb-0 text-info-emphasis small">(Ödemesi Gönderilen Talepler)</p>
                                <h4 class="mt-2 ff-secondary text-info">{{ number_format($stats['total_processing_withdrawals'], 2, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                    {{-- 8. Kart: Toplam Kullanıcı Bakiyesi (Borç) --}}
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-animate bg-dark-subtle border-0">
                            <div class="card-body">
                                <h5 class="text-dark mb-0">Tüm Kullanıcı Bakiyeleri</h5>
                                <p class="mb-0 text-dark-emphasis small">(Kasanın Toplam Borcu)</p>
                                <h4 class="mt-2 ff-secondary text-dark">{{ number_format($stats['total_user_balance_liability'], 2, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- İşlem Listesi (Değişiklik yok) --}}
                <div class="table-responsive mt-3">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Tarih</th>
                                <th scope="col">İşlem Tipi</th>
                                <th scope="col">Açıklama</th>
                                <th scope="col" class="text-end">Tutar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $tx)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($tx->date)->format('d.m.Y H:i') }}</td>
                                    <td>
                                        @if($tx->type == 'Ödeme (Giriş)')
                                            <span class="badge bg-success-subtle text-success">{{ $tx->type }}</span>
                                        @elseif($tx->type == 'Çekim (Çıkış)')
                                            <span class="badge bg-danger-subtle text-danger">{{ $tx->type }}</span>
                                        @elseif($tx->type == 'Komisyon (Gider)')
                                            <span class="badge bg-danger-subtle text-danger">{{ $tx->type }}</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary">{{ $tx->type }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $tx->description }}</td>
                                    <td class="text-end fw-semibold">
                                        @if($tx->amount > 0)
                                            <span class="text-success">+ {{ number_format($tx->amount, 2, ',', '.') }}</span>
                                        @else
                                            <span class="text-danger">{{ number_format($tx->amount, 2, ',', '.') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-3">Henüz onaylanmış bir işlem bulunmuyor.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                 <div class="mt-3">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection