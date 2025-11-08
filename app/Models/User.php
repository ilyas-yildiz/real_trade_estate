<?php

namespace App\Models;

// TEMEL 'use' SATIRLARI
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail; // Orijinal modelindeki 'implements' için eklendi

// BAYİLİK SİSTEMİ VE İLİŞKİLER İÇİN GEREKLİ 'use' SATIRLARI
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use App\Models\Payment;
use App\Models\WithdrawalRequest;
use App\Models\UserBankAccount;
use App\Models\UserCryptoWallet;
use App\Models\Blog; // Orijinal modelinde vardı
use App\Models\AiChat; // Orijinal modelinde vardı

// 'Laravel\Sanctum\HasApiTokens' satırı KESİNLİKLE KALDIRILDI

class User extends Authenticatable implements MustVerifyEmail
{
    // DÜZELTME: 'HasApiTokens' trait'i buradan kaldırıldı
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'is_admin' yerine eklendi
        'bayi_id', // YENİ
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * DÜZELTME: Orijinal modelindeki 'casts()' metot yapısı korundu.
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'integer', // Yeni rol sütunu eklendi
        ];
    }

    // ===============================================
    // YENİ: ROL KONTROL METOTLARI
    // ===============================================

    public function isAdmin(): bool
    {
        return $this->role === 2; // 2 = Admin
    }

    public function isBayi(): bool
    {
        return $this->role === 1; // 1 = Bayi
    }

    public function isCustomer(): bool
    {
        return $this->role === 0; // 0 = Müşteri
    }

    // ===============================================
    // YENİ: BAYİ İLİŞKİLERİ
    // ===============================================

    /**
     * Bu müşterinin (kendisi müşteri ise) ait olduğu Bayi.
     */
    public function bayi(): BelongsTo
    {
        return $this->belongsTo(User::class, 'bayi_id');
    }

    /**
     * Bu bayinin (kendisi bayi ise) sahip olduğu müşteriler.
     */
    public function customers(): HasMany
    {
        return $this->hasMany(User::class, 'bayi_id');
    }
    
    /**
     * Bu bayinin müşterilerinin çekim talepleri (HasManyThrough).
     */
    public function customerWithdrawals(): HasManyThrough
    {
        return $this->hasManyThrough(
            WithdrawalRequest::class, // Ulaşmak istediğimiz son model
            User::class,              // Aradaki model
            'bayi_id',                // Aradaki model'deki (User) foreign key
            'user_id'                 // Son model'deki (WithdrawalRequest) foreign key
        );
    }
    
    // ===============================================
    // MEVCUT TÜM İLİŞKİLER
    // ===============================================

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function withdrawalRequests(): HasMany
    {
        return $this->hasMany(WithdrawalRequest::class);
    }
    
    public function bankAccounts(): HasMany
    {
        return $this->hasMany(UserBankAccount::class);
    }

    public function cryptoWallets(): HasMany
    {
        return $this->hasMany(UserCryptoWallet::class);
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }

    public function aiChats(): HasMany
    {
        return $this->hasMany(AiChat::class);
    }
}