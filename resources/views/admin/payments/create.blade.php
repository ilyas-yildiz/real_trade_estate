@extends('admin.layouts.app')

@section('title', 'Yeni Ödeme Bildirimi Oluştur')

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2"> {{-- Formu ortalamak için offset kullandık --}}
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Yeni Ödeme Bildirimi (Dekont Yükle)</h4>
                 {{-- Kullanıcının kendi ödeme listesine geri dönme linki --}}
                 <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary btn-sm shadow-none">
                     <i class="ri-arrow-left-line align-bottom"></i> Bildirimlerim
                 </a>
            </div><!-- end card header -->

            <div class="card-body">
                {{-- Form başlangıcı: store metoduna POST isteği ve dosya yükleme için enctype --}}
                <form action="{{ route('admin.payments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf {{-- CSRF koruması --}}

                    <div class="row gy-3">
                         {{-- Tutar Alanı --}}
                        <div class="col-md-6">
                            <label for="amount" class="form-label">Ödeme Tutarı <span class="text-danger">*</span></label>
                            <div class="input-group">
                                {{-- Para birimi sembolü (isteğe bağlı) --}}
                                {{-- <span class="input-group-text">₺</span> --}}
                                <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount') }}" placeholder="Örn: 1500.50" required>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                         {{-- Ödeme Tarihi Alanı --}}
                        <div class="col-md-6">
                            <label for="payment_date" class="form-label">Ödeme Yapılan Tarih <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('payment_date') is-invalid @enderror" id="payment_date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" required> {{-- Varsayılan olarak bugünü seçer --}}
                            @error('payment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                         {{-- Referans Numarası Alanı (Opsiyonel) --}}
                        <div class="col-md-12">
                            <label for="reference_number" class="form-label">Referans Numarası (Varsa)</label>
                            <input type="text" class="form-control @error('reference_number') is-invalid @enderror" id="reference_number" name="reference_number" value="{{ old('reference_number') }}" placeholder="Ödeme açıklaması veya dekont numarası">
                            @error('reference_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                         {{-- Dekont Yükleme Alanı --}}
                        <div class="col-md-12">
                            <label for="receipt" class="form-label">Dekont Dosyası <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('receipt') is-invalid @enderror" id="receipt" name="receipt" required accept=".jpg,.jpeg,.png,.pdf">
                             <div class="form-text">İzin verilen formatlar: JPG, PNG, PDF. Maksimum boyut: 5MB.</div>
                            @error('receipt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kullanıcı Notları Alanı (Opsiyonel) --}}
                         <div class="col-md-12">
                            <label for="user_notes" class="form-label">Ek Notlarınız (Varsa)</label>
                            <textarea class="form-control @error('user_notes') is-invalid @enderror" id="user_notes" name="user_notes" rows="3" placeholder="Ödemeyle ilgili ek bilgi vermek isterseniz buraya yazabilirsiniz.">{{ old('user_notes') }}</textarea>
                            @error('user_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Gönder Butonu --}}
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">Ödeme Bildirimini Gönder</button>
                        </div>
                    </div><!-- end row -->
                </form>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div><!-- end row -->
@endsection

{{-- Eğer date picker için özel JS gerekiyorsa (genellikle temanın app.js'inde vardır) buraya eklenebilir --}}
{{-- @push('scripts')
<script>
    // Flatpickr veya benzeri bir date picker'ı başlatma kodu (gerekirse)
</script>
@endpush --}}