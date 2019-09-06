<?php

namespace App\Notifications\Fish;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WisherNotification extends Notification
{
    use Queueable;

    private $wisher;
    private $fish;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($wisher, $fish)
    {
        $this->wisher = $wisher;
        $this->fish = $fish;
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
        ->subject('出品している魚に購入を希望している人がいます！')
        ->markdown('mails.fish.wisher', [
            'user' => $notifiable,
            'wisher' => $this->wisher,
            'fish' => $this->fish,
            ]);
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
