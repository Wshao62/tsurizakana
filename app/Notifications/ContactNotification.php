<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ContactNotification extends Notification
{
    use Queueable;

    private $data;
    private $admin;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data, $admin)
    {
        $this->data = $data;
        $this->admin = $admin;
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
        /**
        *
        * Function to switch between stuff and User
        *
        */
        if ($this->admin == true) {
            //担当者へのメールを送信
            $Mail_title = "お問い合わせ";
            $Mail_Message = (new MailMessage)
                          ->subject($Mail_title)
                          ->markdown('mails.admin.admin_contact', [
                            'data' => $this->data,
                          ]);
        } else {
            //お客様へのメールを送信
            $Mail_title = "お問い合わせいただき、ありがとうございます。";
            $Mail_Message = (new MailMessage)
                          ->subject($Mail_title)
                          ->markdown('mails.user_contact', [
                            'data' => $this->data,
                          ]);
        }
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
