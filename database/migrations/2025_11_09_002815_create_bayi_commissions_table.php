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
        Schema::create('bayi_commissions', function (Blueprint $table) {
            $table->id();
            
            // 1. Komisyonu KİM kazandı?
            $table->foreignId('bayi_id')->constrained('users')->onDelete('cascade');
            
            // 2. Komisyonu KİM oluşturdu (hangi müşteri)?
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            
            // 3. Hangi çekim talebi bu komisyonu tetikledi?
            $table->foreignId('withdrawal_request_id')->constrained()->onDelete('cascade');

            // 4. Bilgilendirme amaçlı: Çekim tutarı neydi?
            $table->decimal('withdrawal_amount', 10, 2);
            
            // 5. Bilgilendirme amaçlı: O anki komisyon oranı neydi?
            $table->decimal('commission_rate', 5, 2);
            
            // 6. Bayinin net kazancı (Asıl tutar)
            $table->decimal('commission_amount', 10, 2);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bayi_commissions');
    }
};