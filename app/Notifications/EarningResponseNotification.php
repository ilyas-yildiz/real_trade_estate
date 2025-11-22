<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class EarningResponseNotification extends Notification
{
    use Queueable;

    protected $bayiName;
    protected $title;
    protected $status;

    public function __construct($bayiName, $title, $status)
    {
        $this->bayiName = $bayiName;
        $this->title = $title;
        $this->status = $status;
    }

    public function via(object $notifiable): array { return ['database']; }

    public function toArray(object $notifiable): array
    {
        $statusText = $this->status === 'approved' ? 'ONAYLADI' : 'REDDETTİ';
        $color = $this->status === 'approved' ? 'success' : 'danger';
        $icon = $this->status === 'approved' ? 'ri-checkbox-circle-line' : 'ri-close-circle-line';

        return [
            'message' => $this->bayiName . ', "' . $this->title . '" hakedişini ' . $statusText . '.',
            // Admin hakediş listesi rotası (oluşturacağız)
            'link' => route('admin.earnings.index'), 
            'icon' => $icon,
            'color' => $color,
        ];
    }
}