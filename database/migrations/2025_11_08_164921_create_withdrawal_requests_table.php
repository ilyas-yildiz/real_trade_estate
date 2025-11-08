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
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();
            
            // Hangi kullanıcı talep etti?
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Ne kadar çekmek istiyor?
            $table->decimal('amount', 10, 2);
            
            // Parayı nereye istiyor? (Polimorfik ilişki)
            // method_id -> BankAccount veya CryptoWallet tablosundaki ID
            // method_type -> 'App\Models\BankAccount' veya 'App\Models\CryptoWallet'
            $table->morphs('method'); 
            
            // Talebin durumu (pending, approved, rejected)
            $table->string('status')->default('pending');
            
            // Adminin notu (Red/Onay sebebi)
            $table->text('admin_notes')->nullable();
            
            // Hangi admin inceledi?
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            
            // Ne zaman incelendi?
            $table->timestamp('reviewed_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawal_requests');
    }
};