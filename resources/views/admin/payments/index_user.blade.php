@extends('admin.layouts.app')

@section('title', 'Ödeme Bildirimlerim')

@push('izitoastcss')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Ödeme Bildirimlerim</h4>
                <div class="flex-shrink-0">
                    {{-- Yeni bildirim oluşturma sayfasına link --}}
                    <a href="{{ route('admin.payments.create') }}" class="btn btn-primary btn-sm shadow-none">
                        <i class="ri-add-line align-bottom"></i> Yeni Bildirim Ekle
                    </a>
                </div>
            </div><!-- end card header -->

            <div class="card-body">

                {{-- Başarı/Hata Mesajları --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                 @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
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
                                <tr>
                                    <td>{{ $payment->id }}</td>
                                    <td>{{ number_format($payment->amount, 2, ',', '.') }} {{-- Para formatı --}}</td>
                                    <td>{{ $payment->payment_date->format('d M Y') }}</td>
                                    <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        {{-- Duruma göre renkli badge --}}
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
                                        <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                                    </td>
                                    <td>
                                        {{-- Dekont linki (varsa) --}}
                                        @if ($payment->receipt_url)
                                            <a href="{{ $payment->receipt_url }}" target="_blank" class="btn btn-sm btn-outline-info shadow-none">
                                                Görüntüle
                                            </a>
                                        @else
                                            <span class="text-muted small">Yok</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- Sadece 'pending' durumundaysa silme butonu göster --}}
                                        @if ($payment->status === 'pending')
                                            <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" onsubmit="return confirm('Bu ödeme bildirimini silmek istediğinizden emin misiniz?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger shadow-none">Sil</button>
                                            </form>
                                        @else
                                           <span class="text-muted">-</span> {{-- Onaylanmış/Reddedilmiş ise işlem yok --}}
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Henüz hiç ödeme bildiriminiz yok.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div><!-- end table-responsive -->

                 {{-- Sayfalama Linkleri --}}
                 <div class="mt-3">
                    {{ $payments->links() }}
                </div>

            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div><!-- end row -->
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
    {{-- Başarı/Hata mesajları için scriptler --}}
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                iziToast.success({ title: 'Başarılı!', message: '{{ session('success') }}', position: 'topRight' });
            });
        </script>
    @endif
    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                iziToast.error({ title: 'Hata!', message: '{{ session('error') }}', position: 'topRight' });
            });
        </script>
    @endif
@endpush