@extends('admin.layouts.app')

@section('title', 'Müşteri Adına Ödeme Ekle')

@push('styles')
    {{-- Select2 (kullanıcı arama) için CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Müşteri Adına Manuel Ödeme Ekle</h4>
            </div>
            <div class="card-body">
                
                @include('admin.layouts.partials._messages') {{-- Hata/Başarı mesajları --}}

                <p class="text-muted mb-3">Bu form, müşterinin WhatsApp vb. yollarla ilettiği ve sizin tarafınızdan teyit edilmiş ödemeleri kaydetmek içindir. Buradan eklenen kayıtlar **otomatik olarak onaylanır**.</p>

                <form action="{{ route('admin.payments.storeForUser') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Kullanıcı (Müşteri veya Bayi) <span class="text-danger">*</span></label>
                        {{-- Hızlı arama için Select2 kullanıyoruz --}}
                        <select class="form-control" id="user_id" name="user_id" required>
                            <option value="">Lütfen bir kullanıcı seçin...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="amount" class="form-label">Yatırılan Tutar <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="amount" name="amount" 
                               placeholder="1000.00" value="{{ old('amount') }}" required step="0.01">
                    </div>

                    <div class="mb-3">
                        <label for="payment_date" class="form-label">Ödeme Tarihi (Dekonttaki) <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="payment_date" name="payment_date" 
                               value="{{ old('payment_date', date('Y-m-d')) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Admin Notu (Opsiyonel)</label>
                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="3" placeholder="Örn: WhatsApp'tan dekont iletildi. Teyit edildi.">{{ old('admin_notes') }}</textarea>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary w-100">Ödemeyi Ekle ve Onayla</button>
                    </div>
                    <div class="mt-2 text-center">
                        <a href="{{ route('admin.payments.index') }}" class="btn btn-link btn-sm">İptal et ve geri dön</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{-- Select2 (kullanıcı arama) için JS --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        // Select2'yi başlat
        $(document).ready(function() {
            $('#user_id').select2({
                placeholder: "Bir kullanıcı seçin...",
                allowClear: true
            });
        });
    </script>
@endpush