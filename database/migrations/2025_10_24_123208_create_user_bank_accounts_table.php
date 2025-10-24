<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration'ı çalıştır.
     */
    public function up(): void
    {
        Schema::create('user_bank_accounts', function (Blueprint $table) {
            $table->id();

            // Bu hesabın hangi kullanıcıya ait olduğunu belirler.
            // users tablosuna 'id' sütunu üzerinden bağlanır.
            // Eğer bir kullanıcı silinirse, ona ait tüm banka hesapları da silinir (onDelete('cascade')).
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Banka Bilgileri
            $table->string('bank_name'); // Örn: "T.C. Ziraat Bankası"
            $table->string('account_holder_name'); // Örn: "İlyo Yıldız"
            
            // IBAN'ı benzersiz (unique) yapıyoruz.
            // Bir IBAN, sistemde sadece bir kullanıcıya ait olabilir.
            $table->string('iban')->unique();

            // Opsiyonel Alanlar (nullable = boş bırakılabilir)
            $table->string('branch_name')->nullable(); // Şube Adı
            $table->string('account_number')->nullable(); // Hesap Numarası

            $table->boolean('status')->default(true); // Bu hesap aktif mi? (Kullanıcı dondurabilir)
            
            $table->timestamps(); // created_at ve updated_at
        });
    }

    /**
     * Migration'ı geri al (rollback).
     */
    public function down(): void
    {
        Schema::dropIfExists('user_bank_accounts');
    }
};