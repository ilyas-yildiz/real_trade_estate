<?php

namespace App\Http\Controllers\Admin;
use App\Notifications\NewWithdrawalNotification;
use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;
use App\Models\User;
use App\Models\UserBankAccount;
use App\Models\UserCryptoWallet;
use App\Models\BayiCommission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Exception;
use App\Notifications\WithdrawalResultNotification;

class WithdrawalRequestController extends Controller
{
    /**
     * Çekim taleplerini listeler.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = WithdrawalRequest::with('user', 'reviewer', 'method')->latest();

        if ($user->isAdmin()) {
            
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('user_id')) {
                $query->where('user_id', $request->user_id);
            }
            $withdrawals = $query->paginate(15);
            $users = User::orderBy('name')->get();
            return view('admin.withdrawals.index_admin', compact('withdrawals', 'users'));
        } else {
            $withdrawals = $query->where('user_id', $user->id)->paginate(10);
            return view('admin.withdrawals.index_user', compact('withdrawals'));
        }
    }

    /**
     * GÜNCELLENDİ: Kullanıcının yeni çekim talebi oluşturma formunu gösterir.
     */
    public function create()
    {
        // HATA DÜZELTMESİ: isAdmin -> isAdmin()
        if (Auth::user()->isAdmin()) {
             return redirect()->route('admin.withdrawals.index')->with('error', 'Adminler çekim talebi oluşturamaz.');
        }

        $user = Auth::user();

        /*
        // YENİ ÖZELLİK: Bakiye Kontrolü
        if ($user->balance <= 0) {
            return redirect()->route('admin.withdrawals.index')->with('error', 'Çekim talebi oluşturmak için yeterli bakiyeniz bulunmamaktadır.');
        }
        */
        
        $bankAccounts = $user->bankAccounts;
        $cryptoWallets = $user->cryptoWallets;

        if ($bankAccounts->isEmpty() && $cryptoWallets->isEmpty()) {
            return redirect()->route('admin.profile.index')->with('error', 'Çekim talebi oluşturabilmek için lütfen önce bir banka hesabı veya kripto cüzdanı ekleyin.');
        }

        return view('admin.withdrawals.create', compact('bankAccounts', 'cryptoWallets'));
    }

    /**
     * Kullanıcının gönderdiği yeni çekim talebini kaydeder.
     */
 /**
     * Kullanıcının gönderdiği yeni çekim talebini kaydeder.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            abort(403, 'Adminler çekim talebi oluşturamaz.');
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:10', 
            'payment_method' => 'required|string|starts_with:bank-,crypto-',
        ]);
        
        // Bakiye Kontrolü (Şu an pasif olsa da kodda duruyor, uncomment edilirse çalışır)
        /*
        $amountToWithdraw = $validated['amount'];
        if ($user->balance < $amountToWithdraw) {
            return back()->with('error', 'Yetersiz bakiye.')->withInput();
        }
        */

        try {
            list($type, $id) = explode('-', $validated['payment_method'], 2);
        } catch (\Exception $e) {
            return back()->with('error', 'Geçersiz ödeme yöntemi formatı.');
        }
        
        $method_type = null;
        $method_model = null;

        if ($type === 'bank') {
            $method_type = 'App\Models\UserBankAccount';
            $method_model = $user->bankAccounts()->find($id); 
        } elseif ($type === 'crypto') {
            $method_type = 'App\Models\UserCryptoWallet';
            $method_model = $user->cryptoWallets()->find($id);
        }

        if (!$method_model) {
            return back()->with('error', 'Seçilen ödeme yöntemi geçersiz veya size ait değil.');
        }

        // === DÜZELTME BURADA ===
        // Kaydı oluşturup $withdrawal değişkenine atıyoruz
        $withdrawal = WithdrawalRequest::create([
            'user_id' => $user->id,
            'amount' => $validated['amount'],
            'method_id' => $method_model->id,
            'method_type' => $method_type,
            'status' => 'pending',
        ]);
        // === DÜZELTME SONU ===

        // Adminlere Bildirim Gönder
        $admins = User::where('role', 2)->get();
        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\NewWithdrawalNotification([
                'user_name' => $user->name,
                'amount' => $validated['amount'],
                'withdrawal_id' => $withdrawal->id, // Artık bu değişken dolu
            ]));
        }

        return redirect()->route('admin.withdrawals.index')->with('success', 'Çekim talebiniz başarıyla alındı.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('admin.withdrawals.index');
    }

    /**
     * Modal'da düzenlenecek çekim talebi verisini JSON olarak döndürür.
     */
    public function edit(WithdrawalRequest $withdrawal): JsonResponse
    {
        if (!Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Yetkisiz erişim.'], 403);
        }
        
        $withdrawal->load('user:id,name,email', 'method');
        
        $data = [
            'status' => $withdrawal->status,
            'admin_notes' => $withdrawal->admin_notes,
            'user_info' => $withdrawal->user ? $withdrawal->user->name . ' (' . $withdrawal->user->email . ')' : 'Kullanıcı Silinmiş',
            'amount_formatted' => number_format($withdrawal->amount, 2, ',', '.'),
            'created_at_formatted' => $withdrawal->created_at->format('d.m.Y H:i'),
            'method_details' => '',
        ];
        
        if ($withdrawal->method) {
            if ($withdrawal->method_type == 'App\Models\UserBankAccount') {
                $data['method_details'] = '[Banka] ' . $withdrawal->method->bank_name . ' - ' . $withdrawal->method->iban . ' (Alıcı: ' . $withdrawal->method->account_holder_name . ')';
            } elseif ($withdrawal->method_type == 'App\Models\UserCryptoWallet') {
                $data['method_details'] = '[Kripto] ' . $withdrawal->method->network . ' - ' . $withdrawal->method->wallet_address;
            }
        } else {
             $data['method_details'] = 'HATA: İlişkili ödeme yöntemi silinmiş!';
        }

        return response()->json(['item' => $data]);
    }

