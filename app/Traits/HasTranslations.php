<?php

namespace App\Traits;
use Illuminate\Support\Facades\App;

trait HasTranslations
{
    /**
     * Mevcut dile göre çeviriyi getirir.
     * Kullanımı: $blog->getTranslation('title')
     */
    public function getTranslation($field)
    {
        // Veriyi al (Modelde 'array' cast olduğu için dizi gelir)
        $translations = $this->$field;
        
        // Şu anki dil (en veya tr)
        $locale = App::getLocale();

        // 1. İstenen dilde veri varsa onu döndür
        if (is_array($translations) && array_key_exists($locale, $translations) && !empty($translations[$locale])) {
            return $translations[$locale];
        }

        // 2. Yoksa varsayılan (fallback) dile bak (İngilizce)
        if (is_array($translations) && array_key_exists('en', $translations)) {
            return $translations['en'];
        }

        // 3. O da yoksa ve veri düz string ise (eski veri) kendisini döndür
        return is_string($translations) ? $translations : '';
    }
}