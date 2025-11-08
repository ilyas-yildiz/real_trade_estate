@extends('admin.layouts.app')

@section('title', 'Çekim Taleplerim')

@push('izitoastcss')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
@endpush
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Çekim Taleplerim</h4>
                <div class="flex-shrink-0">
                    {{-- Buton güncellendi --}}
                    <a href="{{ route('admin.withdrawals.create') }}" class="btn btn-primary btn-sm">
                        <i class="ri-add-line align-bottom"></i> Yeni Çekim Talebi Oluştur
                    </a>
                </div>
            </div>

            <div class="card-body">
                @include('admin.layouts.partials._messages')
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Tutar</th>
                                <th scope="col">Ödeme Yöntemi</th>
                                <th scope="col">Talep Tarihi</th>
                                <th scope="col">Durum</th>
                                <th scope="col">İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($withdrawals as $withdrawal)
                              @php
                                    // GÜNCELLEME: 'processing' durumu 'match'e eklendi (Mavi/Info rengi)
                                    $statusClass = match ($withdrawal->status) {
                                        'approved' => 'bg-success-subtle text-success',
                                        'rejected' => 'bg-danger-subtle text-danger',
                                        'processing' => 'bg-info-subtle text-info',
                                        default => 'bg-warning-subtle text-warning', // pending
                                    };
                                    $statusText = match ($withdrawal->status) {
                                        'approved' => 'Onaylandı',
                                        'rejected' => 'Reddedildi',
                                        'processing' => 'Ödeme Sürecinde',
                                        default => 'Beklemede', // pending
                                    };
                                @endphp
                                <tr data-id="{{ $withdrawal->id }}">
                                    <td>{{ number_format($withdrawal->amount, 2, ',', '.') }}</td>
                                <td>
                                        {{-- Yöntemi Göster (Banka veya Kripto) --}}
                                        @if ($withdrawal->method)
                                            {{-- DÜZELTME: Doğru model adı --}}
                                            @if ($withdrawal->method_type == 'App\Models\UserBankAccount')
                                                <span class="badge bg-primary-subtle text-primary">Banka: {{ $withdrawal->method->bank_name }} / {{ $withdrawal->method->iban }}</span>
                                            {{-- DÜZELTME: Doğru model adı --}}
                                            @elseif ($withdrawal->method_type == 'App\Models\UserCryptoWallet')
                                                <span class="badge bg-secondary-subtle text-secondary">Kripto: {{ $withdrawal->method->network }} / ...{{ substr($withdrawal->method->wallet_address, -6) }}</span>
                                            @endif
                                        @else
                                            <span class="text-danger small">Yöntem Silinmiş</span>
                                        @endif
                                    </td>
                                    <td>{{ $withdrawal->created_at->format('d.m.Y H:i') }}</td>
                                    <td><span class="badge {{ $statusClass }}">{{ $statusText }}</span></td>
                                    <td>
                                        <button type="button" 
                                                class="btn btn-sm btn-soft-info shadow-none py-0 px-1 openViewModal"
                                                data-bs-toggle="modal"
                                                data-bs-target="#viewNoteModal"
                                                data-status-text="{{ $statusText }}"
                                                data-status-class="{{ $statusClass }}"
                                                data-admin-note="{{ $withdrawal->admin_notes ?? 'Admin tarafından bir not eklenmemiş.' }}"
                                                title="Detayları Görüntüle">
                                            <i class="ri-eye-line"></i>
                                        </button>
                                        {{-- Kullanıcı sadece "Beklemede" olan talebini silebilir --}}
                                        @if($withdrawal->status == 'pending')
                                            <form action="{{ route('admin.withdrawals.destroy', $withdrawal->id) }}" method="POST" class="d-inline delete-form">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-soft-danger shadow-none py-0 px-1" title="İptal Et"><i class="ri-delete-bin-line"></i></button>
                                            </form>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-3">Henüz bir çekim talebiniz bulunmuyor.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                 <div class="mt-3">
                    {{ $withdrawals->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin.withdrawals.modals._view_note_modal')
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @if(session('success')) <script> document.addEventListener('DOMContentLoaded', function() { iziToast.success({ title: 'Başarılı!', message: '{{ session('success') }}', position: 'topRight' }); }); </script> @endif
    @if(session('error')) <script> document.addEventListener('DOMContentLoaded', function() { iziToast.error({ title: 'Hata!', message: '{{ session('error') }}', position: 'topRight' }); }); </script> @endif

    {{-- Sadece SweetAlert ile silme onayı için (resource-handler'a gerek yok) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Emin misiniz?',
                        text: "Bu talep iptal edilecek! Bu işlem geri alınamaz.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Evet, iptal et!',
                        cancelButtonText: 'Vazgeç'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });

        // YENİ: Detay Görüntüleme Modal'ını Doldurma Script'i
            const viewNoteModal = document.getElementById('viewNoteModal');
            if (viewNoteModal) {
                viewNoteModal.addEventListener('show.bs.modal', function (event) {
                    // Butonu al
                    const button = event.relatedTarget;
                    
                    // Butonun 'data-' niteliklerinden verileri oku
                    const statusText = button.dataset.statusText;
                    const statusClass = button.dataset.statusClass;
                    const adminNote = button.dataset.adminNote;

                    // Modal içindeki elementleri bul
                    const statusBadgeEl = viewNoteModal.querySelector('#modal_status_badge');
                    const adminNoteEl = viewNoteModal.querySelector('#modal_admin_note');

                    // Statü badge'ini ayarla
                    statusBadgeEl.textContent = statusText;
                    statusBadgeEl.className = 'badge fs-6 ' + statusClass; // Class'ları sıfırla ve yenisini ekle

                    // Admin notunu ayarla
                    if (adminNote && adminNote.trim() !== 'Admin tarafından bir not eklenmemiş.') {
                        adminNoteEl.textContent = adminNote;
                        adminNoteEl.classList.remove('text-muted'); // Varsa 'soluk' class'ını kaldır
                    } else {
                        adminNoteEl.textContent = 'Admin tarafından bir not eklenmemiş.';
                        adminNoteEl.classList.add('text-muted'); // 'Soluk' class'ı ekle
                    }
                });
            }

        
    </script>
@endpush