<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseResourceController;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ServiceController extends BaseResourceController
{
    protected function getModelInstance(): Model { return new Service(); }
    protected function getViewPath(): string { return 'services'; }
    protected function getRouteName(): string { return 'services'; }

    protected function getValidationRules(Request $request, $id = null): array {
        return [
            'title' => 'array',
            'title.en' => 'required|string|max:255',
            'title.tr' => 'nullable|string|max:255',
            
            'content' => 'array',
            'content.en' => 'required|string',
            'content.tr' => 'nullable|string',
            
            'image' => $id ? 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072' : 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072'
        ];
    }
    
    protected function getImageFieldName(): ?string { return 'image'; }
    protected function getImagePath(): ?string { return 'service-images'; }
    protected function getImageSizes(): array { return ['800x600', '400x300']; }

    // Edit: Veriyi düzleştir
    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $data = $service->toArray();

        $translatableFields = ['title', 'content'];
        foreach ($translatableFields as $field) {
            if (isset($data[$field]) && is_array($data[$field])) {
                foreach ($data[$field] as $lang => $value) {
                    $data["{$field}[{$lang}]"] = $value;
                }
            }
        }

        if ($service->image_url) {
            $data['image_full_url'] = asset('storage/service-images/400x300/' . $service->image_url);
        }

        return response()->json(['item' => $data]);
    }

    // Store: Slug ekle ve kaydet
    public function store(Request $request)
    {
        $validated = $request->validate($this->getValidationRules($request));
        
        // Slug'ı İngilizce başlıktan oluştur
        $validated['slug'] = Str::slug($request->input('title.en'));

        if ($request->hasFile('image')) {
            $filename = $this->imageService->saveImage($request->file('image'), $this->getImagePath(), $this->getImageSizes());
            if ($filename) $validated['image_url'] = $filename;
        }

        $this->model->create($validated);
        return response()->json(['success' => true, 'message' => 'Hizmet başarıyla oluşturuldu.']);
    }

    // Update: Slug güncelle ve kaydet
    public function update(Request $request, $id)
    {
        $service = $this->model->findOrFail($id);
        $validated = $request->validate($this->getValidationRules($request, $id));

        // Başlık değiştiyse Slug'ı güncelle
        if ($request->input('title.en') !== $service->title['en']) {
            $validated['slug'] = Str::slug($request->input('title.en'));
        }

        if ($request->hasFile('image')) {
            if ($service->image_url) $this->imageService->deleteImages($service->image_url, $this->getImagePath(), $this->getImageSizes());
            $filename = $this->imageService->saveImage($request->file('image'), $this->getImagePath(), $this->getImageSizes());
            if ($filename) $validated['image_url'] = $filename;
        }

        $service->update($validated);
        return response()->json(['success' => true, 'message' => 'Hizmet başarıyla güncellendi.']);
    }
}