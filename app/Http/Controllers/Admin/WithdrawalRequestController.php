<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalRequest;
use App\Models\User;
use App\Models\UserBankAccount;   // Doğru model
use App\Models\UserCryptoWallet; // Doğru model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse; // YENİ: JSON yanıtı için eklendi

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
     * Kullanıcının yeni çekim talebi oluşturma formunu gösterir.
     */
    public function create()
    {
        if (Auth::user()->isAdmin()) {
             return redirect()->route('admin.withdrawals.index')->with('error', 'Adminler çekim talebi oluşturamaz.');
        }

        $user = Auth::user();
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

        WithdrawalRequest::create([
            'user_id' => $user->id,
            'amount' => $validated['amount'],
            'method_id' => $method_model->id,
            'method_type' => $method_type,
            'status' => 'pending',
        ]);

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
     * YENİ: Modal'da düzenlenecek çekim talebi verisini JSON olarak döndürür.
     */
    public function edit(WithdrawalRequest $withdrawal): JsonResponse // Model otomatik çekilecek
    {
        if (!Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Yetkisiz erişim.'], 403);
        }
        
        $withdrawal->load('user:id,name,email', 'method');

        // resource-handler.js'in doldurması için özel bir dizi oluşturalım
        $data = [
            'status' => $withdrawal->status,
            'admin_notes' => $withdrawal->admin_notes,
            'user_info' => $withdrawal->user ? $withdrawal->user->name . ' (' . $withdrawal->user->email . ')' : 'Kullanıcı Silinmiş',
            'amount_formatted' => number_format($withdrawal->amount, 2, ',', '.'),
            'created_at_formatted' => $withdrawal->created_at->format('d.m.Y H:i'),
            'method_details' => '', // Başlangıçta boş
        ];
        
        // Polimorfik ilişkiyi (method) manuel olarak doldur
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
     * YENİ: Adminin çekim talebini onaylama/reddetme işlemini yapar.
     */
public function update(Request $request, WithdrawalRequest $withdrawal): JsonResponse
    {
        if (!Auth::user()->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Bu işleme yetkiniz yok.'], 403);
        }

        // GÜNCELLEME: 'processing' ve 'pending' durumları da validasyona eklendi.
        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending', 'processing', 'approved', 'rejected'])],
            'admin_notes' => 'nullable|string|max:2000',
        ]);
        
        // TODO: (Hatırlatma) 'approved' durumu için bakiye düşürme işlemi.

        $withdrawal->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'],
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

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