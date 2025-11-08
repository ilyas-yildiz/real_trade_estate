<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BayiCommission extends Model
{
    use HasFactory;

    /**
     * Toplu atamaya izin verilen alanlar.
     */
    protected $fillable = [
        'bayi_id',
        'customer_id',
        'withdrawal_request_id',
        'withdrawal_amount',
        'commission_rate',
        'commission_amount',
    ];

    /**
     * Otomatik tip dönüşümleri.
     */
    protected $casts = [
        'withdrawal_amount' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'commission_amount' => 'decimal:2',
    ];

    /**
     * Bu komisyonu kazanan Bayi.
     */
    public function bayi(): BelongsTo
    {
        return $this->belongsTo(User::class, 'bayi_id');
    }

    /**
     * Bu komisyonu oluşturan Müşteri.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Bu komisyonu tetikleyen çekim talebi.
     */
    public function withdrawalRequest(): BelongsTo
    {
        return $this->belongsTo(WithdrawalRequest::class);
    }
}