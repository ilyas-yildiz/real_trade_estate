document.addEventListener('DOMContentLoaded', function () {
    // Modal'ı ve hata mesajı alanını DOM'dan çek
    const modalEl = document.getElementById('editPaymentModal');
    if (!modalEl) return;

    const errorMessages = modalEl.querySelector('#edit-error-messages');

    // Yalnızca 'editPaymentModal' açıldığında çalışacak listener
    modalEl.addEventListener('show.bs.modal', async function (event) {
        // resource-handler.js içindeki fetchRequest fonksiyonunun tanımlı olduğunu varsayıyoruz.
        if (typeof fetchRequest !== 'function') {
            console.error('resource-handler.js dosyasındaki fetchRequest fonksiyonu bulunamadı.');
            return;
        }

        const button = event.relatedTarget;
        const fetchUrl = button.dataset.fetchUrl;
        const updateUrl = button.dataset.updateUrl;

        const editForm = document.getElementById('editForm');

        // Form aksiyonunu güncelle ve sıfırla
        editForm.action = updateUrl;
        editForm.reset();
        errorMessages.style.display = 'none';

        // Veriyi çek
        const data = await fetchRequest(fetchUrl, { method: 'GET' });

        // Veriyi moda içine doldur
        if (data && data.item) {
            const item = data.item;

            // --- VERİ DOLDURMA BAŞLANGICI ---
            // Statik/Read-only Bilgiler
            modalEl.querySelector('#payment-user-info').textContent = item.user_info;
            modalEl.querySelector('#payment-amount').textContent = item.amount_formatted;
            modalEl.querySelector('#payment-date').textContent = item.payment_date_formatted;
            modalEl.querySelector('#payment-reference').textContent = item.reference_number;
            modalEl.querySelector('#payment-created-at').textContent = item.created_at_formatted;
            modalEl.querySelector('#payment-user-notes').innerHTML = item.user_notes ? item.user_notes.replace(/\n/g, '<br>') : '-';

            // Durum (Badge) Bilgisi
            const currentStatusEl = modalEl.querySelector('#payment-current-status');
            currentStatusEl.textContent = item.status_text;
            currentStatusEl.className = `badge ${item.status_class}`;

            // Dekont Linki
            const receiptLink = modalEl.querySelector('#payment-receipt-link');
            const receiptNone = modalEl.querySelector('#payment-receipt-none');
            if (item.receipt_url) {
                receiptLink.href = item.receipt_url;
                receiptLink.style.display = 'inline-block';
                receiptNone.style.display = 'none';
            } else {
                receiptLink.style.display = 'none';
                receiptNone.style.display = 'inline-block';
            }

            // Form Kontrolleri (Select ve Textarea)
            modalEl.querySelector('#edit_admin_notes').value = item.admin_notes;
            modalEl.querySelector('#edit_status').value = item.status;

            // Modal başlığını güncelle
            modalEl.querySelector('.modal-title').textContent = `Ödeme Bildirimi #${item.id} İncelemesi`;
            // --- VERİ DOLDURMA BİTİŞİ ---

        } else if (data) {
            // Eğer sunucudan JSON geldi ama başarı flag'i yoksa (403 Forbidden gibi)
            errorMessages.textContent = data.message || 'Veri çekilirken bir sorun oluştu.';
            errorMessages.style.display = 'block';
        }
    });
});