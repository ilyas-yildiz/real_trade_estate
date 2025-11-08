<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Veri taşıma için eklendi

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 1. Yeni 'role' sütununu ekle (0=Müşteri, 1=Bayi, 2=Admin)
            // 'is_admin' sütunundan sonra ekliyoruz
            $table->tinyInteger('role')->default(0)->after('is_admin');
            
            // 2. Müşteriyi Bayi'ye bağlamak için 'bayi_id' sütununu ekle
            // Bu, 'users' tablosuna kendini referans gösteren bir foreign key'dir.
            $table->foreignId('bayi_id')->nullable()->after('role')->constrained('users')->onDelete('set null');
        });

        // 3. Mevcut 'is_admin' verisini yeni 'role' sütununa taşı
        // is_admin=1 olanları role=2 (Admin) yap
        DB::table('users')->where('is_admin', 1)->update(['role' => 2]);
        // is_admin=0 olanlar zaten role=0 (Müşteri) olarak kalacak
        
        // 4. Eski 'is_admin' sütununu kaldır
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 1. 'is_admin' sütununu geri ekle
            $table->boolean('is_admin')->default(false)->after('name');
        });
        
        // 2. Veriyi geri taşı (role=2 olanları is_admin=1 yap)
        DB::table('users')->where('role', 2)->update(['is_admin' => true]);
        
        Schema::table('users', function (Blueprint $table) {
            // 3. 'bayi_id' sütununu ve foreign key'i kaldır
            $table->dropForeign(['bayi_id']);
            $table->dropColumn('bayi_id');
            
            // 4. 'role' sütununu kaldır
            $table->dropColumn('role');
        });
    }
};