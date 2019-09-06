<?php

namespace App\Notifications\Fish;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ChooseWisherNotification extends Notification
{
    use Queueable;

    private $fish;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($fish)
    {
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
        ->subject('購入希望の売魚の販売先があなたに決まりました。')
        ->markdown('mails.fish.choosed_wisher', [
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
