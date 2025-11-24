<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // BU SATIRI EKLEMEYİ UNUTMA

return new class extends Migration
{
public function up(): void
    {
        // 1. Temizlik: Veri uyumsuzluğunu önlemek için tabloyu temizle
        \Illuminate\Support\Facades\DB::table('blogs')->truncate();

        // 2. Hazırlık: Önce 'title' üzerindeki unique index'i kaldırıyoruz
        // Çünkü JSON sütunlar standart unique index olamaz.
        Schema::table('blogs', function (Blueprint $table) {
            // Başlık sütununda unique index olduğunu varsayıyorum
            $table->dropUnique(['title']); 
            
            // NOT: Eğer yukarıdaki satır "Index bulunamadı" hatası verirse, 
            // yerine şunu dene: $table->dropIndex(['title']);
        });

        // 3. İşlem: Sütun tiplerini değiştiriyoruz
        Schema::table('blogs', function (Blueprint $table) {
            $table->json('title')->change();
            $table->json('content')->change();
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
