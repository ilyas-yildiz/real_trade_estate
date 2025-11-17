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
use App\Notifications\NewUserNotification; // YENİ: Bildirim sınıfı eklendi

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
            // Şifre validasyonu yok çünkü biz üretiyoruz
            
            'bayi_id' => [
                'nullable', 
                'integer',
                ValidationRule::exists('users', 'id')->where(function ($query) {
                    $query->where('role', 1); 
                }),
            ],
        ]);

        // 1. Özel Şifre Oluşturma (DÜZELTİLDİ)
        // Kesin Kural: 6 Rakam + 1 Büyük Harf + 1 Küçük Harf + 1 Sembol = 9 Karakter
        
        // A) 6 tane Rakam
        $digits = '';
        for ($i = 0; $i < 6; $i++) {
            $digits .= rand(0, 9);
        }

        // B) 1 tane Büyük Harf (Kesinlikle harf havuzundan)
        $upperPool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $upper = $upperPool[rand(0, strlen($upperPool) - 1)];

        // C) 1 tane Küçük Harf (Kesinlikle harf havuzundan)
        $lowerPool = 'abcdefghijklmnopqrstuvwxyz';
        $lower = $lowerPool[rand(0, strlen($lowerPool) - 1)];

        // D) 1 tane Sembol
        $symbolsPool = ['@', '#', '$', '!', '%', '*', '?']; 
        $symbol = $symbolsPool[array_rand($symbolsPool)];
        
        // Hepsini birleştir ve karıştır
        $generatedPassword = str_shuffle($digits . $upper . $lower . $symbol);


        // 2. MT5 ID Oluşturma (Sadece 6 rakam ve Unique)
        do {
            $mt5_id = (string) rand(100000, 999999);
        } while (User::where('mt5_id', $mt5_id)->exists());

        try {
            // 3. Kullanıcıyı Kaydetme
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($generatedPassword), // Giriş şifresi (Hash)
                
                'mt5_password' => Crypt::encryptString($generatedPassword), // Görüntülenebilir şifre (Encrypt)
                'mt5_id' => $mt5_id,
                
                'bayi_id' => $request->bayi_id,
                // role varsayılan olarak 0 (Müşteri) gelir
            ]);

            event(new Registered($user));

            Auth::login($user);

            // 4. YENİ: Adminlere Bildirim Gönder (DÜZELTİLDİ - EKLENDİ)
            $admins = User::where('role', 2)->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewUserNotification([
                    'user_name' => $user->name,
                    'user_id' => $user->id,
                ]));
            }

            // Dashboard'a gidince kullanıcı şifresini orada görecek
            return redirect(route('admin.dashboard', absolute: false))->with('success', 'Kaydınız oluşturuldu. Şifreniz otomatik olarak belirlendi, panelinizden görebilirsiniz.');

        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            return redirect()->route('login')->with('status', 'Kaydınız zaten oluşturuldu, lütfen giriş yapın.');
        }
    }
}