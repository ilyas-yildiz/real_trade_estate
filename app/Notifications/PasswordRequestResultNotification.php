<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PasswordRequestResultNotification extends Notification
{
    use Queueable;

    protected $status;

    public function __construct($status)
    {
        $this->status = $status; // 'approved' veya 'rejected'
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $isApproved = $this->status === 'approved';
        return [
            'message' => $isApproved 
                ? 'Şifre değişikliği talebiniz ONAYLANDI.' 
                : 'Şifre değişikliği talebiniz REDDEDİLDİ.',
            'link' => route('admin.dashboard'),
            'icon' => $isApproved ? 'ri-check-double-line' : 'ri-close-circle-line',
            'color' => $isApproved ? 'success' : 'danger',
        ];
    }
}