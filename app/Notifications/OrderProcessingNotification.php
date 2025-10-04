<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderProcessingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private Order $order)
    {
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Order Processing')
            ->greeting('Hello '.$notifiable->name)
            ->line('Your order #'.$this->order->reference.' is processing.')
            ->action('View Order', route('dashboard.orders'));
    }

    public function toArray($notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'status' => $this->order->status,
            'message' => 'Order is processing',
        ];
    }
}
