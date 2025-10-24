<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// GÜNCELLEME: Storage facade'ı artık dosya varlığını kontrol etmek için lazım.
use Illuminate\Support\Facades\Storage;
// GÜNCELLEME: File facade'ına artık burada gerek yok.
// use Illuminate\Support\Facades\File;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'payment_date',
        'reference_number',
        'receipt_path',
        'user_notes',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
        'reviewed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Dekont dosyasını güvenli bir şekilde görüntülemek için
     * rotanın URL'sini döndüren Accessor.
     * GÜNCELLEME: route() helper'ı kullanıldı.
     *
     * @return string|null
     */
    public function getReceiptUrlAttribute(): ?string
    {
        // GÜNCELLEME: Dosyanın storage/app içinde var olup olmadığını kontrol et ('local' diski)
        if ($this->receipt_path && Storage::disk('local')->exists($this->receipt_path)) {
             // GÜNCELLEME: asset() yerine route() kullanarak güvenli görüntüleme rotasını oluştur
            return route('admin.payments.showReceipt', $this); // $this, {payment} parametresini otomatik doldurur
        }
        return null;
    }
}