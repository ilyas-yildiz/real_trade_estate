<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="editForm" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Ödeme Bildirimini İncele/Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div id="edit-error-messages" class="alert alert-danger" style="display: none;"></div>

                    <h6 class="fw-bold text-primary">Kullanıcı ve Ödeme Bilgileri</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Kullanıcı</label>
                            <input type="text" name="user_info" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tutar</label>
                            <input type="text" name="amount_formatted" class="form-control" readonly>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="form-label">Ödeme Tarihi</label>
                            <input type="text" name="payment_date_formatted" class="form-control" readonly>
                        </div>
                        <div class="col-md-6 mt-2">
                             <label class="form-label">Referans No</label>
                            <input type="text" name="reference_number" class="form-control" readonly>
                        </div>
                         <div class="col-md-12 mt-2">
                            <label class="form-label">Kullanıcı Notu</label>
                            {{-- HATA BURADAYDI: class.form-control" -> class="form-control" olarak düzeltildi --}}
                            <textarea name="user_notes" class="form-control" rows="2" readonly></textarea>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label class="form-label">Dekont</label>
                            <div>
                                <a id="modal-receipt-link" href="#" target="_blank" class="btn btn-sm btn-outline-info" style="display: none;">Dekontu Görüntüle</a>
                                <span id="modal-receipt-none" class="text-muted small" style="display: none;">Kullanıcı dekont yüklememiş.</span>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h6 class="fw-bold text-danger">Admin Alanı</h6>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Durumu Güncelle</button>
                </div>
            </div>
        </form>
    </div>
</div>