/**
     * GÜNCELLENDİ: Adminin çekim talebini onaylama/reddetme işlemini yapar.
     * Bakiye ve Komisyon mantığı şirket isteği üzerine PASİFE ALINDI.
     */
    public function update(Request $request, WithdrawalRequest $withdrawal): JsonResponse
    {
        if (!Auth::user()->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Bu işleme yetkiniz yok.'], 403);
        }

        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending', 'processing', 'approved', 'rejected'])],
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $originalStatus = $withdrawal->getOriginal('status');
        $newStatus = $validated['status'];
        
        // Statü değişmediyse hiçbir şey yapma
        if ($originalStatus === $newStatus) {
            return response()->json(['success' => true, 'message' => 'Durum zaten aynı, işlem yapılmadı.']);
        }

        try {
            // DB::transaction'ı koruyoruz, çünkü statü güncelleme işleminin
            // güvenli (atomic) olmasını sağlar.
            DB::transaction(function () use ($withdrawal, $newStatus, $originalStatus, $validated) {
                
                // ==========================================================
                // BAKIYE VE KOMİSYON MANTIĞI PASİFE ALINDI (BAŞLANGIÇ)
                // ==========================================================
                /*
                // Bu değişkenler artık sadece bu pasif blokta gerekli
                $customer = $withdrawal->user;
                $amount = $withdrawal->amount;

                // 1. Durum "Onaylandı" olarak DEĞİŞTİYSE
                if ($newStatus === 'approved') {
                    
                    $customerForUpdate = User::where('id', $customer->id)->lockForUpdate()->first();
                    
                    if ($customerForUpdate->balance < $amount) {
                        throw new Exception('İşlem Başarısız! Müşterinin bakiyesi ('.$customerForUpdate->balance.') talep edilen tutardan ('.$amount.') az.');
                    }
                    
                    $customerForUpdate->decrement('balance', $amount);

                    if ($customer->bayi_id && $customer->bayi->commission_rate > 0) {
                        $bayi = $customer->bayi;
                        $rate = $bayi->commission_rate;
                        $commissionAmount = ($amount * $rate) / 100;

                        $bayi->increment('balance', $commissionAmount);

                        BayiCommission::create([
                            'bayi_id' => $bayi->id,
                            'customer_id' => $customer->id,
                            'withdrawal_request_id' => $withdrawal->id,
                            'withdrawal_amount' => $amount,
                            'commission_rate' => $rate,
                            'commission_amount' => $commissionAmount,
                        ]);
                    }
                }
                
                // 2. Durum "Onaylandı"dan başka bir şeye DEĞİŞTİYSE (İptal/Reversal)
                elseif ($originalStatus === 'approved') {
                    
                    $customer->increment('balance', $amount);
                    $commissionLog = $withdrawal->bayiCommission;
                    
                    if ($commissionLog) {
                        $bayi = $commissionLog->bayi;
                        $commissionAmount = $commissionLog->commission_amount;
                        
                        if ($bayi) {
                            $bayi->decrement('balance', $commissionAmount);
                        }
                        
                        $commissionLog->delete();
                    }
                }
                */
                // ==========================================================
                // BAKIYE VE KOMİSYON MANTIĞI PASİFE ALINDI (SON)
                // ==========================================================


               $withdrawal->update([
                    'status' => $validated['status'],
                    'admin_notes' => $validated['admin_notes'],
                    'reviewed_by' => Auth::id(),
                    'reviewed_at' => now(),
                ]);

                // 2. YENİ: Müşteriye Bildirim Gönder (Sadece Onay veya Red durumunda)
                // Transaction içinde yapıyoruz ki işlem başarılıysa bildirim gitsin.
                if (in_array($validated['status'], ['approved', 'rejected', 'processing'])) {
                    
                    $withdrawal->user->notify(new WithdrawalResultNotification($validated['status'], $withdrawal->amount));
                }

            }); // DB::transaction sonu
        } catch (Exception $e) {
            // (Pasife alınan kod hata fırlatsaydı burası çalışırdı, 
            // şimdilik sadece statü güncelleme hatası için duruyor)
            return response()->json([
                'success' => false, 
                'message' => 'Hata: ' . $e->getMessage()
            ], 422);
        }

        return response()->json(['success' => true, 'message' => 'Çekim talebi durumu başarıyla güncellendi.']);
    }

    /**
     * Bir çekim talebini siler (İptal eder).
     */
    public function destroy(WithdrawalRequest $withdrawal)
    {
        $user = Auth::user();

        if ($user->isAdmin() || ($withdrawal->user_id === $user->id && $withdrawal->status === 'pending')) {
            
            $withdrawal->delete();
            return redirect()->route('admin.withdrawals.index')->with('success', 'Talep başarıyla silindi/iptal edildi.');
        }

        abort(403, 'Bu işleme yetkiniz yok.');
    }
}