<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountRejectedNotification extends Notification
{
    use Queueable;

    public $reason; // Public yapıyoruz ki erişilebilsin

    public function __construct($reason)
    {
        $this->reason = $reason;
    }

    public function via(object $notifiable): array
    {
        return ['mail']; // Sadece mail yeterli, çünkü hesabı reddedildiği için panele giremez
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Üyelik Başvurunuz Hakkında - Real Trade Estate')
            ->greeting('Merhaba ' . $notifiable->name . ',')
            ->line('Real Trade Estate platformuna yaptığınız üyelik başvurusu incelenmiştir.')
            ->line('Ne yazık ki başvurunuz şu an için onaylanamamıştır.')
            ->line('**Red Sebebi:** ' . ($this->reason ?? 'Belirtilmedi.'))
            ->line('Eksiklikleri gidererek veya bizimle iletişime geçerek tekrar başvurabilirsiniz.')
            ->action('Bize Ulaşın', route('frontend.contact'));
    }
}