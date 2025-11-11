@extends('admin.layouts.app')

@section('title', 'Hesap Dökümü')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Hesap Dökümü</h4>
            </div>
            <div class="card-body">
                <p class="text-muted">Tüm onaylanmış bakiye giriş ve çıkışlarınızın listesi.</p>
                
             {{-- 
                   {{-- Toplamlar Kartı --}}
                <div class="row mb-3">
                    @if(Auth::user()->isCustomer())
                        {{-- Müşteri Toplamları --}}
                        <div class="col-md-4">
                            <div class="card card-animate bg-success-subtle border-0">
                                <div class="card-body">
                                    <h5 class="text-success">Toplam Yatırılan</h5>
                                    <h3 class="mb-0 text-success">+ {{ number_format($totalDeposits, 2, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-animate bg-danger-subtle border-0">
                                <div class="card-body">
                                    <h5 class="text-danger">Toplam Çekilen</h5>
                                    <h3 class="mb-0 text-danger">- {{ number_format($totalWithdrawals, 2, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-animate bg-primary-subtle border-0">
                                <div class="card-body">
                                    <h5 class="text-primary">Mevcut Bakiye</h5>
                                    <h3 class="mb-0 text-primary">{{ number_format(Auth::user()->balance, 2, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>
                    @elseif(Auth::user()->isBayi())
                        {{-- Bayi Toplamları --}}
                        <div class="col-md-4">
                            <div class="card card-animate bg-success-subtle border-0">
                                <div class="card-body">
                                    <h5 class="text-success">Toplam Komisyon Kazancı</h5>
                                    <h3 class="mb-0 text-success">+ {{ number_format($totalCommissions, 2, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-animate bg-danger-subtle border-0">
                                <div class="card-body">
                                    <h5 class="text-danger">Toplam Çekilen</h5>
                                    <h3 class="mb-0 text-danger">- {{ number_format($totalWithdrawals, 2, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-animate bg-primary-subtle border-0">
                                <div class="card-body">
                                    <h5 class="text-primary">Mevcut Bakiye</h5>
                                    <h3 class="mb-0 text-primary">{{ number_format(Auth::user()->balance, 2, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                --}}

                {{-- İşlem Listesi --}}
                <div class="table-responsive">
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
                                        @if($tx->type == 'Yatırma')
                                            <span class="badge bg-success-subtle text-success">{{ $tx->type }}</span>
                                        @elseif($tx->type == 'Komisyon Kazancı')
                                            <span class="badge bg-success-subtle text-success">{{ $tx->type }}</span>
                                        @elseif($tx->type == 'Çekim Talebi')
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
                                <tr><td colspan="4" class="text-center text-muted py-3">Henüz onaylanmış bir işleminiz bulunmuyor.</td></tr>
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