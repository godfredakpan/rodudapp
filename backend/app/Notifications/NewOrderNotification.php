<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Orders;

class NewOrderNotification extends Notification
{
    use Queueable;

    private $order;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Orders $order
     */
    public function __construct(Orders $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database']; // Sends via email and stores in the database
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Truck Order Notification')
                    ->line('A new truck order has been created.')
                    ->line('Pickup Location: ' . $this->order->pickup_location)
                    ->line('Delivery Location: ' . $this->order->delivery_location)
                    ->line('Truck Size: ' . $this->order->truck_size)
                    ->line('Weight: ' . $this->order->weight . ' kg')
                    ->line('Pickup Time: ' . $this->order->pickup_time)
                    ->line('Delivery Time: ' . $this->order->delivery_time)
                    ->action('View Order', url('/dashboard/orders'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification for storage in the database.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'pickup_location' => $this->order->pickup_location,
            'delivery_location' => $this->order->delivery_location,
            'truck_size' => $this->order->truck_size,
            'weight' => $this->order->weight,
            'pickup_time' => $this->order->pickup_time,
            'delivery_time' => $this->order->delivery_time,
        ];
    }
}
