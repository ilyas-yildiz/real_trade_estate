@csrf

{{-- DİL SEKMELERİ --}}
<ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#en_{{ $editorId }}" role="tab">
            <img src="{{ asset('admin/images/flags/us.svg') }}" height="14" class="me-1"> English
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#tr_{{ $editorId }}" role="tab">
            <img src="{{ asset('admin/images/flags/tr.svg') }}" height="14" class="me-1"> Türkçe
        </a>
    </li>
</ul>

<div class="tab-content text-muted">
    
    {{-- İNGİLİZCE İÇERİK --}}
    {{-- Not: ID'lere $editorId ekliyoruz ki create ve edit modalları çakışmasın --}}
    <div class="tab-pane active" id="en_{{ $editorId }}" role="tabpanel">
        <div class="mb-3">
            <label class="form-label">Başlık (EN) <span class="text-danger">*</span></label>
            {{-- name="title[en]" olarak gönderiyoruz. Laravel bunu dizi olarak alacak. --}}
            <input type="text" class="form-control" name="title[en]" 
                   value="{{ old('title.en', $item->title['en'] ?? '') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">İçerik (EN) <span class="text-danger">*</span></label>
            {{-- Summernote editor --}}
            <textarea id="{{ $editorId }}_en" class="summernote-editor" name="content[en]">{!! old('content.en', $item->content['en'] ?? '') !!}</textarea>
        </div>
    </div>

    {{-- TÜRKÇE İÇERİK --}}
    <div class="tab-pane" id="tr_{{ $editorId }}" role="tabpanel">
        <div class="mb-3">
            <label class="form-label">Başlık (TR)</label>
            <input type="text" class="form-control" name="title[tr]" 
                   value="{{ old('title.tr', $item->title['tr'] ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">İçerik (TR)</label>
            <textarea id="{{ $editorId }}_tr" class="summernote-editor" name="content[tr]">{!! old('content.tr', $item->content['tr'] ?? '') !!}</textarea>
        </div>
    </div>
</div>

{{-- ORTAK ALANLAR (Dil bağımsız) --}}
<hr>

<div class="row">
    <div class="col-md-4">
        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select class="form-control" name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(isset($item) && $item->category_id == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="author_id" class="form-label">Yazar</label>
            <select class="form-control" name="author_id">
                <option value="">Yazar Yok</option>
                @foreach($authors as $author)
                    <option value="{{ $author->id }}" @selected(isset($item) && $item->author_id == $author->id)>
                        {{ $author->title }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label for="gallery_id" class="form-label">Galeri</label>
            <select class="form-control" name="gallery_id">
                <option value="">Galeri Yok</option>
                @foreach($galleries as $gallery)
                    <option value="{{ $gallery->id }}" @selected(isset($item) && $item->gallery_id == $gallery->id)>
                        {{ $gallery->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="mb-3">
    <label for="{{ $editorId }}_image" class="form-label">Görsel</label>
    <input type="file" class="form-control" name="image" id="{{ $editorId }}_image">
    
    <div id="image-preview-container" class="mt-2" style="display: none;">
        <label class="form-label">Mevcut Görsel</label>
        <div>
            <img id="image-preview" src="" alt="Mevcut Görsel" class="img-thumbnail" style="max-width: 150px;">
        </div>
    </div>
</div>

<div class="mb-3">
    <label for="is_featured" class="form-label">Manşet Ayarı</label>
    <div class="form-check form-switch form-switch-lg">
        <input type="hidden" name="is_featured" value="0">
        <input class="form-check-input" type="checkbox" name="is_featured" value="1" @checked(isset($item) && $item->is_featured)>
        <label class="form-check-label" for="is_featured">Bu haberi manşete taşı</label>
    </div>
</div>