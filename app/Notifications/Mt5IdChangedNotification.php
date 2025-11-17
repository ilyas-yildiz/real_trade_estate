<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class Mt5IdChangedNotification extends Notification
{
    use Queueable;

    protected $newMt5Id;

    public function __construct($newMt5Id)
    {
        $this->newMt5Id = $newMt5Id;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'MetaTrader 5 (Giriş) ID numaranız yönetici tarafından güncellendi: ' . $this->newMt5Id,
            'link' => route('admin.dashboard'), // Kullanıcı dashboard'da yeni bilgisini görsün
            'icon' => 'ri-refresh-line',
            'color' => 'info',
        ];
    }
}