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
        Schema::table('users', function (Blueprint $table) {
            // Bayi komisyon oranını (örn: 5.50 -> %5.5) tutar
            // Sadece role=1 olanlar için geçerli olacak
            $table->decimal('commission_rate', 5, 2)->default(0.00)->after('balance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('commission_rate');
        });
    }
};