<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserNotification extends Notification
{
    use Queueable;

   protected $data;
    public function __construct($data) { $this->data = $data; }
    public function via(object $notifiable): array { return ['database']; }
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->data['user_name'] . ' adıyla yeni bir kullanıcı sisteme kaydoldu.',
            'link' => route('admin.users.index'),
            'icon' => 'ri-user-add-line',
            'color' => 'info',
            'request_id' => $this->data['user_id'], // Silme işlemi için
        ];
    }

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


}
