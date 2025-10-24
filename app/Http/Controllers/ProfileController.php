<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

// GÜNCELLEME: Temel Controller'ı use ediyoruz (Bu sefer unutmadım, Cemo)
use Illuminate\Routing\Controller;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     * NOT: Bu metot artık kullanılmıyor, çünkü rotasını sildik.
     * Biz bunun yerine UserProfileController@index kullanıyoruz.
     * Ancak dosyanın orijinalinde olduğu için silmiyorum.
     */
    public function edit(Request $request): View
    {
        // Bu view artık yok, ama metot kalabilir.
        // Eğer bir şekilde bu metoda ulaşılırsa hata vermemesi için
        // bizim yeni profil sayfamıza yönlendirebiliriz.
        return redirect()->route('admin.profile.index');

        // Orijinal kod:
        // return view('profile.edit', [
        //     'user' => $request->user(),
        // ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // DEĞİŞİKLİK: Yönlendirme hedefi 'profile.edit' (silinen rota) yerine
        //            bizim yeni profil sayfamız 'admin.profile.index' olarak güncellendi.
        return Redirect::route('admin.profile.index')->with('success', 'Profil bilgileri başarıyla güncellendi.');
        // Orijinal Kod: return Redirect::route('profile.edit')->with('status', 'profile-updated');
        // Not: Session mesajını da 'status' yerine 'success' yaptım ki
        //      bizim profil sayfasındaki @if(session('success')) bloğu yakalasın.
    }

    /**
     * Delete the user's account.
     * NOT: Bu metot, eğer 'Hesabı Sil' formunu kullanırsak çalışacak.
     * Şu an kullanmıyoruz ama dokunmuyorum.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}