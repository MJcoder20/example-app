<?php

namespace App\Notifications;

use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VendorNotification extends Notification
{
    use Queueable;

    protected Item $item;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->subject('Low Item Quantity Alert')
        ->line("The item '{$this->item->name}' has a quantity less than 50 in the inventory.")
        ->action('View Item Details', url('/items/' . $this->item->id))
        ->line('Thank you for using our service.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
