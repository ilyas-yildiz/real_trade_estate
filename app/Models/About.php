<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\ImageService;
use App\Traits\HasTranslations; // YENİ: Trait import

class About extends Model
{
    use HasFactory, HasTranslations; // YENİ: Trait kullanımı

    protected $fillable = [
        'title',
        'short_content',
        'content',
        'image_url',
        'status',
    ];

    // YENİ: JSON Dönüşümü
    protected $casts = [
        'title' => 'array',
        'short_content' => 'array',
        'content' => 'array',
    ];

    protected $appends = ['image_full_url'];

    // ... (Image accessor ve delete event'i aynı kalabilir) ...
     protected function imageFullUrl(): Attribute
    {
        $imagePath = 'about-images'; 
        return Attribute::make(
            get: fn () => $this->image_url ? asset('storage/' . $imagePath . '/128x128/' . $this->image_url) : null,
        );
    }

    protected static function booted(): void
    {
        static::deleting(function (About $about) {
            if ($about->image_url) {
                $imageService = app(ImageService::class);
                $imagePath = 'about-images';
                $sizes = ['800x600', '400x300', '128x128'];
                $imageService->deleteImages($about->image_url, $imagePath, $sizes);
            }
        });
    }
}