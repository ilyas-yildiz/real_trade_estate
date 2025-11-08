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
            // Bayi_id'den sonra 'balance' adında, 10 haneli (2'si ondalık)
            // ve varsayılan değeri 0.00 olan bir sütun ekliyoruz.
            $table->decimal('balance', 10, 2)->default(0.00)->after('bayi_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('balance');
        });
    }
};