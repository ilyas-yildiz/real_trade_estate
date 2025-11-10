<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('company_crypto_wallets', function (Blueprint $table) {
        $table->id();
        $table->string('wallet_type'); // USDT
        $table->string('network'); // TRC20, ERC20 vb.
        $table->text('wallet_address'); // Cüzdan adresi
        $table->text('notes')->nullable(); // Opsiyonel (örn: "Sadece TRC20 ağı kullanın")
        $table->boolean('is_active')->default(true); // Göster/Gizle
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_crypto_wallets');
    }
};
