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
        Schema::create('user_crypto_wallets', function (Blueprint $table) {
            $table->id();

            // Bu cüzdanın hangi kullanıcıya ait olduğunu belirler.
            // users tablosuna 'id' sütunu üzerinden bağlanır.
            // Eğer bir kullanıcı silinirse, ona ait tüm cüzdanlar da silinir (onDelete('cascade')).
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Cüzdan Bilgileri
            $table->string('wallet_type'); // Örn: "Bitcoin", "Ethereum", "USDT"
            $table->string('network')->nullable(); // Örn: "BTC", "ERC-20", "TRC-20", "BEP-20"
            
            // Cüzdan adresi. IBAN gibi, bu da sistemde benzersiz olmalı.
            $table->string('wallet_address')->unique(); 

            $table->boolean('status')->default(true); // Bu cüzdan aktif mi?
            
            $table->timestamps(); // created_at ve updated_at
        });
    }

    /**
     * Migration'ı geri al (rollback).
     */
    public function down(): void
    {
        Schema::dropIfExists('user_crypto_wallets');
    }
};