@extends('admin.layouts.app')

@section('title', 'Ödeme Yönetimi')

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
                <h4 class="card-title mb-0 flex-grow-1">Ödeme Bildirimleri Yönetimi</h4>
            </div>

            <div class="card-body">
                @include('admin.layouts.partials._messages')

                {{-- Filtreleme Formu --}}
                <form action="{{ route('admin.payments.index') }}" method="GET" class="mb-3 border p-3 rounded bg-light shadow-sm">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label for="status" class="form-label">Durum</label>
                            <select name="status" id="status" class="form-select form-select-sm">
                                <option value="">Tümü</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Beklemede</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Onaylandı</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Reddedildi</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="user_id" class="form-label">Kullanıcı</label>
                            <select name="user_id" id="user_id" class="form-select form-select-sm">
                                <option value="">Tüm Kullanıcılar</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-sm btn-primary shadow-none me-1"><i class="ri-filter-3-line align-bottom"></i> Filtrele</button>
                            <a href="{{ route('admin.payments.index') }}" class="btn btn-sm btn-secondary shadow-none"><i class="ri-refresh-line align-bottom"></i> Temizle</a>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Kullanıcı</th>
                                <th scope="col">Tutar</th>
                                <th scope="col">Ödeme Tarihi</th>
                                <th scope="col">Bildirim Tarihi</th>
                                <th scope="col">Durum</th>
                                <th scope="col">Dekont</th>
                                <th scope="col">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payments as $payment)
                                @php
                                    $statusClass = match ($payment->status) {
                                        'approved' => 'bg-success-subtle text-success',
                                        'rejected' => 'bg-danger-subtle text-danger',
                                        default => 'bg-warning-subtle text-warning',
                                    };
                                    $statusText = match ($payment->status) {
                                        'approved' => 'Onaylandı',
                                        'rejected' => 'Reddedildi',
                                        default => 'Beklemede',
                                    };
                                @endphp
                                <tr>
                                    <td>{{ $payment->id }}</td>
                                    <td>
                                        @if($payment->user)
                                            {{ $payment->user->name }} <br>
                                            <small class="text-muted">{{ $payment->user->email }}</small>
                                        @else
                                            <span class="text-danger small">Kullanıcı Silinmiş</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($payment->amount, 2, ',', '.') }}</td>
                                    <td>{{ $payment->payment_date->format('d.m.Y') }}</td>
                                    <td>{{ $payment->created_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                                    </td>
                                    <td>
                                        @if ($payment->receipt_url)
                                            <a href="{{ $payment->receipt_url }}" target="_blank" class="btn btn-sm btn-outline-info shadow-none py-0 px-1" title="Dekontu Görüntüle">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="hstack gap-1">
                                            {{-- DÜZELTME: Modal ID'si ve data-target güncellendi --}}
                                            <button type="button" class="btn btn-sm btn-soft-primary shadow-none py-0 px-1 openEditModal"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editPaymentModal" 
                                                    data-id="{{ $payment->id }}"
                                                    data-fetch-url="{{ route('admin.payments.editJson', $payment->id) }}"
                                                    data-update-url="{{ route('admin.payments.update', $payment->id) }}"
                                                    title="İncele/Düzenle">
                                                <i class="ri-pencil-line"></i>
                                            </button>

                                            <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" class="d-inline delete-form">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-soft-danger shadow-none py-0 px-1" title="Sil"><i class="ri-delete-bin-line"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="text-center text-muted py-3">Kayıt bulunamadı.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                 <div class="mt-3">
                    {{ $payments->appends(request()->query())->links() }}
                </div>

            </div>
        </div>
    </div>
</div>

{{-- MODAL DAHİL --}}
@include('admin.payments.modals._edit_modal')

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success')) <script> document.addEventListener('DOMContentLoaded', function() { iziToast.success({ title: 'Başarılı!', message: '{{ session('success') }}', position: 'topRight' }); }); </script> @endif
    @if(session('error')) <script> document.addEventListener('DOMContentLoaded', function() { iziToast.error({ title: 'Hata!', message: '{{ session('error') }}', position: 'topRight' }); }); </script> @endif
    
    {{-- YENİ JS DOSYASI: resource-handler.js'in çakışmalarını önlemek için --}}
    <script src="{{ asset('js/admin/payments-handler.js') }}?v={{ time() }}" defer></script>
    {{-- Ortak JS (resource-handler) hala SweetAlert ve Form submit işini yapması için çağrılıyor --}}
    <script src="{{ asset('js/admin/common/resource-handler.js') }}?v={{ time() }}" defer></script> 
@endpush