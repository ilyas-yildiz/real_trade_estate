<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCryptoWallet extends Model
{
    use HasFactory;

    /**
     * Formdan toplu atama (mass assignment) ile doldurulabilen alanlar.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // 'user_id' GÜVENLİK nedeniyle burada DEĞİL.
        'wallet_type',
        'network',
        'wallet_address',
        'status',
    ];

    /**
     * Bu cüzdanın ait olduğu kullanıcı (User modeline ilişki).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}