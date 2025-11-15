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
        $user = Auth::user();

        // Admin ise, sekmeler için ayrı ayrı sorgula
        if ($user->isAdmin()) {
            
            $data['passwordRequests'] = $user->notifications()
                ->where('type', 'App\Notifications\NewPasswordRequestNotification')
                ->latest()->paginate(10, ['*'], 'pass_page'); // 'pass_page' ayrı sayfalama için
                
            $data['paymentRequests'] = $user->notifications()
                ->where('type', 'App\Notifications\NewPaymentNotification')
                ->latest()->paginate(10, ['*'], 'pay_page');
                
            $data['withdrawalRequests'] = $user->notifications()
                ->where('type', 'App\Notifications\NewWithdrawalNotification')
                ->latest()->paginate(10, ['*'], 'withdraw_page');
                
            $data['newUserRequests'] = $user->notifications()
                ->where('type', 'App\Notifications\NewUserNotification')
                ->latest()->paginate(10, ['*'], 'user_page');

        // Müşteri veya Bayi ise, tüm bildirimlerini tek listede al
        } else {
            $data['notifications'] = $user->notifications()->latest()->paginate(20);
        }
        
        return view('admin.notifications.index', $data);
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