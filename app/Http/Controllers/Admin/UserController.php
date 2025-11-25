<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Notifications\Mt5IdChangedNotification;

class UserController extends Controller
{
    /**
     * Tüm kullanıcıları listeler.
     */
    public function index(Request $request)
    {
        $query = User::latest();

        // İsim veya email ile arama (opsiyonel)
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        // Role göre filtrele (opsiyonel)
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * (Bu modülde create kullanılmayacak)
     */
    public function create()
    {
        return redirect()->route('admin.users.index');
    }

    /**
     * (Bu modülde store kullanılmayacak)
     */
    public function store(Request $request)
    {
         return redirect()->route('admin.users.index');
    }

    /**
     * (Bu modülde show kullanılmayacak)
     */
    public function show(User $user)
    {
        return redirect()->route('admin.users.index');
    }

    /**
     * Modal'da düzenlenecek kullanıcının verisini JSON olarak döndürür.
     */
public function edit(User $user): JsonResponse
    {
        // Şifreyi çöz (varsa)
        try {
            $user->decrypted_mt5_password = $user->mt5_password ? \Illuminate\Support\Facades\Crypt::decryptString($user->mt5_password) : '';
        } catch (\Exception $e) {
            $user->decrypted_mt5_password = 'Şifre Çözülemedi';
        }

        // Veriyi diziye çevir
        $data = $user->toArray();

        // YENİ: Kimlik Kartı Linkini Hazırla
        // Eğer dosya yolu varsa, rotayı oluşturup gönderiyoruz
        $data['id_card_url'] = $user->id_card_path ? route('admin.users.showIdCard', $user->id) : null;

        return response()->json(['item' => $data]);
    }

/**
     * Kullanıcının rolünü ve bilgilerini günceller.
     */
/**
     * Kullanıcının rolünü ve bilgilerini günceller.
     */
    public function update(Request $request, User $user): JsonResponse
    {
        // 1. Validasyon Kuralları
        $validated = $request->validate([
            'role' => ['required', Rule::in([0, 1, 2])],
            'commission_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'mt5_id' => ['required', 'numeric', 'digits:6', Rule::unique('users', 'mt5_id')->ignore($user->id)],
            
            // Hesap Durumu Validasyonu
            'account_status' => ['nullable', Rule::in(['active', 'rejected', 'pending'])],
            // Red sebebi, SADECE durum 'rejected' ise zorunlu olsun
            'rejection_reason' => 'nullable|string|required_if:account_status,rejected',
        ]);

        // 2. Değişkenleri Hazırla
        $newRole = (int) $validated['role'];
        $newCommissionRate = ($newRole === 1) ? $request->input('commission_rate', 0) : 0.00;
        $newMt5Id = $validated['mt5_id'];
        $originalMt5Id = $user->mt5_id;

        // === GÜVENLİK KONTROLLERİ ===
        if ($user->id === Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Kendi rolünüzü değiştiremezsiniz.'], 403);
        }
        if ($user->isAdmin() && $newRole !== 2) {
            $adminCount = User::where('role', 2)->count();
            if ($adminCount <= 1) {
                 return response()->json([
                    'success' => false, 
                    'message' => 'Sistemdeki son adminin rolünü değiştiremezsiniz.'
                ], 403);
            }
        }
        
        // === GÜNCELLEME İŞLEMİ ===
        
        // Hesap Durumu Mantığı
        $oldStatus = $user->account_status;
        $newAccountStatus = $request->input('account_status', $oldStatus);
        // Red sebebini al
        $rejectionReason = $request->input('rejection_reason');

        $user->update([
            'role' => $newRole,
            'commission_rate' => $newCommissionRate,
            'bayi_id' => ($newRole === 1) ? null : $user->bayi_id,
            'mt5_id' => $newMt5Id,
            'account_status' => $newAccountStatus,
        ]);

        // --- BİLDİRİMLER ---

        // A) MT5 ID Değiştiyse
        if ($originalMt5Id != $newMt5Id) {
            $user->notify(new \App\Notifications\Mt5IdChangedNotification($newMt5Id));
        }

        // B) Hesap Durumu Değişimi
        // Durum 'active' olduysa (Onaylandı)
        if ($oldStatus !== 'active' && $newAccountStatus === 'active') {
            $user->notify(new \App\Notifications\AccountApprovedNotification($user));
        }
        
        // C) Durum 'rejected' olduysa (Reddedildi) - DÜZELTİLEN KISIM
        // Durum önceden rejected değilse VE yeni durum rejected ise
        elseif ($newAccountStatus === 'rejected' && $oldStatus !== 'rejected') {
            // Red bildirimini, formdan gelen sebep ile gönder
            $user->notify(new \App\Notifications\AccountRejectedNotification($rejectionReason));
        }

        return response()->json(['success' => true, 'message' => 'Kullanıcı bilgileri güncellendi.']);
    }

    /**
     * (Bu modülde destroy kullanılmayacak)
     */
    public function destroy(User $user)
    {
        return redirect()->route('admin.users.index');
    }

/**
     * Kullanıcının kimlik görselini güvenli şekilde gösterir.
     */
    public function showIdCard(User $user)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        if (!$user->id_card_path || !file_exists(storage_path('app/' . $user->id_card_path))) {
            abort(404, 'Dosya bulunamadı.');
        }
        
        return response()->file(storage_path('app/' . $user->id_card_path));
    }


}