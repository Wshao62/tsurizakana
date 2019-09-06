<?php

namespace App\Notifications\Fish;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OfferRecievedNotification extends Notification
{
    use Queueable;

    protected $fish;
    protected $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($fish, $user)
    {
        $this->fish = $fish;
        $this->user = $user;
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
                    ->subject('あなたのオファーにより商品が売れました！')
                    ->markdown('mails.fish.offer_recieved', [
                        'fish' => $this->fish,
                        'user' => $this->user,
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
