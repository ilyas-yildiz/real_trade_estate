@extends('admin.layouts.app')
@section('title', 'Hakedişlerim')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><h4 class="card-title mb-0">Hakediş Dosyalarım</h4></div>
            <div class="card-body">
                @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Başlık</th>
                                <th>Yüklenme Tarihi</th>
                                <th>Durum</th>
                                <th>Dosya</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($earnings as $earning)
                            <tr>
                                <td>{{ $earning->title }}</td>
                                <td>{{ $earning->created_at->format('d.m.Y') }}</td>
                                <td>
                                    @if($earning->status == 'pending') <span class="badge bg-warning">Beklemede (İnceleyin)</span>
                                    @elseif($earning->status == 'approved') <span class="badge bg-success">Onayladınız</span>
                                    @else <span class="badge bg-danger">Reddettiniz</span> @endif
                                </td>
                                <td>
                                    <a href="{{ route('bayi.earnings.download', $earning->id) }}" class="btn btn-sm btn-soft-primary">
                                        <i class="ri-download-line"></i> İndir ve İncele
                                    </a>
                                </td>
                                <td>
                                    @if($earning->status == 'pending')
                                        <div class="d-flex gap-2">
                                            {{-- Onay Formu --}}
                                            <form action="{{ route('bayi.earnings.response', $earning->id) }}" method="POST">
                                                @csrf <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Bu hakedişi onaylıyor musunuz?')">Onayla</button>
                                            </form>
                                            {{-- Red Formu (Modal açılabilir ama şimdilik basit tutuyoruz) --}}
                                            <form action="{{ route('bayi.earnings.response', $earning->id) }}" method="POST">
                                                @csrf <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Reddetmek istediğinize emin misiniz?')">Reddet</button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-muted small">İşlem yapıldı.</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted">Henüz yüklenen bir hakediş yok.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection