<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
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
     * Kullanıcının blog yazılarını temsil eden ilişki.
     */
    public function blogs(): HasMany // Return type hint ekledim
    {
        return $this->hasMany(Blog::class);
    }

    /**
     * Kullanıcının AI sohbetlerini temsil eden ilişki.
     */
    public function aiChats(): HasMany
    {
        return $this->hasMany(AiChat::class);
    }

    /**
     * Kullanıcının banka hesaplarını temsil eden ilişki.
     */
    public function bankAccounts(): HasMany
    {
        return $this->hasMany(UserBankAccount::class);
    }

    /**
     * Kullanıcının kripto cüzdanlarını temsil eden ilişki.
     */
    public function cryptoWallets(): HasMany
    {
        return $this->hasMany(UserCryptoWallet::class);
    }

    // YENİ EKLENDİ: Ödeme Bildirimleri İlişkisi
    /**
     * Kullanıcının ödeme bildirimlerini temsil eden ilişki.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}