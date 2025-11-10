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
    Schema::create('company_bank_accounts', function (Blueprint $table) {
        $table->id();
        $table->string('bank_name'); // Ziraat Bankası
        $table->string('account_holder_name'); // Hesap Sahibi
        $table->string('iban');
        $table->string('account_number')->nullable(); // Opsiyonel
        $table->string('branch_name')->nullable(); // Opsiyonel
        $table->boolean('is_active')->default(true); // Göster/Gizle
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_bank_accounts');
    }
};
