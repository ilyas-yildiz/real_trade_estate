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

    {{-- İNGİLİZCE İÇERİK --}}
    <div class="tab-pane active" id="en_{{ $editorId ?? 'create' }}" role="tabpanel">
        <div class="mb-3">
            <label class="form-label">Başlık (EN) <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="title[en]" 
                   value="{{ old('title.en', $item->title['en'] ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Kısa İçerik (EN)</label>
            <textarea class="form-control" name="short_content[en]" rows="3">{{ old('short_content.en', $item->short_content['en'] ?? '') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Uzun İçerik (EN) <span class="text-danger">*</span></label>
            <textarea class="form-control summernote-editor" name="content[en]">{!! old('content.en', $item->content['en'] ?? '') !!}</textarea>
        </div>
    </div>

    {{-- TÜRKÇE İÇERİK --}}
    <div class="tab-pane" id="tr_{{ $editorId ?? 'create' }}" role="tabpanel">
        <div class="mb-3">
            <label class="form-label">Başlık (TR)</label>
            <input type="text" class="form-control" name="title[tr]" 
                   value="{{ old('title.tr', $item->title['tr'] ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Kısa İçerik (TR)</label>
            <textarea class="form-control" name="short_content[tr]" rows="3">{{ old('short_content.tr', $item->short_content['tr'] ?? '') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Uzun İçerik (TR)</label>
            <textarea class="form-control summernote-editor" name="content[tr]">{!! old('content.tr', $item->content['tr'] ?? '') !!}</textarea>
        </div>
    </div>
</div>

{{-- ORTAK ALANLAR (Görsel) --}}
<hr>

<div class="mb-3">
    <label for="{{ $editorId ?? 'create' }}_image" class="form-label">Görsel</label>
    <input type="file" class="form-control" name="image" id="{{ $editorId ?? 'create' }}_image">

    <div id="image-preview-container" class="mt-2" style="display: none;">
        <label class="form-label">Mevcut Görsel</label>
        <div>
            <img id="image-preview" src="" alt="Mevcut Görsel" class="img-thumbnail" style="max-width: 150px;">
        </div>
    </div>
</div>