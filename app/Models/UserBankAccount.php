<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBankAccount extends Model
{
    use HasFactory;

    /**
     * Formdan toplu atama (mass assignment) ile doldurulabilen alanlar.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // 'user_id' GÜVENLİK nedeniyle burada DEĞİL.
        // Controller içinde Auth::id() ile manuel olarak atanacak.
        'bank_name',
        'account_holder_name',
        'iban',
        'branch_name',
        'account_number',
        'status',
    ];

    /**
     * Bu banka hesabının ait olduğu kullanıcı (User modeline ilişki).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}