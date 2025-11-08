<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\Rule as ValidationRule; // YENİ: Rule import'u eklendi

class RegisteredUserController extends Controller
{
    /**
     * YENİ: Kayıt formunu gösterir ve referans kodunu (bayi_id) kontrol eder.
     */
    public function create(Request $request): View
    {
        $bayi_id = null; // Varsayılan
        
        // 1. URL'de 'ref' parametresi var mı? (örn: /register?ref=123)
        if ($request->has('ref')) {
            $ref_id = $request->query('ref');
            
            // 2. Bu ID'ye sahip bir kullanıcı var mı VE bu kullanıcı Bayi mi (role=1)?
            $bayi = User::find($ref_id);
            
            if ($bayi && $bayi->isBayi()) {
                $bayi_id = $bayi->id;
            }
        }
        
        // 3. 'bayi_id'yi view'a gönder
        return view('auth.register', compact('bayi_id'));
    }

    /**
     * YENİ: Gelen kayıt isteğini işler ve 'bayi_id'yi kaydeder.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            
            // 4. Gizli 'bayi_id' alanını doğrula
            'bayi_id' => [
                'nullable', // Boş olabilir (normal kayıt)
                'integer',  // Sayı olmalı
                // Gönderilen ID'nin 'users' tablosunda var olduğunu
                // VE o kullanıcının 'role'ünün 1 (Bayi) olduğunu doğrula
                ValidationRule::exists('users', 'id')->where(function ($query) {
                    $query->where('role', 1); 
                }),
            ],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // 5. Doğrulanmış bayi_id'yi kaydet
            'bayi_id' => $request->bayi_id, 
            // 'role' alanı varsayılan olarak 0 (Müşteri) olacak (migration'da belirledik)
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('admin.dashboard', absolute: false)); // 'admin.dashboard'a yönlendir
    }
}