document.addEventListener('DOMContentLoaded', function () {
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

    // --- LFM ve Summernote Entegrasyonu ---
    var summernote_context;
    window.SetUrl = function (items) {
        if (summernote_context) {
            items.forEach(function (item) {
                summernote_context.invoke('insertImage', item.url);
            });
            summernote_context = null;
        }
    };

    // --- Summernote Başlatma Fonksiyonu ---
    function initSummernote() {
        if (typeof $ === 'undefined' || !$.fn.summernote) {
            console.error('jQuery veya Summernote kütüphanesi yüklenemedi.');
            return;
        }
        $('.summernote-editor').summernote({
            lang: 'tr-TR',
            height: 350,
            focus: true,
            dialogsInBody: true,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'lfm', 'video', 'hr']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            buttons: {
                lfm: function (context) {
                    var ui = $.summernote.ui;
                    var button = ui.button({
                        contents: '<i class="note-icon-picture"></i> Dosya Yöneticisi',
                        tooltip: 'Dosya Yöneticisi',
                        click: function () {
                            summernote_context = context;
                            let route_prefix = '/admin/laravel-filemanager';
                            window.open(route_prefix + '?type=image', 'FileManager', 'width=900,height=600');
                        }
                    });
                    return button.render();
                }
            },
            callbacks: {
                onDialogCreate: function (dialog) {
                    const closeBtn = $(dialog).find('.close');
                    closeBtn.removeAttr('data-dismiss').attr('data-bs-dismiss', 'modal');
                }
            }
        });
    }

    initSummernote();

    // --- Genel AJAX Fonksiyonu ---
    async function fetchRequest(url, options) {
        options.headers = { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json', ...options.headers };
        try {
            const response = await fetch(url, options);
            if (!response.ok) {
                let errorData = {};
                try {
                    errorData = await response.json();
                } catch (e) {
                    errorData.message = `HTTP Hatası: ${response.status} ${response.statusText}`;
                }
                throw new Error(errorData.message || 'Bilinmeyen bir sunucu hatası oluştu.');
            }
            return await response.json();
        } catch (error) {
            console.error('Fetch Error:', error);
            if (typeof iziToast !== 'undefined') {
                iziToast.error({ title: 'Hata!', message: error.message, position: 'topRight' });
            } else {
                alert('Hata: ' + error.message);
            }
            return null;
        }
    }

    // --- 1. SÜRÜKLE-BIRAK İLE SIRALAMA ---
    const sortableList = document.getElementById('sortable-list');
    if (sortableList && typeof Sortable !== 'undefined') {
        new Sortable(sortableList, {
            handle: '.handle-cell',
            animation: 150,
            onUpdate: function (evt) {
                const order = Array.from(sortableList.querySelectorAll('tr')).map((row, index) => ({ id: row.dataset.id, position: index }));
                const url = sortableList.dataset.updateUrl;
                const formData = new FormData();
                order.forEach((item, index) => {
                    formData.append(`order[${index}][id]`, item.id);
                    formData.append(`order[${index}][position]`, item.position);
                });
                fetchRequest(url, { method: 'POST', body: formData }).then(data => {
                    if (data && data.success && typeof iziToast !== 'undefined') {
                        iziToast.success({ title: 'Başarılı!', message: data.message || 'Sıralama güncellendi.', position: 'topRight' });
                    }
                });
            }
        });
    }

    // --- 2. DURUM DEĞİŞTİRME (SWITCH) ---
    document.querySelectorAll('.status-switch').forEach(switchEl => {
        switchEl.addEventListener('change', function () {
            const id = this.dataset.id;
            const model = this.dataset.model;
            const status = this.checked;
            const url = `/admin/${model}/${id}/status`;
            const formData = new FormData();
            formData.append('status', status ? '1' : '0');
            formData.append('_method', 'PATCH');
            fetchRequest(url, { method: 'POST', body: formData }).then(data => {
                if (data && data.success && typeof iziToast !== 'undefined') {
                    iziToast.success({ title: 'Başarılı!', message: data.message || 'Durum güncellendi.', position: 'topRight' });
                } else if (data === null) {
                    this.checked = !status;
                }
            });
        });
    });

    // --- 3. TEKLİ SİLME ONAYI (SweetAlert) ---
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Emin misiniz?',
                    text: "Bu işlem geri alınamaz!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet, sil!',
                    cancelButtonText: 'Vazgeç'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            } else {
                if (confirm('Emin misiniz? Bu işlem geri alınamaz!')) {
                    this.submit();
                }
            }
        });
    });

    // --- 4. TOPLU İŞLEMLER ---
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

    if (selectAllCheckbox && rowCheckboxes.length > 0 && bulkDeleteBtn) {
        const toggleBulkDeleteBtn = () => {
            const anyChecked = Array.from(rowCheckboxes).some(c => c.checked);
            bulkDeleteBtn.classList.toggle('d-none', !anyChecked);
        };
        selectAllCheckbox.addEventListener('change', function () {
            rowCheckboxes.forEach(checkbox => checkbox.checked = this.checked);
            toggleBulkDeleteBtn();
        });
        rowCheckboxes.forEach(checkbox => checkbox.addEventListener('change', toggleBulkDeleteBtn));

        bulkDeleteBtn.addEventListener('click', function () {
            const selectedIds = Array.from(rowCheckboxes).filter(c => c.checked).map(c => c.value);
            const model = this.dataset.model;
            const url = `/admin/${model}/bulk-delete`;

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Emin misiniz?',
                    text: `${selectedIds.length} adet kaydı silmek üzeresiniz. Bu işlem geri alınamaz!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Evet, hepsini sil!',
                    cancelButtonText: 'Vazgeç'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData();
                        selectedIds.forEach(id => formData.append('ids[]', id));
                        fetchRequest(url, { method: 'POST', body: formData }).then(data => {
                            if (data && data.success && typeof iziToast !== 'undefined') {
                                iziToast.success({ title: 'Başarılı!', message: data.message, position: 'topRight' });
                                setTimeout(() => window.location.reload(), 1500);
                            }
                        });
                    }
                });
            } else {
                if (confirm(`${selectedIds.length} adet kaydı silmek üzeresiniz. Emin misiniz?`)) {
                    // ... (aynı fetchRequest kodu)
                }
            }
        });
    }

    // --- 5. DÜZENLEME MODALI VERİ DOLDURMA (GÜNCELLENDİ) ---
    const editModalEl = document.getElementById('editModal');
    if (editModalEl) {
        editModalEl.addEventListener('show.bs.modal', async function (event) {
            const button = event.relatedTarget;
            const fetchUrl = button.dataset.fetchUrl;
            const updateUrl = button.dataset.updateUrl;
            const form = editModalEl.querySelector('#editForm');
            form.action = updateUrl;
            form.reset();

            // Görsel önizlemelerini temizle
            const imagePreviewContainer = form.querySelector('#image-preview-container');
            if (imagePreviewContainer) imagePreviewContainer.style.display = 'none';
            const imagePreview = form.querySelector('#image-preview');
            if (imagePreview) imagePreview.src = '';

            const sketchPreviewContainer = form.querySelector('#image_sketch-preview-container');
            if (sketchPreviewContainer) sketchPreviewContainer.style.display = 'none';
            const sketchPreview = form.querySelector('#image_sketch-preview');
            if (sketchPreview) sketchPreview.src = '';

            // Summernote editörlerini temizle
            $(form).find('.summernote-editor').each(function () {
                $(this).summernote('code', ''); // İçeriği boşalt
            });

            const data = await fetchRequest(fetchUrl, { method: 'GET' });

            if (data && data.item) {
                const item = data.item;

                // GÜNCELLEME: Veri Doldurma Döngüsü (Gelişmiş)
                Object.keys(item).forEach(key => {
                    if (key === 'image_url' || key === 'image_full_url') return;

                    // Tırnak işaretleri sorunu olmaması için güvenli seçici
                    // Hem name="key" hem de name="key[]" (checkbox group) desteği
                    // Hem de name="title[en]" gibi dizi isimleri desteği

                    // 1. Tam isim eşleşmesi (Örn: title[en])
                    let field = form.querySelector(`[name="${key}"]`);

                    // 2. Eğer bulunamazsa ve key bir dizi anahtarı değilse (Örn: status)
                    if (!field && !key.includes('[')) {
                        field = form.querySelector(`[name="${key}"]`);
                    }

                    if (field) {
                        // A) Summernote Editörü
                        if (field.classList.contains('summernote-editor')) {
                            $(field).summernote('code', item[key]);
                        }
                        // B) Checkbox
                        else if (field.type === 'checkbox') {
                            field.checked = (item[key] == 1 || item[key] == true);
                        }
                        // C) Select
                        else if (field.tagName === 'SELECT') {
                            field.value = item[key];
                        }
                        // D) Normal Input / Textarea
                        else {
                            field.value = item[key];
                        }
                    }
                });

                // Görseli Göster
                if (item.image_full_url && imagePreviewContainer && imagePreview) {
                    imagePreview.src = item.image_full_url;
                    imagePreviewContainer.style.display = 'block';
                }
                if (item.image_sketch_full_url && sketchPreviewContainer && sketchPreview) {
                    sketchPreview.src = item.image_sketch_full_url;
                    sketchPreviewContainer.style.display = 'block';
                }
                const idCardBtn = editModalEl.querySelector('#id_card_link');
                if (idCardBtn) {
                    if (item.id_card_url) {
                        // Link varsa güncelle ve butonu aktif et
                        idCardBtn.href = item.id_card_url;
                        idCardBtn.classList.remove('disabled', 'btn-secondary');
                        idCardBtn.classList.add('btn-info');
                        idCardBtn.innerHTML = '<i class="ri-file-user-line"></i> Kimliği Görüntüle';
                        // Yeni sekmede açılmasını garantiye al
                        idCardBtn.target = "_blank";
                    } else {
                        // Link yoksa pasif yap
                        idCardBtn.href = 'javascript:void(0);';
                        idCardBtn.classList.add('disabled', 'btn-secondary');
                        idCardBtn.classList.remove('btn-info');
                        idCardBtn.innerHTML = '<i class="ri-error-warning-line"></i> Kimlik Yok';
                    }
                }
            }
        });
    }

    // --- 6. AJAX FORM GÖNDERİMİ (GÜNCELLENDİ) ---
    async function handleFormSubmit(e) {
        e.preventDefault();
        const form = e.target;
        const url = form.action;
        const formData = new FormData(form);

        // GÜNCELLEME: Tüm Summernote editörlerinin içeriğini FormData'ya ekle
        // (Örn: content[en], content[tr] veya sadece content)
        $(form).find('.summernote-editor').each(function () {
            const name = $(this).attr('name');
            const content = $(this).summernote('code');

            // Eğer içerik boşsa veya sadece <p><br></p> ise boş gönder
            if ($(this).summernote('isEmpty')) {
                formData.set(name, '');
            } else {
                formData.set(name, content);
            }
        });

        const response = await fetchRequest(url, {
            method: 'POST',
            body: formData
        });

        if (response && response.success) {
            const modalEl = form.closest('.modal');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) {
                modalInstance.hide();
            }
            if (typeof iziToast !== 'undefined') {
                iziToast.success({ title: 'Başarılı!', message: response.message, position: 'topRight' });
            }
            setTimeout(() => window.location.reload(), 1000);
        }
    }

    document.getElementById('createForm')?.addEventListener('submit', handleFormSubmit);
    document.getElementById('editForm')?.addEventListener('submit', handleFormSubmit);
});