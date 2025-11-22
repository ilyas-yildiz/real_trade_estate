<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('bayi_earnings', function (Blueprint $table) {
        $table->id();
        // Hakediş kime ait?
        $table->foreignId('bayi_id')->constrained('users')->onDelete('cascade');
        
        // Dosya Yolu (Excel)
        $table->string('file_path');
        
        // Hakediş Dönemi/Başlığı (Örn: "Ekim 2025 Hakedişi")
        $table->string('title');
        
        // Durum: beklemede, onaylandi, reddedildi
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        
        // Notlar
        $table->text('admin_note')->nullable(); // Admin yüklerken not düşebilir
        $table->text('bayi_note')->nullable();  // Bayi reddederse sebep yazabilir
        
        // İşlem Zamanları
        $table->timestamp('responded_at')->nullable(); // Bayi ne zaman cevap verdi?
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bayi_earnings');
    }
};
