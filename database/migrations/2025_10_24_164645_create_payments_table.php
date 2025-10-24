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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Ödemeyi yapan kullanıcı (users tablosuna bağlı)
            // Kullanıcı silinirse ödeme kayıtları kalsın (onDelete('set null')) ya da
            // isteğe bağlı olarak cascade de yapılabilir. Şimdilik null yapalım.
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            // Ödeme Bilgileri (Kullanıcının Girdiği)
            $table->decimal('amount', 15, 2); // Tutar (örn: 1500.50)
            $table->date('payment_date');    // Kullanıcının ödeme yaptığını belirttiği tarih
            $table->string('reference_number')->nullable(); // Opsiyonel referans no
            $table->string('receipt_path'); // Yüklenen dekont dosyasının yolu (örn: 'receipts/dekont_abc.pdf')
            $table->text('user_notes')->nullable(); // Kullanıcının eklemek istediği notlar

            // Admin İnceleme Bilgileri
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Ödeme durumu
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null'); // İnceleyen admin (users tablosuna bağlı)
            $table->timestamp('reviewed_at')->nullable(); // İnceleme tarihi
            $table->text('admin_notes')->nullable(); // Adminin inceleme notları

            $table->timestamps(); // created_at (bildirim tarihi), updated_at
        });
    }

    /**
     * Migration'ı geri al (rollback).
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};