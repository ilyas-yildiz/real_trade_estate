@extends('admin.layouts.app')

@section('title', 'Şifre Değişiklik Talepleri')

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
                <h4 class="card-title mb-0 flex-grow-1">Bekleyen Şifre Değişiklik Talepleri</h4>
            </div>

            <div class="card-body">
                {{-- Hata/Başarı Mesajları --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                 <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Kullanıcı</th>
                                <th scope="col">Email</th>
                                <th scope="col">Mevcut MT5 ID</th>
                                {{-- YENİ SÜTUN --}}
                                <th scope="col">Talep Edilen Şifre</th>
                                <th scope="col">Talep Tarihi</th>
                                <th scope="col">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($requests as $req)
                                <tr>
                                    <td>{{ $req->user->name }}</td>
                                    <td>{{ $req->user->email }}</td>
                                    <td>{{ $req->user->mt5_id ?? '-' }}</td>
                                    
                                    {{-- YENİ SÜTUN: Şifreyi Çözüp Gösteriyoruz --}}
                                    <td>
                                        <span class="badge bg-light text-danger fs-6 border border-danger border-dashed">
                                            {{ \Illuminate\Support\Facades\Crypt::decryptString($req->new_password_encrypted) }}
                                        </span>
                                    </td>
                                    
                                    <td>{{ $req->created_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <div class="hstack gap-2">
                                            {{-- Onayla Butonu --}}
                                            <form action="{{ route('admin.password_requests.approve', $req->id) }}" method="POST" class="approve-form">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="ri-check-line align-bottom me-1"></i> Onayla
                                                </button>
                                            </form>

                                            {{-- Reddet Butonu --}}
                                            <form action="{{ route('admin.password_requests.reject', $req->id) }}" method="POST" class="reject-form">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="ri-close-line align-bottom me-1"></i> Reddet
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-3">Bekleyen şifre değişikliği talebi yok.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                </div>
                 <div class="mt-3">
                    {{ $requests->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Onaylama Uyarısı
            document.querySelectorAll('.approve-form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Onaylıyor musunuz?',
                        text: "Kullanıcının hem site hem de MT5 şifresi güncellenecektir.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Evet, Güncelle',
                        cancelButtonText: 'İptal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Reddetme Uyarısı
            document.querySelectorAll('.reject-form').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Reddediyor musunuz?',
                        text: "Talep iptal edilecek ve şifre değişmeyecek.",
                        icon: 'error',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Evet, Reddet',
                        cancelButtonText: 'İptal'
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