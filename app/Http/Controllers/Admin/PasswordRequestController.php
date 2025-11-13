<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PasswordChangeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
// DÜZELTME: Eksik olan bildirim sınıfı eklendi
use App\Notifications\PasswordRequestResultNotification;

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
            'mt5_password' => $request->new_password_encrypted // MT5 görüntüleme için
        ]);

        $request->update(['status' => 'approved']);
        
        // Kullanıcıya bildirim gönder
        $user->notify(new PasswordRequestResultNotification('approved'));
        $this->markNotificationAsRead($id);

        return back()->with('success', 'Şifre değişikliği onaylandı ve kullanıcı güncellendi.');
    }

    public function reject($id)
    {
        $request = PasswordChangeRequest::findOrFail($id);
        
        $request->update(['status' => 'rejected']);
        
        // Kullanıcıya bildirim gönder
        $request->user->notify(new PasswordRequestResultNotification('rejected'));
        $this->markNotificationAsRead($id);

        return back()->with('success', 'Şifre değişikliği reddedildi.');
    }

    private function markNotificationAsRead($requestId)
    {
        // Tüm adminleri bul
        $admins = User::where('role', 2)->get();

        foreach ($admins as $admin) {
            // Adminin okunmamış bildirimlerini gez
            foreach ($admin->unreadNotifications as $notification) {
                // Eğer bildirim tipi 'NewPasswordRequestNotification' ise
                // VE bildirimin içindeki 'request_id' bizim işlem yaptığımız ID ise
                if ($notification->type === 'App\Notifications\NewPasswordRequestNotification' && 
                    isset($notification->data['request_id']) && 
                    $notification->data['request_id'] == $requestId) {
                    
                    // Bildirimi okundu olarak işaretle (sayıdan düşer)
                    $notification->markAsRead();
                }
            }
        }
    }
}