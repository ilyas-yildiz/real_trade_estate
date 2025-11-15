<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th scope="col" style="width: 50px;">Durum</th>
                <th scope="col">Mesaj</th>
                <th scope="col">Tarih</th>
                <th scope="col" style="width: 100px;">İşlem</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($notifications as $notification)
                <tr class="{{ $notification->read_at ? '' : 'bg-light' }}">
                    <td>
                        <div class="avatar-xs">
                            <span class="avatar-title rounded-circle fs-16 bg-{{ $notification->data['color'] ?? 'primary' }}-subtle text-{{ $notification->data['color'] ?? 'primary' }}">
                                <i class="{{ $notification->data['icon'] ?? 'ri-notification-line' }}"></i>
                            </span>
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('admin.notifications.read', $notification->id) }}" class="text-reset d-block">
                            <h6 class="mb-1 {{ $notification->read_at ? 'fw-normal' : 'fw-bold' }}">
                                {{ $notification->data['message'] }}
                            </h6>
                        </a>
                    </td>
                    <td>
                        <span class="text-muted small">{{ $notification->created_at->diffForHumans() }}</span>
                        <br>
                        <span class="text-muted fs-11">{{ $notification->created_at->format('d.m.Y H:i') }}</span>
                    </td>
                    <td>
                        <div class="hstack gap-2">
                            <a href="{{ route('admin.notifications.read', $notification->id) }}" class="btn btn-sm btn-soft-primary" title="Görüntüle">
                                <i class="ri-eye-line"></i>
                            </a>
                            <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-soft-danger" title="Sil">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted py-5">Bu kategori için hiç bildiriminiz yok.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">
    {{-- 
        GÜNCELLEME: links($pageName) -> links() olarak düzeltildi.
        Controller'da 'paginate' metodunda sayfa adını ('pass_page' vb.) zaten belirttik.
        'appends' metodu bu ayarı otomatik olarak devralıp ?pass_page=2 şeklinde link üretecektir.
    --}}
    {{ $notifications->appends(request()->except($pageName))->links() }}
</div>