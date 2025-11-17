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
        // Admin olduğu için şifreyi çözüp 'decrypted_mt5_password' anahtarıyla gönderiyoruz.
        // Eğer şifre yoksa boş göndeririz.
        try {
            $user->decrypted_mt5_password = $user->mt5_password ? \Illuminate\Support\Facades\Crypt::decryptString($user->mt5_password) : '';
        } catch (\Exception $e) {
            $user->decrypted_mt5_password = 'Şifre Çözülemedi';
        }

        return response()->json(['item' => $user]);
    }

 /**
     * Kullanıcının rolünü günceller.
     * YENİ: Komisyon oranı eklendi.
     */
    public function update(Request $request, User $user): JsonResponse
    {
        // 0=Müşteri, 1=Bayi, 2=Admin
        $validated = $request->validate([
            'role' => ['required', Rule::in([0, 1, 2])],
            // YENİ: Komisyon oranı doğrulaması eklendi (%0 ile %100 arası)
            'commission_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'mt5_id' => ['required', 'numeric', 'digits:6', Rule::unique('users', 'mt5_id')->ignore($user->id)],
        ]);

        $newRole = (int) $validated['role'];
        // Formdan gelen oranı al, eğer rol Bayi değilse veya boşsa 0 yap
        $newCommissionRate = ($newRole === 1) ? $request->input('commission_rate', 0) : 0.00;

        // === GÜVENLİK KONTROLLERİ ===
        if ($user->id === Auth::id()) {
            return response()->json([
                'success' => false, 
                'message' => 'Güvenlik nedeniyle kendi rolünüzü değiştiremezsiniz.'
            ], 403);
        }
        if ($user->isAdmin() && $newRole !== 2) {
            $adminCount = User::where('role', 2)->count();
            if ($adminCount <= 1) {
                 return response()->json([
                    'success' => false, 
                    'message' => 'Sistemdeki son adminin rolünü değiştiremezsiniz. Önce başka bir kullanıcıyı admin yapmalısınız.'
                ], 403);
            }
        }
        
        // === GÜNCELLEME İŞLEMİ ===
      $user->update([
            'role' => $newRole,
            'commission_rate' => $newCommissionRate,
            'bayi_id' => ($newRole === 1) ? null : $user->bayi_id,
            'mt5_id' => $newMt5Id, // Güncelle
        ]);

// Eğer MT5 ID değiştiyse bildirim gönder
        if ($originalMt5Id != $newMt5Id) {
            $user->notify(new Mt5IdChangedNotification($newMt5Id));
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
}