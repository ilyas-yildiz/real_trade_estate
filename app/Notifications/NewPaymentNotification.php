<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPaymentNotification extends Notification
{
    use Queueable;

  protected $data;
    public function __construct($data) { $this->data = $data; }
    public function via(object $notifiable): array { return ['database']; }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->data['user_name'] . ' (' . $this->data['amount'] . ' TL) yeni bir ödeme bildirimi yaptı.',
            'link' => route('admin.payments.index'),
            'icon' => 'ri-wallet-line',
            'color' => 'success',
            'request_id' => $this->data['payment_id'], // Silme işlemi için
        ];
    }

}
