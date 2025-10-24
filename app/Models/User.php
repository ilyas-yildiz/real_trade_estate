<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; // Bu satır zaten vardı
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// GÜNCELLEME: 'MustVerifyEmail' arayüzünü (interface) ekliyoruz.
// Breeze'in e-posta doğrulama sistemi ('verified' middleware) için bu gereklidir.
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Bu kullanıcının yazdığı blog yazılarını temsil eden ilişki.
     * Bir kullanıcı, birden fazla blog yazısı yazabilir (HasMany).
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function aiChats(): HasMany
    {
        return $this->hasMany(AiChat::class);
    }

    // YENİ EKLENDİ: Banka Hesapları İlişkisi
    /**
     * Kullanıcının banka hesaplarını temsil eden ilişki.
     */
    public function bankAccounts(): HasMany
    {
        return $this->hasMany(UserBankAccount::class);
    }

    // YENİ EKLENDİ: Kripto Cüzdanları İlişkisi
    /**
     * Kullanıcının kripto cüzdanlarını temsil eden ilişki.
     */
    public function cryptoWallets(): HasMany
    {
        return $this->hasMany(UserCryptoWallet::class);
    }
}