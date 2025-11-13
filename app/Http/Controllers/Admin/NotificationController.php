<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * YENİ: Tüm bildirimleri listeler.
     */
    public function index()
    {
        // Tüm bildirimleri (okunmuş/okunmamış) al ve sayfala
        $notifications = Auth::user()->notifications()->paginate(20);
        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * GÜNCELLENDİ: Bildirime tıklama mantığı.
     */
    public function markAsReadAndRedirect($id)
    {
        $notification = Auth::user()->notifications()->find($id);

        if ($notification) {
            
            $user = Auth::user();
            $isPasswordRequest = $notification->type === 'App\Notifications\NewPasswordRequestNotification';

            // MANTIK DEĞİŞİKLİĞİ:
            // Eğer kullanıcı Admin ise VE bu bir "Şifre Talebi" ise:
            // Okundu olarak işaretleME, sadece yönlendir. 
            // (Çünkü admin onay/red verince silinecek)
            if ($user->isAdmin() && $isPasswordRequest) {
                // Hiçbir şey yapma (Okundu işaretleme)
            } 
            else {
                // Diğer durumlarda (Müşteri ise veya sadece bilgi mesajıysa) okundu yap
                $notification->markAsRead();
            }
            
            // Hedefe yönlendir
            return redirect($notification->data['link'] ?? route('admin.dashboard'));
        }

        return back();
    }
    
    /**
     * Tüm bildirimleri okundu işaretler.
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Tüm bildirimler okundu olarak işaretlendi.');
    }
    
    /**
     * YENİ: Tekil bildirimi silme (Listeden silmek için)
     */
    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->find($id);
        if ($notification) {
            $notification->delete();
            return back()->with('success', 'Bildirim silindi.');
        }
        return back()->with('error', 'Bildirim bulunamadı.');
    }
}