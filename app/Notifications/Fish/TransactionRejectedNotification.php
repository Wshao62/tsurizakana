<?php

namespace App\Notifications\Fish;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TransactionRejectedNotification extends Notification
{
    use Queueable;

    protected $fish;
    protected $reject;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($fish, $reject)
    {
        $this->fish = $fish;
        $this->reject = $reject;
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
        $mail_message = (new MailMessage)
                        ->subject('お取引が中止となりました。')
                        ->markdown('mails.fish.reject', [
                            'fish' => $this->fish,
                            'reject' => $this->reject,
                            'user' => \Auth::user(),
                        ]);
        return $mail_message;
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
