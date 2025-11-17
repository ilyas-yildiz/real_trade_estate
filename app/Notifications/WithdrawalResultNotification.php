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
        $isApproved = $this->status === 'approved';
        
        return [
            'message' => number_format($this->amount, 2, ',', '.') . ' TL tutarındaki çekim talebiniz ' . ($isApproved ? 'ONAYLANDI.' : 'REDDEDİLDİ.'),
            'link' => route('admin.withdrawals.index'), // Müşteri tıklayınca kendi listesine gitsin
            'icon' => $isApproved ? 'ri-checkbox-circle-line' : 'ri-close-circle-line',
            'color' => $isApproved ? 'success' : 'danger',
        ];
    }
}