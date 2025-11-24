<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountRejectedNotification extends Notification
{
    use Queueable;

    protected $reason;

    public function __construct($reason)
    {
        $this->reason = $reason;
    }

    public function via(object $notifiable): array
    {
        return ['mail']; // Reddedilen adam panele giremeyeceği için sadece mail
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Üyelik Başvurunuz Reddedildi')
            ->greeting('Merhaba,')
            ->line('Üyelik başvurunuz ne yazık ki onaylanmadı.')
            ->line('**Red Sebebi:** ' . $this->reason)
            ->line('Düzeltme yapmak veya bilgi almak için bizimle iletişime geçebilirsiniz.');
    }
}