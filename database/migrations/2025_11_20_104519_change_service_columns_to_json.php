<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
   public function up(): void
{
    // Veri uyumsuzluğunu önlemek için tabloyu temizle
    DB::table('services')->truncate();

    Schema::table('services', function (Blueprint $table) {
        $table->json('title')->change();
        $table->json('content')->change();
        // NOT: short_description yoktu değil mi? Varsa onu da ekle:
        // $table->json('short_description')->nullable()->change();
    });
}

public function down(): void
{
    DB::table('services')->truncate();
    Schema::table('services', function (Blueprint $table) {
        $table->string('title')->change();
        $table->longText('content')->change();
    });
}
};
