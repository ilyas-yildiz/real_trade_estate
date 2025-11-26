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
            'phone' => ['required', 'string', 'max:20'],
            'id_card' => ['required', 'image', 'max:5120'],
            'bayi_id' => [
                'nullable', 
                'integer',
                ValidationRule::exists('users', 'id')->where(function ($query) {
                    $query->where('role', 1); 
                }),
            ],
        ]);

        // Dosya Yükleme
        $file = $request->file('id_card');
        $filename = time() . '_' . \Illuminate\Support\Str::random(10) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/id_cards'), $filename);
        $idCardPath = 'uploads/id_cards/' . $filename;

        // ---------------------------------------------------------
        // 1. ÖZEL ŞİFRE OLUŞTURMA (YENİ MANTIK)
        // ---------------------------------------------------------
        
        // A) 6 tane Rakam
        $digits = '';
        for ($i = 0; $i < 6; $i++) {
            $digits .= rand(0, 9);
        }

        // B) 1 tane Büyük Harf
        $upperPool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $upper = $upperPool[rand(0, strlen($upperPool) - 1)];

        // C) 1 tane Küçük Harf
        $lowerPool = 'abcdefghijklmnopqrstuvwxyz';
        $lower = $lowerPool[rand(0, strlen($lowerPool) - 1)];

        // D) Soru İşareti (?) Yerleşimi
        // Önce elimizdeki 8 karakteri (6 rakam + 2 harf) birleştirip karıştıralım
        $baseString = str_shuffle($digits . $upper . $lower); // 8 Karakter

        // Soru işaretini 1. indeks ile 7. indeks arasına rastgele yerleştir.
        // 0. indeks (Baş) ve 8. indeks (Son) HARİÇ tutulur.
        // Örn: A123456b (8 char). 
        // Ekleme noktası 1 olursa: A?123456b (2. karakter olur)
        // Ekleme noktası 7 olursa: A123456?b (Sondan 2. karakter olur)
        $randomPosition = rand(1, 7);
        
        // substr_replace(string, eklenecek, nereye, kaç_karakter_silinsin)
        $generatedPassword = substr_replace($baseString, '?', $randomPosition, 0);
        
        // ---------------------------------------------------------
        // 2. MT5 ID OLUŞTURMA
        // ---------------------------------------------------------
        do {
            $mt5_id = (string) rand(100000, 999999);
        } while (User::where('mt5_id', $mt5_id)->exists());


        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'id_card_path' => $idCardPath,
                'account_status' => 'pending',
                
                'password' => Hash::make($generatedPassword),
                'mt5_password' => Crypt::encryptString($generatedPassword),
                'mt5_id' => $mt5_id,
                'bayi_id' => $request->bayi_id,
            ]);

            event(new Registered($user));

            // Adminlere Bildirim
            $admins = User::where('role', 2)->get();
            foreach ($admins as $admin) {
                $admin->notify(new NewUserNotification([
                    'user_name' => $user->name,
                    'user_id' => $user->id,
                ]));
            }

            return redirect()->route('login')->with('status', 'Başvurunuz alındı. Yöneticilerimiz kimlik bilgilerinizi inceledikten sonra giriş bilgileriniz E-Posta adresinize gönderilecektir.');

        } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
            return redirect()->route('login')->with('status', 'Bu bilgilerle zaten bir kayıt mevcut.');
        }
    }
}