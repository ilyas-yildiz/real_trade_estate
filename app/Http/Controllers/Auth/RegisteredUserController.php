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
use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Kayıt formunu gösterir ve referans kodunu (bayi_id) kontrol eder.
     */
    public function create(Request $request): View
    {
        $bayi_id = null; 
        
        if ($request->has('ref')) {
            $ref_id = $request->query('ref');
            $bayi = User::find($ref_id);
            
            if ($bayi && $bayi->isBayi()) {
                $bayi_id = $bayi->id;
            }
        }
        
        return view('auth.register', compact('bayi_id'));
    }

    /**
     * Gelen kayıt isteğini işler ve kullanıcıyı kaydeder.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            
            'bayi_id' => [
                'nullable', 
                'integer',
                ValidationRule::exists('users', 'id')->where(function ($query) {
                    $query->where('role', 1); 
                }),
            ],
        ]);

        // 1. Özel MT5 ID Oluşturma
        do {
            $digits = rand(100000, 999999); // 6 Rakam
            $upper = Str::upper(Str::random(1)); // 1 Büyük Harf
            $lower = Str::lower(Str::random(1)); // 1 Küçük Harf
            $symbols = ['@', '#', '$', '!', '%', '*', '?']; 
            $symbol = $symbols[array_rand($symbols)];

            $rawId = $digits . $upper . $lower . $symbol;
            $mt5_id = str_shuffle($rawId);

        } while (User::where('mt5_id', $mt5_id)->exists());

        try {
            // 2. Kullanıcıyı Kaydetme (TEK SEFERDE)
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password), // Giriş şifresi (Hash)
                
                'mt5_password' => Crypt::encryptString($request->password), // Görüntülenebilir şifre (Encrypt)
                'mt5_id' => $mt5_id,
                
                'bayi_id' => $request->bayi_id,
                // role varsayılan olarak 0 (Müşteri) gelir
            ]);

            event(new Registered($user));

            Auth::login($user);

            return redirect(route('admin.dashboard', absolute: false));

        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            // Çift tıklama vb. durumunda hata verirse
            return redirect()->route('login')->with('status', 'Kaydınız zaten oluşturuldu, lütfen giriş yapın.');
        }
    }
}