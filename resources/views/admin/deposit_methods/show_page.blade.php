@extends('admin.layouts.app')

@section('title', 'Nasıl Para Yollanır?')

{{-- YENİ: Kopyalama bildirimi (iziToast) için CSS eklendi --}}
@push('izitoastcss')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Nasıl Para Yollanır?</h4>
            </div>
            <div class="card-body">
                <p class="text-muted">Yatırım yapmak için aşağıdaki şirket hesaplarımızı kullanabilirsiniz. Yatırım yaptıktan sonra, <a href="{{ route('admin.payments.create') }}">Ödeme Bildirim Formu</a>'nu doldurmayı unutmayın.</p>
            </div>
        </div>
    </div>
</div>

{{-- Kripto Cüzdanları Listesi --}}
@if($cryptoWallets->isNotEmpty())
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0 text-primary">Kripto Cüzdanlarımız (Önerilen)</h5></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                         <thead> <tr> <th>Tip (Coin)</th> <th>Ağ (Network)</th> <th>Cüzdan Adresi</th> <th>Notlar</th> </tr> </thead>
                        <tbody>
                             @foreach ($cryptoWallets as $wallet)
                                <tr>
                                    <td><span class="fw-semibold">{{ $wallet->wallet_type }}</span></td>
                                    <td><span class="badge bg-primary-subtle text-primary fs-6">{{ $wallet->network }}</span></td>
                                    <td style="word-break: break-all;">
                                        {{ $wallet->wallet_address }}
                                        {{-- GÜNCELLEME: Kopyalama butonu eklendi --}}
                                        <button class="btn btn-sm btn-soft-secondary py-0 px-1 ms-1 copy-to-clipboard" 
                                                data-clipboard-text="{{ $wallet->wallet_address }}" 
                                                title="Adresi Kopyala">
                                            <i class="ri-file-copy-line"></i>
                                        </button>
                                    </td>
                                    <td><span class="text-danger">{{ $wallet->notes }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Banka Hesapları Listesi --}}
@if($bankAccounts->isNotEmpty())
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0">Banka Hesaplarımız (IBAN)</h5></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead> <tr> <th>Banka Adı</th> <th>Hesap Sahibi</th> <th>IBAN</th> <th>Hesap No</th> <th>Şube</th> </tr> </thead>
                        <tbody>
                            @foreach ($bankAccounts as $account)
                                <tr>
                                    <td>{{ $account->bank_name }}</td>
                                    
                                    {{-- GÜNCELLEME BAŞLANGIÇ: Kopyalama butonu eklendi --}}
                                    <td>
                                        {{ $account->account_holder_name }}
                                        <button class="btn btn-sm btn-soft-secondary py-0 px-1 ms-1 copy-to-clipboard" 
                                                data-clipboard-text="{{ $account->account_holder_name }}" 
                                                title="Hesap Sahibini Kopyala">
                                            <i class="ri-file-copy-line"></i>
                                        </button>
                                    </td>
                                    {{-- GÜNCELLEME SONU --}}
                                    
                                    <td>
                                        {{ $account->iban }}
                                        <button class="btn btn-sm btn-soft-secondary py-0 px-1 ms-1 copy-to-clipboard" 
                                                data-clipboard-text="{{ $account->iban }}" 
                                                title="IBAN Kopyala">
                                            <i class="ri-file-copy-line"></i>
                                        </button>
                                    </td>
                                    <td>{{ $account->account_number ?? '-' }}</td>
                                    <td>{{ $account->branch_name ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if($bankAccounts->isEmpty() && $cryptoWallets->isEmpty())
<div class="row">
    <div class="col-lg-12">
        <div class="alert alert-warning" role="alert">
            Şu anda kayıtlı bir yatırım hesabı bulunmamaktadır. Lütfen daha sonra tekrar kontrol edin.
        </div>
    </div>
</div>
@endif

@endsection

{{-- YENİ: Kopyalama script'i için iziToast JS ve özel kod eklendi --}}
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tüm 'copy-to-clipboard' class'ına sahip butonları seç
            document.querySelectorAll('.copy-to-clipboard').forEach(button => {
                
                // Her butona bir tıklama olayı ekle
                button.addEventListener('click', function (e) {
                    // Butonun 'data-clipboard-text' niteliğindeki veriyi al
                    const textToCopy = this.dataset.clipboardText;
                    const originalIcon = this.innerHTML; // Orijinal ikonu (kopyala ikonu) sakla

                    // Modern Pano (Clipboard) API'sini kullan
                    navigator.clipboard.writeText(textToCopy).then(() => {
                        
                        // Başarılı olursa:
                        
                        // 1. iziToast ile bildirim göster
                        iziToast.success({
                            title: 'Kopyalandı!',
                            message: 'Hesap bilgisi panoya kopyalandı.',
                            position: 'topRight',
                            timeout: 2500
                        });

                        // 2. Butonun ikonunu "check" (onay) ikonuyla değiştir
                        this.innerHTML = '<i class="ri-check-line text-success"></i>';

                        // 3. 2.5 saniye sonra ikonu eski haline getir
                        setTimeout(() => {
                            this.innerHTML = originalIcon;
                        }, 2500);

                    }).catch(err => {
                        // Başarısız olursa (örn: localhost'ta izin verilmezse)
                        iziToast.error({
                            title: 'Hata!',
                            message: 'Otomatik kopyalama başarısız oldu. Lütfen manuel kopyalayın.',
                            position: 'topRight'
                        });
                    });
                });
            });
        });
    </script>
@endpush