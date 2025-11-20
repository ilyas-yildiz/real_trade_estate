<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // BU SATIRI EKLEMEYİ UNUTMA

return new class extends Migration
{
   public function up(): void
{
    DB::table('blogs')->truncate();
    Schema::table('blogs', function (Blueprint $table) {
        // Mevcut sütun tiplerini JSON olarak değiştiriyoruz
        $table->json('title')->change();
        $table->json('content')->change();
        // Slug genelde tekil (SEO için) kalır veya o da çevrilir.
        // Şimdilik slug'ı evrensel (URL dostu) bırakıyoruz, genelde İngilizce olur.
    });
}

public function down(): void
{
    DB::table('blogs')->truncate();
    Schema::table('blogs', function (Blueprint $table) {
        $table->string('title')->change();
        $table->longText('content')->change();
    });
}
};
