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
        $table->string('mt5_id')->nullable()->unique()->after('email'); // Özel ID
        $table->text('mt5_password')->nullable()->after('password'); // Şifrelenmiş (Görülebilir) Şifre
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['mt5_id', 'mt5_password']);
    });
}
};
