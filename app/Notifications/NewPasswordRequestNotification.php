<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewPasswordRequestNotification extends Notification
{
    use Queueable;

    protected $requestData;

    public function __construct($requestData)
    {
        $this->requestData = $requestData; // Talebi yapan kullanıcının adı vb.
    }

    public function via(object $notifiable): array
    {
        return ['database']; // Sadece veritabanına kaydet
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->requestData['user_name'] . ' yeni bir şifre değişikliği talep etti.',
            'link' => route('admin.password_requests.index'), // Tıklayınca gideceği yer
            'icon' => 'ri-lock-password-line', // İkon
            'color' => 'warning', // Renk
            'request_id' => $this->requestData['request_id'] ?? null,
        ];
    }
}