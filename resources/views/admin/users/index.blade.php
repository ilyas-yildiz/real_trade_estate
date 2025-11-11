@extends('admin.layouts.app')

@section('title', 'Kullanıcı Yönetimi')

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
                <h4 class="card-title mb-0 flex-grow-1">Kullanıcı Yönetimi</h4>
            </div>

            <div class="card-body">
                @include('admin.layouts.partials._messages')

                {{-- Filtreleme Formu --}}
                <form action="{{ route('admin.users.index') }}" method="GET" class="mb-3 border p-3 rounded bg-light shadow-sm">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-5">
                            <label for="search" class="form-label">İsim / Email Ara</label>
                            <input type="text" class="form-control form-control-sm" name="search" id="search" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="role" class="form-label">Role Göre Filtrele</label>
                            <select name="role" id="role" class="form-select form-select-sm">
                                <option value="">Tümü</option>
                                <option value="2" {{ request('role') == '2' ? 'selected' : '' }}>Admin</option>
                                <option value="1" {{ request('role') == '1' ? 'selected' : '' }}>Bayi</option>
                                <option value="0" {{ request('role') == '0' ? 'selected' : '' }}>Müşteri</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                             <button type="submit" class="btn btn-sm btn-primary shadow-none me-1"><i class="ri-filter-3-line align-bottom"></i> Filtrele</button>
                             <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-secondary shadow-none"><i class="ri-refresh-line align-bottom"></i> Temizle</a>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">İsim</th>
                                <th scope="col">Email</th>
                                <th scope="col">Rol</th>
                                <th scope="col">Ait Olduğu IB</th>
                                <th scope="col">Kayıt Tarihi</th>
                                <th scope="col">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                @php
                                    $roleClass = match ($user->role) {
                                        2 => 'bg-danger-subtle text-danger', // Admin
                                        1 => 'bg-success-subtle text-success', // Bayi
                                        default => 'bg-info-subtle text-info', // Müşteri
                                    };
                                    $roleText = match ($user->role) {
                                        2 => 'Admin',
                                        1 => 'IB',
                                        default => 'Müşteri',
                                    };
                                @endphp
                                <tr data-id="{{ $user->id }}">
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td><span class="badge {{ $roleClass }}">{{ $roleText }}</span></td>
                                    <td>
                                        @if($user->bayi_id)
                                            {{-- User modeline 'bayi' ilişkisini eklediğimiz için bunu kullanabiliriz --}}
                                            {{ $user->bayi->name ?? 'Bilinmeyen Bayi' }} (ID: {{ $user->bayi_id }})
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('d.m.Y') }}</td>
                                    <td>
                                        <div class="hstack gap-1">
                                            {{-- Admin kendi kendini düzenleyemesin --}}
                                            @if (Auth::id() == $user->id)
                                                <button type="button" class="btn btn-sm btn-soft-secondary shadow-none py-0 px-1" disabled title="Kendi rolünüzü değiştiremezsiniz">
                                                    <i class="ri-pencil-line"></i>
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-sm btn-soft-primary shadow-none py-0 px-1 openEditModal"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal"
                                                        data-id="{{ $user->id }}"
                                                        data-fetch-url="{{ route('admin.users.edit', $user->id) }}"
                                                        data-update-url="{{ route('admin.users.update', $user->id) }}"
                                                        title="Rolü Düzenle">
                                                    <i class="ri-pencil-line"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center text-muted py-3">Kayıt bulunamadı.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                 <div class="mt-3">
                    {{ $users->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL DAHİL --}}
@include('admin.users.modals._edit_modal')

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @if(session('success')) <script> document.addEventListener('DOMContentLoaded', function() { iziToast.success({ title: 'Başarılı!', message: '{{ session('success') }}', position: 'topRight' }); }); </script> @endif
    @if(session('error')) <script> document.addEventListener('DOMContentLoaded', function() { iziToast.error({ title: 'Hata!', message: '{{ session('error') }}', position: 'topRight' }); }); </script> @endif
    
    {{-- Çalışan resource-handler.js'i kullanıyoruz --}}
    <script src="{{ asset('js/admin/common/resource-handler.js') }}?v={{ time() }}" defer></script> 
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('editModal');
        // 'editForm' içindeki 'role' ID'li select'i bul
        const roleSelect = modal.querySelector('#editForm [name="role"]'); 
        const commissionWrapper = modal.querySelector('#commissionRateWrapper');
        const commissionInput = modal.querySelector('#commission_rate');

        function toggleCommissionField(selectedRole) {
            // Rol "1" (Bayi) ise göster
            if (selectedRole === '1') {
                commissionWrapper.style.display = 'block';
                commissionInput.setAttribute('required', 'required');
            } else {
                commissionWrapper.style.display = 'none';
                commissionInput.removeAttribute('required');
                // commissionInput.value = '0'; // İsteğe bağlı: Bayi değilse 0'a çek
            }
        }

        // 1. Modal açıldığında 'resource-handler.js' formu doldurur.
        // Biz 'shown.bs.modal' (tamamen açıldıktan sonra) anlık değeri kontrol edelim.
        modal.addEventListener('shown.bs.modal', function () {
            toggleCommissionField(roleSelect.value);
        });

        // 2. Kullanıcı rolu anlık değiştirirse
        roleSelect.addEventListener('change', function () {
            toggleCommissionField(this.value);
        });
    });
    </script>
@endpush