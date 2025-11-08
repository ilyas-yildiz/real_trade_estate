<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WithdrawalRequest extends Model
{
    use HasFactory;

    /**
     * Toplu atamaya izin verilen alanlar.
     */
    protected $fillable = [
        'user_id',
        'amount',
        'method_id',
        'method_type',
        'status',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
    ];

    /**
     * Otomatik tip dönüşümleri.
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Talebi yapan kullanıcı.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Talebi inceleyen admin.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Talep edilen ödeme yöntemi (Banka veya Kripto).
     */
    public function method(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * YENİ: Bu çekim talebinin oluşturduğu komisyon kaydı.
     */
    public function bayiCommission(): HasOne
    {
        return $this->hasOne(BayiCommission::class);
    }
}