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
                    </div>

                    <hr>
                    <h6 class="fw-bold text-danger">Yetkilendirme</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="edit_role" class="form-label">Yeni Rol <span class="text-danger">*</span></label>
                            {{-- resource-handler.js, JSON'dan gelen 'role' (0, 1, 2) değerine göre doğru seçeneği seçecek --}}
                            <select name="role" id="edit_role" class="form-select" required>
                                <option value="0">Müşteri</option>
                                <option value="1">Bayi</option>
                                <option value="2">Admin</option>
                            </select>
                        </div>
                         <div class="col-md-6">
                            <div class="alert alert-info small mb-0">
                                <b>Not:</b> Bir müşteriyi "Bayi" yaparsanız, o bayiye ait tüm eski müşteri (bayi_id) bağlantıları sıfırlanır.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Rolü Güncelle</button>
                </div>
            </div>
        </form>
    </div>
</div>