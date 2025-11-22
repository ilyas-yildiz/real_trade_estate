@csrf

{{-- DİL SEKMELERİ --}}
<ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#en_{{ $editorId ?? 'create' }}" role="tab">
            <img src="{{ asset('admin/images/flags/us.svg') }}" height="14" class="me-1"> English
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#tr_{{ $editorId ?? 'create' }}" role="tab">
            <img src="{{ asset('admin/images/flags/tr.svg') }}" height="14" class="me-1"> Türkçe
        </a>
    </li>
</ul>

<div class="tab-content text-muted">
    
    {{-- İNGİLİZCE --}}
    <div class="tab-pane active" id="en_{{ $editorId ?? 'create' }}" role="tabpanel">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Başlık (EN) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="title[en]" 
                           value="{{ old('title.en', $item->title['en'] ?? '') }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Alt Başlık (EN)</label>
                    <input type="text" class="form-control" name="subtitle[en]"
                           value="{{ old('subtitle.en', $item->subtitle['en'] ?? '') }}">
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Buton Metni (EN)</label>
            <input type="text" class="form-control" name="button_text[en]"
                   value="{{ old('button_text.en', $item->button_text['en'] ?? '') }}">
        </div>
    </div>

    {{-- TÜRKÇE --}}
    <div class="tab-pane" id="tr_{{ $editorId ?? 'create' }}" role="tabpanel">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Başlık (TR)</label>
                    <input type="text" class="form-control" name="title[tr]" 
                           value="{{ old('title.tr', $item->title['tr'] ?? '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Alt Başlık (TR)</label>
                    <input type="text" class="form-control" name="subtitle[tr]"
                           value="{{ old('subtitle.tr', $item->subtitle['tr'] ?? '') }}">
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Buton Metni (TR)</label>
            <input type="text" class="form-control" name="button_text[tr]"
                   value="{{ old('button_text.tr', $item->button_text['tr'] ?? '') }}">
        </div>
    </div>
</div>

<hr>

{{-- ORTAK ALANLAR --}}

{{-- GÜNCELLEME: Sketch görseli kaldırıldı, Ana Görsel tam genişliğe alındı --}}
<div class="mb-3">
    <label for="{{ $editorId ?? 'create' }}_image" class="form-label">Ana Görsel (1920x1080)</label>
    <input type="file" class="form-control" name="image" id="{{ $editorId ?? 'create' }}_image">
    
    <div id="image-preview-container" class="mt-2" style="display: none;">
        <label class="form-label">Mevcut Görsel</label>
        <div>
            <img id="image-preview" src="" class="img-thumbnail" style="max-width: 200px;">
        </div>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Buton Linki (URL)</label>
    <input type="url" class="form-control" name="link" 
           placeholder="https://..." value="{{ old('link', $item->link ?? '') }}">
</div>