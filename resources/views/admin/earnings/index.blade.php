@extends('admin.layouts.app')
@section('title', 'Hakediş Yönetimi')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h4 class="card-title mb-0 flex-grow-1">Bayi Hakediş Dosyaları</h4>
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    <i class="ri-upload-cloud-2-line align-bottom me-1"></i> Yeni Hakediş Yükle
                </button>
            </div>
            <div class="card-body">
                @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Bayi</th>
                                <th>Başlık</th>
                                <th>Durum</th>
                                <th>Yüklenme Tarihi</th>
                                <th>Cevap Tarihi</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($earnings as $earning)
                            <tr>
                                <td>{{ $earning->bayi->name }}</td>
                                <td>{{ $earning->title }}</td>
                                <td>
                                    @if($earning->status == 'pending') <span class="badge bg-warning">Beklemede</span>
                                    @elseif($earning->status == 'approved') <span class="badge bg-success">Onaylandı</span>
                                    @else <span class="badge bg-danger">Reddedildi</span> @endif
                                </td>
                                <td>{{ $earning->created_at->format('d.m.Y') }}</td>
                                <td>{{ $earning->responded_at ? $earning->responded_at->format('d.m.Y H:i') : '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.earnings.download', $earning->id) }}" class="btn btn-sm btn-soft-primary"><i class="ri-download-line"></i> İndir</a>
                                    <form action="{{ route('admin.earnings.destroy', $earning->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmek istediğinize emin misiniz?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-soft-danger"><i class="ri-delete-bin-line"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center text-muted">Kayıt yok.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $earnings->links() }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Yükleme Modalı --}}
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.earnings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Hakediş Dosyası Yükle</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Bayi Seçin <span class="text-danger">*</span></label>
                        <select name="bayi_id" class="form-select" required>
                            <option value="">Seçiniz...</option>
                            @foreach($bayiler as $bayi)
                                <option value="{{ $bayi->id }}">{{ $bayi->name }} ({{ $bayi->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Başlık / Dönem <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="Örn: Ekim 2025 Hakedişi" required>
                    </div>
                    <div class="mb-3">
                        <label>Excel Dosyası <span class="text-danger">*</span></label>
                        <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv,.pdf" required>
                    </div>
                    <div class="mb-3">
                        <label>Not (Opsiyonel)</label>
                        <textarea name="admin_note" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Yükle ve Gönder</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection