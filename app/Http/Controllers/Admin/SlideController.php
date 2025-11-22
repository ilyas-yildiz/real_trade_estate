<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseResourceController;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Services\ImageService;
use Illuminate\Support\Str;

class SlideController extends BaseResourceController
{
    protected function getModelInstance(): Model { return new Slide(); }
    protected function getViewPath(): string { return 'slides'; }
    protected function getRouteName(): string { return 'slides'; }

    // GÜNCELLEME: JSON Validasyonu ve Sketch Kaldırıldı
    protected function getValidationRules(Request $request, $id = null): array
    {
       return [
            // Başlık
            'title' => 'array',
            'title.en' => 'required|string|max:255',
            'title.tr' => 'nullable|string|max:255', // YENİ EKLENDİ
            
            // Alt Başlık
            'subtitle' => 'array',
            'subtitle.en' => 'nullable|string|max:255',
            'subtitle.tr' => 'nullable|string|max:255', // YENİ EKLENDİ
            
            // Buton Metni
            'button_text' => 'array',
            'button_text.en' => 'nullable|string|max:255',
            'button_text.tr' => 'nullable|string|max:255', // YENİ EKLENDİ
            
            // Diğerleri (Dil bağımsız)
            'link' => 'nullable|url|max:255',
            'image' => $id ? 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240' : 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
        ];
    }

    protected function getImageFieldName(): ?string { return 'image'; }
    protected function getImagePath(): ?string { return 'slide-images'; }
    protected function getImageSizes(): array { return ['1920x1080', '128x128']; }

    protected function getAdditionalDataForForms(): array { return []; }

    // Edit Metodu (JSON Düzleştirme)
    public function edit($id)
    {
        $slide = Slide::findOrFail($id);
        $data = $slide->toArray();

        // Çevirileri Düzleştir
        $translatableFields = ['title', 'subtitle', 'button_text'];
        foreach ($translatableFields as $field) {
            if (isset($data[$field]) && is_array($data[$field])) {
                foreach ($data[$field] as $lang => $value) {
                    $data["{$field}[{$lang}]"] = $value;
                }
            }
        }

        // Görsel
        if ($slide->image_url) {
            $data['image_full_url'] = asset('storage/slide-images/128x128/' . $slide->image_url);
        }

        return response()->json(['item' => $data]);
    }

    // Store Metodu (AJAX Uyumlu)
    public function store(Request $request)
    {
        $imageService = app(ImageService::class);
        $validatedData = $request->validate($this->getValidationRules($request));

        // Ana görseli işle
        if ($request->hasFile($this->getImageFieldName())) {
            $filename = $imageService->saveImage(
                $request->file($this->getImageFieldName()),
                $this->getImagePath(),
                $this->getImageSizes()
            );
            
            if ($filename) {
                $validatedData['image_url'] = $filename;
            } else {
                return response()->json(['success' => false, 'message' => 'Görsel yüklenirken hata oluştu.'], 422);
            }
        }

        $validatedData['order'] = ($this->model->max('order') ?? -1) + 1;
        $this->model->create($validatedData);

        return response()->json(['success' => true, 'message' => 'Slide başarıyla eklendi.']);
    }

    // Update Metodu (AJAX Uyumlu)
    public function update(Request $request, $id)
    {
        $imageService = app(ImageService::class);
        $item = $this->model->findOrFail($id);
        $validatedData = $request->validate($this->getValidationRules($request, $id));

        // Ana görseli güncelle
        if ($request->hasFile($this->getImageFieldName())) {
            $filename = $imageService->saveImage(
                $request->file($this->getImageFieldName()),
                $this->getImagePath(),
                $this->getImageSizes()
            );
            
            if ($filename) {
                if ($item->image_url) {
                    $imageService->deleteImages($item->image_url, $this->getImagePath(), $this->getImageSizes());
                }
                $validatedData['image_url'] = $filename;
            } else {
                return response()->json(['success' => false, 'message' => 'Görsel güncellenirken hata oluştu.'], 422);
            }
        }

        $item->update($validatedData);

        return response()->json(['success' => true, 'message' => 'Slide başarıyla güncellendi.']);
    }

    protected function getResourceName(): string
    {
        return Str::singular(Str::studly($this->getRouteName()));
    }
}