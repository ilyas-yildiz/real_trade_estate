<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Temel Controller'ı use ediyoruz (Bu sefer \ ile, Cemo)
use App\Models\UserBankAccount;
use App\Models\UserCryptoWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Models\PasswordChangeRequest; 
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Notifications\NewPasswordRequestNotification;

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

public function statement(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;

        // Farklı tablolardan (Payments, Withdrawals, Commissions)
        // 'tarih', 'tip', 'aciklama' ve 'tutar' (+/-) sütunlarını seçeceğiz.
        
        // 1. Para Çekme İşlemleri (Tüm roller için ortak - Negatif tutar)
        $withdrawals = DB::table('withdrawal_requests')
            ->where('user_id', $userId)
            ->where('status', 'approved')
            ->select(
                'reviewed_at as date', // Onaylanma tarihi
                DB::raw("'Çekim Talebi' as type"),
                DB::raw("CONCAT('Çekim Talebi #', id) as description"),
                DB::raw("-amount as amount") // Tutarı NEGATİF olarak al
            );

        // 2. Role göre diğer işlemleri belirle
        if ($user->isCustomer()) {
            // =========================
            // MÜŞTERİ SORGULARI
            // =========================
            
            // Para Yatırma İşlemleri (Pozitif tutar)
            $deposits = DB::table('payments')
                ->where('user_id', $userId)
                ->where('status', 'approved')
                ->select(
                    'reviewed_at as date',
                    DB::raw("'Ödeme Bildirimi' as type"),
                    DB::raw("CONCAT('Ödeme Bildirimi #', id) as description"),
                    'amount' // Tutar POZİTİF
                );
            
            // Müşteri için toplamları hesapla
            $totalDeposits = $user->payments()->where('status', 'approved')->sum('amount');
            $totalWithdrawals = $user->withdrawalRequests()->where('status', 'approved')->sum('amount');
            $totalCommissions = 0; // Müşteri komisyon kazanmaz

            // İki sorguyu birleştir
            $transactionsQuery = $deposits->unionAll($withdrawals);

        } else if ($user->isBayi()) {
            // =========================
            // BAYİ SORGULARI
            // =========================

            // Komisyon Kazançları (Pozitif tutar)
            $commissions = DB::table('bayi_commissions')
                ->where('bayi_id', $userId)
                ->select(
                    'created_at as date', // Oluşturulma tarihi
                    DB::raw("'Komisyon Kazancı' as type"),
                    DB::raw("CONCAT('Müşteri #', customer_id, ' / İşlem #', withdrawal_request_id) as description"),
                    'commission_amount as amount' // Tutar POZİTİF
                );

            // Bayi için toplamları hesapla
            $totalDeposits = 0; // Bayi ödeme bildirimi yapmaz (şimdilik)
            $totalWithdrawals = $user->withdrawalRequests()->where('status', 'approved')->sum('amount');
            $totalCommissions = $user->commissions()->sum('commission_amount');

            // İki sorguyu birleştir
            $transactionsQuery = $commissions->unionAll($withdrawals);
        }

        // 3. Birleştirilmiş sorguyu tarih sırasına göre sırala ve sayfala
        $transactions = $transactionsQuery
                        ->orderBy('date', 'desc')
                        ->paginate(20);

        return view('admin.profile.statement', [
            'transactions' => $transactions,
            'totalDeposits' => $totalDeposits,
            'totalWithdrawals' => $totalWithdrawals,
            'totalCommissions' => $totalCommissions,
        ]);
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

    public function requestPasswordChange(Request $request)
    {
        $request->validate([
            'new_password' => 'required|confirmed|min:8',
        ]);

        // Bekleyen bir talep var mı kontrol et
        $pending = PasswordChangeRequest::where('user_id', Auth::id())->where('status', 'pending')->first();
        if ($pending) {
            return back()->with('error', 'Zaten bekleyen bir şifre değişikliği talebiniz var.');
        }

        $passwordRequest = PasswordChangeRequest::create([
            'user_id' => Auth::id(),
            'new_password_encrypted' => Crypt::encryptString($request->new_password),
            'status' => 'pending'
        ]);

// YENİ: Tüm Adminlere Bildirim Gönder (ID ile birlikte)
        $admins = User::where('role', 2)->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewPasswordRequestNotification([
                'user_name' => Auth::user()->name,
                'request_id' => $passwordRequest->id, // YENİ: ID Eklendi
            ]));
        }

        return back()->with('success', 'Şifre değişikliği talebiniz alındı. Yönetici onayladığında güncellenecektir.');
    }
}