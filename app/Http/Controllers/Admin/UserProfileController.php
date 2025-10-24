<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Temel Controller'ı use ediyoruz (Bu sefer \ ile, Cemo)
use App\Models\UserBankAccount;
use App\Models\UserCryptoWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserProfileController extends Controller
{
    /**
     * Kullanıcının profil sayfasını (banka ve cüzdan bilgileri) gösterir.
     */
    public function index()
    {
        // O an giriş yapmış olan kullanıcıyı al
        $user = Auth::user();

        // Kullanıcının mevcut banka hesaplarını ve cüzdanlarını veritabanından çek
        $bankAccounts = $user->bankAccounts()->latest()->get();
        $cryptoWallets = $user->cryptoWallets()->latest()->get();

        // Verileri view'a gönder
        return view('admin.profile.index', [
            'user' => $user,
            'bankAccounts' => $bankAccounts,
            'cryptoWallets' => $cryptoWallets,
        ]);
    }

    /**
     * Yeni bir banka hesabı ekler.
     */
    public function storeBankAccount(Request $request)
    {
        // Formdan gelen veriyi doğrula
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_holder_name' => 'required|string|max:255',
            // 'iban' alanı user_bank_accounts tablosunda benzersiz (unique) olmalı
            'iban' => 'required|string|max:34|unique:user_bank_accounts,iban',
            'branch_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
        ]);

        // Doğrulanmış veriyi GİRİŞ YAPAN KULLANICIYA bağlayarak kaydet
        // Bu, 'user_id'nin manuel olarak atanmasını sağlar ve güvenlidir.
        Auth::user()->bankAccounts()->create($validated);

        // Başarı mesajıyla geri yönlendir
        return redirect()->route('admin.profile.index')->with('success', 'Banka hesabı başarıyla eklendi.');
    }

    /**
     * Mevcut bir banka hesabını siler.
     */
    public function destroyBankAccount(UserBankAccount $bankAccount)
    {
        // GÜVENLİK KONTROLÜ:
        // Giriş yapan kullanıcı, silmeye çalıştığı bu banka hesabının sahibi mi?
        if (Auth::id() !== $bankAccount->user_id) {
            // Değilse, yetkisi yok. 403 Hatası ver (Forbidden).
            abort(403, 'Bu işleme yetkiniz yok.');
        }

        // Kullanıcı hesabın sahibi, silme işlemini yap
        $bankAccount->delete();

        return redirect()->route('admin.profile.index')->with('success', 'Banka hesabı başarıyla silindi.');
    }

    /**
     * Yeni bir kripto cüzdanı ekler.
     */
    public function storeCryptoWallet(Request $request)
    {
        // Formdan gelen veriyi doğrula
        $validated = $request->validate([
            'wallet_type' => 'required|string|max:100', // Örn: USDT, BTC
            'network' => 'nullable|string|max:100', // Örn: ERC-20, TRC-20
            // 'wallet_address' alanı user_crypto_wallets tablosunda benzersiz (unique) olmalı
            'wallet_address' => 'required|string|max:255|unique:user_crypto_wallets,wallet_address',
        ]);

        // Doğrulanmış veriyi GİRİŞ YAPAN KULLANICIYA bağlayarak kaydet
        Auth::user()->cryptoWallets()->create($validated);

        return redirect()->route('admin.profile.index')->with('success', 'Kripto cüzdanı başarıyla eklendi.');
    }

    /**
     * Mevcut bir kripto cüzdanını siler.
     */
    public function destroyCryptoWallet(UserCryptoWallet $cryptoWallet)
    {
        // GÜVENLİK KONTROLÜ:
        // Giriş yapan kullanıcı, silmeye çalıştığı bu cüzdanın sahibi mi?
        if (Auth::id() !== $cryptoWallet->user_id) {
            // Değilse, yetkisi yok.
            abort(403, 'Bu işleme yetkiniz yok.');
        }

        // Kullanıcı cüzdanın sahibi, sil
        $cryptoWallet->delete();

        return redirect()->route('admin.profile.index')->with('success', 'Kripto cüzdanı başarıyla silindi.');
    }
}