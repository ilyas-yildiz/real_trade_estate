<div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        {{-- GÜNCELLEME: enctype eklendi (Dosya yükleme için zorunlu) --}}
        <form action="{{ route('admin.payments.storeForUser') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <input type="hidden" name="user_id" id="payment_user_id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPaymentModalLabel">
                        Ödeme Ekle: <span id="payment_user_name" class="text-primary fw-bold"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info small">
                        Bu işlem, kullanıcı adına bir ödeme bildirimi oluşturur ve <b>otomatik olarak onaylar</b>.
                    </div>

                    <div class="mb-3">
                        <label for="amount" class="form-label">Tutar <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="amount" name="amount" 
                               placeholder="1000.00" required step="0.01">
                    </div>

                    <div class="mb-3">
                        <label for="payment_date" class="form-label">Ödeme Tarihi <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="payment_date" name="payment_date" 
                               value="{{ date('Y-m-d') }}" required>
                    </div>

                    {{-- YENİ: Dekont Yükleme Alanı --}}
                    <div class="mb-3">
                        <label for="receipt" class="form-label">Dekont Dosyası <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="receipt" name="receipt" accept=".jpg,.jpeg,.png,.pdf" required>
                        <div class="form-text">WhatsApp vb. yerden gelen dekontu yükleyin.</div>
                    </div>

                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Admin Notu</label>
                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="2" placeholder="Örn: WhatsApp dekontu."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-success">Ekle ve Onayla</button>
                </div>
            </div>
        </form>
    </div>
</div>