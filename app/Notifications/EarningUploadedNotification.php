<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class EarningUploadedNotification extends Notification
{
    use Queueable;

    protected $earningId;
    protected $title;

    public function __construct($earningId, $title)
    {
        $this->earningId = $earningId;
        $this->title = $title;
    }

    public function via(object $notifiable): array { return ['database']; }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Yönetici "' . $this->title . '" dosyası yükledi. Lütfen inceleyip onaylayınız.',
            'link' => route('bayi.earnings.index'), // Bayi hakediş listesi rotası (oluşturacağız)
            'icon' => 'ri-file-excel-2-line',
            'color' => 'info',
        ];
    }
}