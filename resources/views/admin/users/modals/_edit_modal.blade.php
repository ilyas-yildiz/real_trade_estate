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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="submit" class="btn btn-primary">Rolü Güncelle</button>
                </div>
            </div>
        </form>
    </div>
</div>