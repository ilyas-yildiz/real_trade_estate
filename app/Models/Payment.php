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
        'user_id',          // create metodunda 'user_id' dolaylı olarak (payments() ilişkisi) ekleniyor, ama burada olması iyidir.
        'amount',
        'payment_date',
        'reference_number',
        'receipt_path',
        'user_notes',
        'status',
        
        // --- UPDATE METODU İÇİN EKLENMESİ GEREKEN ALANLAR ---
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'payment_date' => 'datetime',
        'reviewed_at' => 'datetime',
        'amount' => 'decimal:2', // Tutar için 'decimal' cast'i kullanmak iyi bir pratiktir
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