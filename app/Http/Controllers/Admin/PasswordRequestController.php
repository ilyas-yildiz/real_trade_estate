<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PasswordChangeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class PasswordRequestController extends Controller
{
    public function index()
    {
        // Sadece bekleyen talepleri getir
        $requests = PasswordChangeRequest::with('user')->where('status', 'pending')->latest()->paginate(10);
        return view('admin.password_requests.index', compact('requests'));
    }

    public function approve($id)
    {
        $request = PasswordChangeRequest::findOrFail($id);
        $user = $request->user;

        // Şifreyi çöz
        $newPasswordPlain = Crypt::decryptString($request->new_password_encrypted);

        // Kullanıcının hem Site hem MT5 şifresini güncelle
        $user->update([
            'password' => Hash::make($newPasswordPlain), // Site girişi için
            'mt5_password' => $request->new_password_encrypted // MT5 görüntüleme için (Zaten şifreliydi)
        ]);

        $request->update(['status' => 'approved']);

        return back()->with('success', 'Şifre değişikliği onaylandı ve kullanıcı güncellendi.');
    }

    public function reject($id)
    {
        $request = PasswordChangeRequest::findOrFail($id);
        $request->update(['status' => 'rejected']);
        return back()->with('success', 'Şifre değişikliği reddedildi.');
    }
}