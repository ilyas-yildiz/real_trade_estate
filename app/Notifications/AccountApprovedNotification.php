<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Crypt;

class AccountApprovedNotification extends Notification
{
    use Queueable;

    public $user; // public yaptık

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        // Şifreyi çözmeyi dene, çözemezsen uyarı ver (Hata patlamasın diye try-catch)
        try {
            $plainPassword = Crypt::decryptString($this->user->mt5_password);
        } catch (\Exception $e) {
            $plainPassword = "Şifre çözülemedi, lütfen şifremi unuttum yapınız.";
        }

        return (new MailMessage)
            ->subject('Üyeliğiniz Onaylandı - Real Trade Estate')
            ->greeting('Merhaba ' . $this->user->name . ',')
            ->line('Hesap başvurunuz incelendi ve ONAYLANDI.')
            ->line('Aşağıdaki bilgilerle sisteme ve MetaTrader 5 platformuna giriş yapabilirsiniz:')
            ->line('---------------------------------')
            ->line('**Kullanıcı Adı (MT5 ID):** ' . $this->user->mt5_id)
            ->line('**Şifre:** ' . $plainPassword)
            ->line('---------------------------------')
            ->action('Giriş Yap', route('login'))
            ->line('Bol kazançlar dileriz!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Hesabınız onaylandı. Giriş yapabilirsiniz.',
            'link' => route('admin.dashboard'),
            'icon' => 'ri-check-double-line',
            'color' => 'success',
        ];
    }
}