<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PioneerNotification extends Notification
{
    use Queueable;

    private $form;

    /**
     * PioneerNotification constructor.
     *
     * @param $form
     */
    public function __construct($form)
    {
        $this->form = $form;
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
        $Mail_title = "【飲食店開拓希望】（{$this->form['shop_name']}）";
        $Mail_Message = (new MailMessage)
            ->subject($Mail_title)
            ->markdown('mails.pioneer', [
                'form' => $this->form,
            ]);
        return $Mail_Message;
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
