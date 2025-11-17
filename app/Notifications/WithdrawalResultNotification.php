<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class WithdrawalResultNotification extends Notification
{
    use Queueable;

    protected $status;
    protected $amount;

    public function __construct($status, $amount)
    {
        $this->status = $status; // 'approved' veya 'rejected'
        $this->amount = $amount;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

   public function toArray(object $notifiable): array
    {
        // Duruma göre Mesaj, Renk ve İkon belirle
        $statusData = match($this->status) {
            'approved' => [
                'text' => 'ONAYLANDI',
                'color' => 'success',
                'icon' => 'ri-checkbox-circle-line'
            ],
            'rejected' => [
                'text' => 'REDDEDİLDİ',
                'color' => 'danger',
                'icon' => 'ri-close-circle-line'
            ],
            'processing' => [
                'text' => 'ÖDEME SÜRECİNE ALINDI',
                'color' => 'info', // Mavi
                'icon' => 'ri-loader-2-line' // Dönen yükleme ikonu
            ],
            default => [
                'text' => 'GÜNCELLENDİ',
                'color' => 'primary',
                'icon' => 'ri-information-line'
            ]
        };
        
        return [
            'message' => number_format($this->amount, 2, ',', '.') . ' TL tutarındaki çekim talebiniz ' . $statusData['text'] . '.',
            'link' => route('admin.withdrawals.index'),
            'icon' => $statusData['icon'],
            'color' => $statusData['color'],
        ];
    }
}