<div class="modal fade" id="viewNoteModal" tabindex="-1" aria-labelledby="viewNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewNoteModalLabel">Çekim Talebi Detayı</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <h6 class="fw-bold">Talep Durumu:</h6>
                {{-- JS burayı 'badge bg-success-subtle text-success' vb. ile dolduracak --}}
                <p><span class="badge fs-6" id="modal_status_badge"></span></p>

                <hr>

                <h6 class="fw-bold">Admin Açıklaması:</h6>
                {{-- 
                    white-space: pre-wrap; -> Adminin yazdığı satır başlarını (enter) korur.
                    JS burayı dolduracak.
                --}}
                <div id="modal_admin_note" 
                     class="text-muted" 
                     style="min-height: 50px; white-space: pre-wrap; background-color: #f8f9fa; border-radius: 5px; padding: 10px;">
                    Yükleniyor...
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>