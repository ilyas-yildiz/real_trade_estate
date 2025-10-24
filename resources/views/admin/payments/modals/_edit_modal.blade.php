{{-- resources/views/admin/payments/modals/_edit_modal.blade.php --}}

{{-- DÜZELTME: ID, JS'nin beklediği 'editModal' olarak ayarlandı --}}
<div class="modal fade" id="editPaymentModal" tabindex="-1" aria-labelledby="editPaymentModalLabel" aria-hidden="true">    
    <div class="modal-dialog modal-lg">
        {{-- action kısmı JavaScript ile dinamik olarak doldurulacak --}}
        <form id="editForm" action="" method="POST">
            @csrf
            @method('PUT') {{-- Update işlemi için PUT/PATCH --}}
            <div class="modal-content">
                <div class="modal-header">
                    {{-- Başlık güncellendi --}}
                    <h5 class="modal-title" id="editModalLabel">Ödeme Bildirimini İncele/Düzenle</h5> 
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- ... (Modal içeriğinin geri kalanı aynı kaldı) ... --}}
                <div class="modal-body">
                    {{-- Gelen veriyi gösterecek div'i ekliyoruz --}}
                    <div id="payment-details-container">
                        {{-- Hata mesajları için alan --}}
                        <div id="edit-error-messages" class="alert alert-danger" style="display: none;"></div>

                        {{-- Ödeme Detayları (JS ile doldurulacak readonly alanlar) --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Kullanıcı:</strong> <span id="payment-user-info"></span></p>
                                <p class="mb-1"><strong>Tutar:</strong> <span id="payment-amount"></span></p>
                                <p class="mb-1"><strong>Ödeme Tarihi:</strong> <span id="payment-date"></span></p>
                                <p class="mb-0"><strong>Referans No:</strong> <span id="payment-reference"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Bildirim Tarihi:</strong> <span id="payment-created-at"></span></p>
                                <p class="mb-1"><strong>Mevcut Durum:</strong> <span id="payment-current-status" class="badge"></span></p>
                                <p class="mb-0"><strong>Dekont:</strong> <a id="payment-receipt-link" href="#" target="_blank" class="btn btn-sm btn-outline-info py-0 px-1" style="display: none;">Görüntüle</a> <span id="payment-receipt-none" class="text-muted small" style="display: none;">Yok</span></p>
                                <p class="mt-2 mb-1"><strong>Kullanıcı Notu:</strong></p>
                                <small id="payment-user-notes" class="text-muted d-block border p-2 rounded bg-light" style="max-height: 80px; overflow-y: auto;"></small>
                            </div>
                        </div>
                        <hr>

                        {{-- Admin Düzenleme Formu --}}
                        <div class="row">
                            <div class="col-md-6">
                                <label for="edit_status" class="form-label">Yeni Durum <span class="text-danger">*</span></label>
                                <select name="status" id="edit_status" class="form-select" required>
                                    <option value="pending">Beklemede</option>
                                    <option value="approved">Onaylandı</option>
                                    <option value="rejected">Reddedildi</option>
                                </select>
                            </div>
                            <div class="col-md-12 mt-3">
                                 <label for="edit_admin_notes" class="form-label">Admin Notları (Opsiyonel)</label>
                                 <textarea name="admin_notes" id="edit_admin_notes" rows="3" class="form-control" placeholder="Onay/Red nedenini veya ek bilgileri buraya yazabilirsiniz..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Durumu Güncelle</button>
                </div>
            </div>
        </form>
    </div>
</div>