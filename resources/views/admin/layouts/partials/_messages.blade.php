{{-- resources/views/admin/layouts/partials/_messages.blade.php --}}

{{-- Genel Başarı Mesajı --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Genel Hata Mesajı --}}
 @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Genel Uyarı Mesajı --}}
 @if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Genel Bilgi Mesajı --}}
 @if(session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


{{-- Validation Hataları (Toplu Gösterim - İsteğe Bağlı) --}}
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Hata!</strong> Lütfen formdaki eksik veya hatalı bilgileri kontrol edin.
         <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif