@extends('admin.layouts.app') {{-- Admin layout'unu kullanıyoruz --}}

@section('title', 'Bayi Paneli')

@section('content')
<div class="row">
    <div class="col">
        <div class="h-100">
            <div class="row mb-3 pb-1">
                <div class="col-12">
                    <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                        <div class="flex-grow-1">
                            <h4 class="fs-16 mb-1">Hoş Geldiniz, {{ Auth::user()->name }}!</h4>
                            <p class="text-muted mb-0">Bayi panelinize hoş geldiniz.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <p class="text-muted">Toplam Müşteri Sayınız</p>
                            <h3 class="mb-0">{{ $customerCount }}</h3>
                        </div>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="card card-animate">
                        <div class="card-body">
                            <p class="text-muted">Müşteri Çekim Toplamı (Onaylanan)</p>
                            <h3 class="mb-0">{{ number_format($totalWithdrawals, 2, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection