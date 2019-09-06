<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TempRegistNotification extends Notification
{
    use Queueable;

    protected $is_teaser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($is_teaser = false)
    {
        $this->is_teaser = $is_teaser;
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
        if ($this->is_teaser) {
            return (new MailMessage)->subject('事前登録ありがとうございます')
                ->markdown('mails.teaser_temp_regist_complete');
        } else {
            return (new MailMessage)->subject('ご登録ありがとうございます')
            ->markdown('mails.send_profile_regist_url', [
                'token' => $notifiable->token,
            ]);
        }
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
