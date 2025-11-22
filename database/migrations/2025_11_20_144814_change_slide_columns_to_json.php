<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{

public function up(): void
{
    // Veri uyumsuzluğunu önlemek için
    DB::table('slides')->truncate();

    Schema::table('slides', function (Blueprint $table) {
        $table->json('title')->change();
        $table->json('subtitle')->nullable()->change();
        $table->json('button_text')->nullable()->change();
        // Link genelde tekildir, çevrilmez ama istersen onu da JSON yapabiliriz.
        // Şimdilik link sabit kalsın.
    });
}

public function down(): void
{
    DB::table('slides')->truncate();
    Schema::table('slides', function (Blueprint $table) {
        $table->string('title')->change();
        $table->string('subtitle')->nullable()->change();
        $table->string('button_text')->nullable()->change();
    });
}
};
