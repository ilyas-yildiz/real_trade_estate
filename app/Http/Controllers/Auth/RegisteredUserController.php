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
            'phone' => ['required', 'string', 'max:20'], // YENİ
            'id_card' => ['required', 'image', 'max:5120'], // YENİ: Max 5MB resim
            'bayi_id' => [
                'nullable', 
                'integer',
                ValidationRule::exists('users', 'id')->where(function ($query) {
                    $query->where('role', 1); 
                }),
            ],
        ]);

        // Kimlik yükleme
        $idCardPath = $request->file('id_card')->store('id_cards', 'local'); // Güvenli klasöre kaydet

        // Şifre ve ID oluşturma (Eski kodun aynısı)
        // ... (digits, upper, lower, symbol, mt5_id döngüsü aynı kalsın) ...
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

        do {
            $mt5_id = (string) rand(100000, 999999);
        } while (User::where('mt5_id', $mt5_id)->exists());
        // ... (Bitiş) ...

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone, // YENİ
                'id_card_path' => $idCardPath, // YENİ
                'account_status' => 'pending', // YENİ: Beklemede
                
                'password' => Hash::make($generatedPassword),
                'mt5_password' => Crypt::encryptString($generatedPassword),
                'mt5_id' => $mt5_id,
                'bayi_id' => $request->bayi_id,
            ]);

            event(new Registered($user));

            // DİKKAT: Auth::login($user); SATIRINI SİLDİK. 
            // Kullanıcı otomatik giriş yapmamalı.

            // Adminlere "Yeni Üye" bildirimi gönder (Mevcut kodun aynısı)
            $admins = User::where('role', 2)->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewUserNotification([
                    'user_name' => $user->name,
                    'user_id' => $user->id,
                ]));
            }

            // Login sayfasına yönlendir ve mesaj göster
            return redirect()->route('login')->with('status', 'Başvurunuz alındı. Yöneticilerimiz kimlik bilgilerinizi inceledikten sonra giriş bilgileriniz E-Posta adresinize gönderilecektir.');

        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            return redirect()->route('login')->with('status', 'Bu bilgilerle zaten bir kayıt mevcut.');
        }
    }
}