<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
        // resource-handler.js'in formu doldurması için 'item' anahtarıyla
        // 'role' dahil tüm kullanıcı verisini döndürüyoruz.
        return response()->json(['item' => $user]);
    }

    /**
     * Kullanıcının rolünü günceller.
     */
    public function update(Request $request, User $user): JsonResponse
    {
        // 0=Müşteri, 1=Bayi, 2=Admin
        $validated = $request->validate([
            'role' => ['required', Rule::in([0, 1, 2])],
        ]);

        $newRole = (int) $validated['role'];

        // === GÜVENLİK KONTROLLERİ ===

        // 1. Adminin kendi rolünü değiştirmesini engelle
        if ($user->id === Auth::id()) {
            return response()->json([
                'success' => false, 
                'message' => 'Güvenlik nedeniyle kendi rolünüzü değiştiremezsiniz.'
            ], 403);
        }

        // 2. Admin, son kalan Admin'in rolünü değiştirmeye çalışırsa engelle
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
            // Eğer müşteri -> bayi yapılıyorsa, bayi_id'sini sıfırla (Bayi kendi kendinin bayisi olamaz)
            'bayi_id' => $newRole === 1 ? null : $user->bayi_id, 
        ]);

        return response()->json(['success' => true, 'message' => 'Kullanıcı rolü başarıyla güncellendi.']);
    }

    /**
     * (Bu modülde destroy kullanılmayacak)
     */
    public function destroy(User $user)
    {
        return redirect()->route('admin.users.index');
    }
}