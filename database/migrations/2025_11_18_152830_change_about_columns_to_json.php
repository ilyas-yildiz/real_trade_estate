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
    DB::table('abouts')->truncate();

    Schema::table('abouts', function (Blueprint $table) {
        $table->json('title')->change();
        $table->json('short_content')->nullable()->change();
        $table->json('content')->change();
    });
}

public function down(): void
{
    DB::table('abouts')->truncate();
    Schema::table('abouts', function (Blueprint $table) {
        $table->string('title')->change();
        $table->text('short_content')->nullable()->change();
        $table->longText('content')->change();
    });
}
};
