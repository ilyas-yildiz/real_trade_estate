<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseResourceController; 
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class AboutController extends BaseResourceController 
{
    protected function getModelInstance(): Model { return new About(); }
    protected function getViewPath(): string { return 'abouts'; }
    protected function getRouteName(): string { return 'abouts'; }

  // GÜNCELLENDİ: Türkçe alanlar kurallara eklendi
    protected function getValidationRules(Request $request, $id = null): array {
        return [
            'title' => 'array',
            'title.en' => 'required|string|max:255',
            'title.tr' => 'nullable|string|max:255', // YENİ EKLENDİ
            
            'short_content' => 'array',
            'short_content.en' => 'nullable|string|max:1000',
            'short_content.tr' => 'nullable|string|max:1000', // YENİ EKLENDİ
            
            'content' => 'array',
            'content.en' => 'required|string',
            'content.tr' => 'nullable|string', // YENİ EKLENDİ
            
            'image' => $id ? 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072' : 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072'
        ];
    }

    protected function getImageFieldName(): ?string { return 'image'; }
    protected function getImagePath(): ?string { return 'about-images'; }
    protected function getImageSizes(): array { return ['800x600', '400x300', '128x128']; } 

    protected function getAdditionalDataForForms(): array { return []; }

    // GÜNCELLENDİ: Edit (JSON Düzleştirme)
    public function edit($id)
    {
        $about = About::findOrFail($id);
        $data = $about->toArray();

        // Çevirileri Düzleştir (JavaScript için)
        $translatableFields = ['title', 'short_content', 'content'];

        foreach ($translatableFields as $field) {
            if (isset($data[$field]) && is_array($data[$field])) {
                foreach ($data[$field] as $lang => $value) {
                    $data["{$field}[{$lang}]"] = $value;
                }
            }
        }

        // Resim URL'sini ekle
        if ($about->image_url) {
            $data['image_full_url'] = asset('storage/about-images/128x128/' . $about->image_url);
        }

        return response()->json(['item' => $data]);
    }
    
    // GÜNCELLENDİ: Store (AJAX Uyumlu)
    public function store(Request $request)
    {
        // 1. Validasyon
        $validated = $request->validate($this->getValidationRules($request));

        // 2. Resim Yükle
        if ($request->hasFile('image')) {
            $filename = $this->imageService->saveImage(
                $request->file('image'),
                $this->getImagePath(),
                $this->getImageSizes()
            );
            if ($filename) {
                $validated['image_url'] = $filename;
            }
        }

        // 3. Kayıt
        $this->model->create($validated);

        // 4. Yanıt
        return response()->json(['success' => true, 'message' => 'Kayıt başarıyla oluşturuldu.']);
    }

    // GÜNCELLENDİ: Update (AJAX Uyumlu)
    public function update(Request $request, $id)
    {
        $about = $this->model->findOrFail($id);
        
        // 1. Validasyon
        $validated = $request->validate($this->getValidationRules($request, $id));

        // 2. Resim Güncelle
        if ($request->hasFile('image')) {
            if ($about->image_url) {
                $this->imageService->deleteImages($about->image_url, $this->getImagePath(), $this->getImageSizes());
            }
            $filename = $this->imageService->saveImage(
                $request->file('image'),
                $this->getImagePath(),
                $this->getImageSizes()
            );
            if ($filename) {
                $validated['image_url'] = $filename;
            }
        }

        // 3. Güncelleme
        $about->update($validated);

        // 4. Yanıt
        return response()->json(['success' => true, 'message' => 'Kayıt başarıyla güncellendi.']);
    }

    // Index metodu aynı kalabilir veya önceki override ettiğin hali kullanabilirsin.
    public function index()
    {
        $data = $this->model->all(); 
        $routeName = $this->getRouteName();
        $viewPath = $this->getViewPath();
        $additionalData = $this->getAdditionalDataForForms();
        return view('admin.' . $viewPath . '.index', compact('data', 'routeName', 'viewPath') + $additionalData);
    }
}