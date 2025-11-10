@extends('admin.layouts.app')

@section('title', 'Yatırım Hesapları Yönetimi')

@push('izitoastcss')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
@endpush
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')

@include('admin.layouts.partials._messages')

<div class="row">
    {{-- Banka Hesabı Ekleme Formu --}}
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Yeni Banka Hesabı Ekle</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.deposit_methods.storeBank') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Banka Adı <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="bank_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hesap Sahibi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="account_holder_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">IBAN <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="iban" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hesap No (Opsiyonel)</label>
                        <input type="text" class="form-control" name="account_number">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Şube Adı (Opsiyonel)</label>
                        <input type="text" class="form-control" name="branch_name">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="bank_is_active" name="is_active" value="1" checked>
                        <label class="form-check-label" for="bank_is_active">Müşterilere Gösterilsin (Aktif)</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Banka Hesabını Ekle</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Kripto Cüzdanı Ekleme Formu --}}
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Yeni Kripto Cüzdanı Ekle</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.deposit_methods.storeCrypto') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Cüzdan Tipi (Örn: USDT) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="wallet_type" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ağ (Örn: TRC20) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="network" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cüzdan Adresi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="wallet_address" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notlar (Opsiyonel)</label>
                        <textarea class="form-control" name="notes" rows="2" placeholder="Örn: Lütfen sadece TRC20 ağı üzerinden gönderim yapın."></textarea>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="crypto_is_active" name="is_active" value="1" checked>
                        <label class="form-check-label" for="crypto_is_active">Müşterilere Gösterilsin (Aktif)</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Kripto Cüzdanı Ekle</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Banka Hesapları Listesi --}}
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0">Kayıtlı Banka Hesapları</h5></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead> <tr> <th>Banka</th> <th>Hesap Sahibi</th> <th>IBAN</th> <th>Aktif</th> <th>İşlem</th> </tr> </thead>
                        <tbody>
                            @forelse ($bankAccounts as $account)
                                <tr>
                                    <td>{{ $account->bank_name }}</td>
                                    <td>{{ $account->account_holder_name }}</td>
                                    <td>{{ $account->iban }}</td>
                                    <td><span class="badge {{ $account->is_active ? 'bg-success' : 'bg-danger' }}">{{ $account->is_active ? 'Aktif' : 'Pasif' }}</span></td>
                                    <td>
                                        <form action="{{ route('admin.deposit_methods.destroyBank', $account->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-soft-danger shadow-none py-0 px-1" title="Sil"><i class="ri-delete-bin-line"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted">Kayıtlı banka hesabı yok.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- Kripto Cüzdanları Listesi --}}
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0">Kayıtlı Kripto Cüzdanları</h5></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                         <thead> <tr> <th>Tip</th> <th>Ağ</th> <th>Adres</th> <th>Not</th> <th>Aktif</th> <th>İşlem</th> </tr> </thead>
                        <tbody>
                             @forelse ($cryptoWallets as $wallet)
                                <tr>
                                    <td>{{ $wallet->wallet_type }}</td>
                                    <td>{{ $wallet->network }}</td>
                                    <td style="word-break: break-all;">{{ $wallet->wallet_address }}</td>
                                    <td>{{ $wallet->notes }}</td>
                                    <td><span class="badge {{ $wallet->is_active ? 'bg-success' : 'bg-danger' }}">{{ $wallet->is_active ? 'Aktif' : 'Pasif' }}</span></td>
                                    <td>
                                        <form action="{{ route('admin.deposit_methods.destroyCrypto', $wallet->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-soft-danger shadow-none py-0 px-1" title="Sil"><i class="ri-delete-bin-line"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted">Kayıtlı kripto cüzdanı yok.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @if(session('success')) <script> document.addEventListener('DOMContentLoaded', function() { iziToast.success({ title: 'Başarılı!', message: '{{ session('success') }}', position: 'topRight' }); }); </script> @endif
    @if(session('error')) <script> document.addEventListener('DOMContentLoaded', function() { iziToast.error({ title: 'Hata!', message: '{{ session('error') }}', position: 'topRight' }); }); </script> @endif
    
    <script>
        // SweetAlert ile silme onayı
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Bu hesap bilgisi silinecek!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Evet, sil!',
                        cancelButtonText: 'Vazgeç'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush