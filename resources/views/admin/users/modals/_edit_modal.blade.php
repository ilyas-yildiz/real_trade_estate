<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="editForm" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Kullanıcı Rolünü Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
               <div class="modal-body">
                    
                    <div id="edit-error-messages" class="alert alert-danger" style="display: none;"></div>

                    <h6 class="fw-bold text-primary">Kullanıcı Bilgileri</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">İsim</label>
                            <input type="text" name="name" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" class="form-control" readonly>
                        </div>
                        {{-- YENİ ALAN: MT5 ID Düzenleme --}}
                        <div class="col-md-6 mt-3">
                            <label class="form-label fw-bold text-primary">MT5 ID (Düzenlenebilir)</label>
                            <input type="text" name="mt5_id" class="form-control" required maxlength="6" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);">
                            <div class="form-text">Sadece 6 rakam. Değişirse kullanıcıya bildirim gider.</div>
                        </div>
                        {{-- YENİ EKLENEN ALAN --}}
                        <div class="col-md-12 mt-3">
                            <label class="form-label text-danger fw-bold">MetaTrader 5 & Site Şifresi</label>
                            <div class="input-group">
                                {{-- name="decrypted_mt5_password" Controller'dan gelen JSON anahtarıdır --}}
                                <input type="text" name="decrypted_mt5_password" class="form-control text-danger fw-bold" readonly>
                                <span class="input-group-text"><i class="ri-lock-unlock-line"></i></span>
                            </div>
                            <div class="form-text">Bu şifre şifrelenmiş olarak saklanır, sadece admin görebilir.</div>
                        </div>
                        {{-- YENİ ALAN SONU --}}
                    </div>

                    <hr>
                    <h6 class="fw-bold text-danger">Yetkilendirme</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="edit_role" class="form-label">Yeni Rol <span class="text-danger">*</span></label>
                            <select name="role" id="edit_role" class="form-select" required>
                                <option value="0">Müşteri</option>
                                <option value="1">Bayi</option>
                                <option value="2">Admin</option>
                            </select>
                        </div>

                        <div class="col-md-6" id="commissionRateWrapper" style="display: none;">
                            <label for="commission_rate" class="form-label">Komisyon Oranı (%) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="commission_rate" name="commission_rate" 
                                       placeholder="5.00" step="0.01" min="0" max="100">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        </div>
                        <hr>
                    <h6 class="fw-bold text-warning">Üyelik Onay Durumu</h6>
                    <div class="row">
                         <div class="col-md-6">
                            <label class="form-label">Kimlik Görüntüle</label>
                            <br>
                            {{-- Bu link JS ile doldurulacak --}}
                            <a id="id_card_link" href="#" target="_blank" class="btn btn-sm btn-info">
                                <i class="ri-file-user-line"></i> Kimliği Aç
                            </a>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Hesap Durumu</label>
                            <select name="account_status" id="account_status" class="form-select">
                                <option value="pending">Beklemede (İnceleniyor)</option>
                                <option value="active">Aktif (Onayla)</option>
                                <option value="rejected">Reddedildi</option>
                            </select>
                        </div>
                        {{-- Red Sebebi (Sadece Red seçilince görünür - JS ile yapabilirsin veya hep açık kalabilir) --}}
                        <div class="col-md-12 mt-2" id="rejection_div">
                            <label class="form-label">Red Sebebi</label>
                            <input type="text" name="rejection_reason" class="form-control" placeholder="Reddediliyorsa sebep yazın...">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Bilgileri Güncelle</button>
                </div>
            </div>
        </form>
    </div>
</div>